<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PostService
{
    public function paginate(array $filters, int $perPage = 10):LengthAwarePaginator
    {
        $query = Post::query()->with('author', 'category')->latest();

        if(!empty($filters['category_id'])){
            $query->where('category_id', $filters['category_id']);
        }

        if (!empty($filters['search'])) {
            $s = $filters['search'];
            $query->where(function($w) use ($s){
                $w->where('title','like',"%$s%")
                  ->orWhere('content','like',"%$s%");
            });
        }
         return $query->paginate($perPage);
    }


    public function store(array $data, $user, ?\Illuminate\Http\UploadedFile $cover = null): Post
    {
        $post = Post::create([
            'user_id'     => $user->id,
            'category_id' => $data['category_id'],
            'title'       => $data['title'],
            'content'     => $data['content'],
        ]);

        if ($cover) {
            $post->addMedia($cover)->toMediaCollection('cover');
        }

        return $post->load(['author','category']);
    }

     public function update(Post $post, array $data, ?\Illuminate\Http\UploadedFile $cover = null): Post
    {
        $post->update($data);

        if ($cover) {
            $post->clearMediaCollection('cover');
            $post->addMedia($cover)->toMediaCollection('cover');
        }

        return $post->load(['author','category']);
    }

    public function delete(Post $post): void
    {
        $post->delete();
    }

}
