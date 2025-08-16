<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bookmark extends Model
{
    use SoftDeletes;
    protected $table = 'bookmarks';
    protected $fillable = [
        'user_id',
        'post_id'
    ];
}
