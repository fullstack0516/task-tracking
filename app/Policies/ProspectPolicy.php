<?php

namespace App\Policies;

use App\Models\Prospect;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProspectPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->hasTeamPermission($user->currentTeam, 'prospect:read');
    }

    public function view(User $user, Prospect $prospect)
    {
        return $user->hasTeamPermission($user->currentTeam, 'prospect:read')
            && $prospect->team_id === $user->currentTeam->id;
    }

    public function create(User $user)
    {
        return $user->hasTeamPermission($user->currentTeam, 'prospect:create');
    }

    public function update(User $user, Prospect $prospect)
    {
        return $user->hasTeamPermission($user->currentTeam, 'prospect:update')
            && $prospect->team_id === $user->currentTeam->id;
    }

    public function delete(User $user, Prospect $prospect)
    {
        return $user->hasTeamPermission($user->currentTeam, 'prospect:delete')
            && $prospect->team_id === $user->currentTeam->id;
    }
}
