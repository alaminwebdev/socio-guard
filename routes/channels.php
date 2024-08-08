<?php

use App\Model\Participant\ParticipantGroup;

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

// Broadcast::channel('App.User.{id}', function ($user, $id) {
//     return (int) $user->id === (int) $id;
// });


// Broadcast::channel('group.{group_no}', function ($user) {
// 	return true;
// });

Broadcast::channel('group.{group}', function ($user, ParticipantGroup $group) {
   	return $group->hasUser($user->id);
});