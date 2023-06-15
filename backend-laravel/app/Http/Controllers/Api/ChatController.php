<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Message;
use App\Events\ChatEvents;
use App\Models\Conversation;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\ConversationWithUserResource;
use App\Repositories\User\UserRepository;
use App\Http\Resources\Admin\UserResource;
use App\Http\Resources\Shop\MessageResource;
use App\Http\Resources\Shop\ConversationResource;

class ChatController extends Controller
{
    public function __construct(UserRepository $repoUser)
    {
        $this->middleware('auth:api');
        $this->user = $repoUser;
    }

    public function index()
    {
        $user = User::first();
        // event(new ChatEvents("hello abc cao van sơn", $user));
        // broadcast(new ChatEvents("hello abc cao van sơn", $user));
    }

    public function messages($id, $member_id)
    {
        $user_id = JWTAuth::parseToken()->authenticate()->id;
        $data = Conversation::where("member_id", $member_id)->where("user_id", $user_id)->with(['messages'])->first();
        if (!$data) {
            $data = Conversation::where("member_id", $user_id)->where("user_id", $member_id)->with(['messages'])->first();
            if (!$data) {
                $data = Conversation::create([
                    "member_id" => $member_id,
                    "user_id" => $user_id,
                    "room_status" => 1,
                    "member_status" => 1,
                ]);
                $data->with(['messages', 'sender']);
            }
        }

        return response()->json([
            "data" => new ConversationResource($data),
        ], 200);
    }

    public function store(Request $request, $id)
    {
        $user_id = JWTAuth::parseToken()->authenticate()->id;

        $conversation = Conversation::where("member_id", $id)->where("user_id", $user_id)->first();
        if (!$conversation) {
            $conversation = Conversation::where("member_id", $user_id)->where("user_id", $id)->first();
        }
        // dd($conversation);
        $message = $conversation->messages()->create([
            "content" => $request->content,
            "user_id" => $user_id,
            "parent_id" => $request->parent_id ?? 0,
        ]);

        event(new ChatEvents($message, $user_id, $id));

        return response()->json([
            "data" => new MessageResource($message),
        ], 200);
    }

    public function get_technical_support()
    {
        $data = $this->user->get_technical_support();

        return response()->json([
            "data" => UserResource::collection($data),
            "code" => 200
        ], 200);
    }

    public function get_users_chat()
    {
        $user_id = JWTAuth::parseToken()->authenticate()->id;

        $data = Conversation::where("user_id", $user_id)
            ->orWhere("member_id", $user_id)
            ->with(['user', 'member'])
            ->distinct()->get();

        // dd($data);

        return response()->json([
            "data" => ConversationWithUserResource::collection($data, $user_id),
            "code" => 200
        ], 200);
    }
}
