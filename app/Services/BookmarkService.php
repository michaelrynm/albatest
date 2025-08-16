<?php

namespace App\Services;

use App\Models\Bookmark;
use App\Models\Post;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class BookmarkService
{
    public function toggle($user, Post $post): string
    {
        // Cari pivot termasuk yang terhapus
        $pivot = Bookmark::withTrashed()
            ->where('user_id', $user->id)
            ->where('post_id', $post->id)
            ->first();

        if ($pivot) {
            if ($pivot->trashed()) {
                $pivot->restore();
                return 'bookmarked';
            }
            $pivot->delete();
            return 'unbookmarked';
        }

        Bookmark::create(['user_id' => $user->id, 'post_id' => $post->id]);
        return 'bookmarked';
    }

    public function list($user, int $perPage = 10): LengthAwarePaginator
    {
        return $user->bookmarkedPosts()
            ->with(['author','category'])
            ->latest()
            ->paginate($perPage);
    }
}
