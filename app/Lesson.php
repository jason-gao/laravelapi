<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Lesson
 *
 * @mixin \Eloquent
 */
class Lesson extends Model
{
    //
    protected $fillable = [
        'title',
        'body',
        'free'
    ];
}
