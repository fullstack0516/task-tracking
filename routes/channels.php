<?php

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

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('App.Models.Project.{projectId}', function ($user, $projectId) {
    return true;
});

Broadcast::channel('projects.{projectId}', function ($user, $projectId) {
    return true;
});

Broadcast::channel('project.{projectId}', function ($user, $projectId) {
    return true;
});

Broadcast::channel('App.Models.Task.{taskId}', function ($user, $taskId) {
    return true;
});

Broadcast::channel('tasks.{taskId}', function ($user, $taskId) {
    return true;
});
