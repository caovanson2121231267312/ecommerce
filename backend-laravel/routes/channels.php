<?php

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('public', function ($user) {
    Log::build([
        'driver' => 'single',
        'path' => storage_path('logs/broadcast.log'),
    ])->info($user);
    return true;
});

Broadcast::channel('sendToUser.{id}', function ($user, $id) {
    return true;
    Log::build([
        'driver' => 'single',
        'path' => storage_path('logs/broadcast.log'),
    ])->info($user . " " . $id);
    return true;
    // return (int) $user->id === (int) $id;
});

Broadcast::channel('sendToSender.{id}', function ($user, $id) {
    return true;
    Log::build([
        'driver' => 'single',
        'path' => storage_path('logs/broadcast.log'),
    ])->info($user . " " . $id);
    return true;
    // return (int) $user->id === (int) $id;
});

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    // return true;
    Log::build([
        'driver' => 'single',
        'path' => storage_path('logs/broadcast.log'),
    ])->info($user . " " . $id);
    return (int) $user->id === (int) $id;
});
