<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'parent_id',
        'user_id',
        'conversation_id',
        'status'
    ];

    public function getCreatedAtAttribute($date)
    {
        return Carbon::parse($date)->setTimezone('Asia/Ho_Chi_Minh');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reply()
    {
        return $this->belongsTo(Message::class, "parent_id", "id");
    }
}
