<?php

namespace App\Policies;

use App\Models\Client;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClientPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->hasTeamPermission($user->currentTeam, 'client:read');
    }

    public function view(User $user, Client $client)
    {
        return $user->hasTeamPermission($user->currentTeam, 'client:read')
            && $client->team_id === $user->currentTeam->id;
    }

    public function create(User $user)
    {
        return $user->hasTeamPermission($user->currentTeam, 'client:create');
    }

    public function update(User $user, Client $client)
    {
        return $user->hasTeamPermission($user->currentTeam, 'client:update')
            && $client->team_id === $user->currentTeam->id;
    }

    public function delete(User $user, Client $client)
    {
        return $user->hasTeamPermission($user->currentTeam, 'client:delete')
            && $client->team_id === $user->currentTeam->id;
    }
}
