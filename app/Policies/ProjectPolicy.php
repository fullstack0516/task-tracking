<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->hasTeamPermission($user->currentTeam, 'project:read');
    }

    public function view(User $user, Project $project)
    {
        return $user->hasTeamPermission($user->currentTeam, 'project:read')
            && $project->team_id === $user->currentTeam->id;
    }

    public function create(User $user)
    {
        return $user->hasTeamPermission($user->currentTeam, 'project:create');
    }

    public function update(User $user, Project $project)
    {
        return $user->hasTeamPermission($user->currentTeam, 'project:update')
            && $project->team_id === $user->currentTeam->id;
    }

    public function delete(User $user, Project $project)
    {
        return $user->hasTeamPermission($user->currentTeam, 'project:delete')
            && $project->team_id === $user->currentTeam->id;
    }
}
