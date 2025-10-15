<?php

namespace App\Policies;

use App\Models\User;
use App\Models\SocialMediaLink;
use Illuminate\Auth\Access\HandlesAuthorization;

class SocialMediaLinkPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_social::media::link');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, SocialMediaLink $socialMediaLink): bool
    {
        return $user->can('view_social::media::link');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_social::media::link');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, SocialMediaLink $socialMediaLink): bool
    {
        return $user->can('update_social::media::link');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, SocialMediaLink $socialMediaLink): bool
    {
        return $user->can('delete_social::media::link');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_social::media::link');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, SocialMediaLink $socialMediaLink): bool
    {
        return $user->can('force_delete_social::media::link');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_social::media::link');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, SocialMediaLink $socialMediaLink): bool
    {
        return $user->can('restore_social::media::link');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_social::media::link');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, SocialMediaLink $socialMediaLink): bool
    {
        return $user->can('replicate_social::media::link');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_social::media::link');
    }
}
