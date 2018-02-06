<?php

/**
 * Desc: 课程格式化
 * Created by PhpStorm.
 * User: jason-gao
 * Date: 2018/2/2 12:05
 */
namespace App\Api\Transformers;

use App\Lesson;
use League\Fractal\TransformerAbstract;

class LessonTransformer extends TransformerAbstract
{

    public function transform(Lesson $lesson)
    {
        return [
            'title'   => $lesson['title'],
            'content' => $lesson['body'],
            'if_free' => (boolean)$lesson['free']
        ];
    }
}