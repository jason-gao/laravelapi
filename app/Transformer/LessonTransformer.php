<?php

/**
 * Desc: 课程格式化
 * Created by PhpStorm.
 * User: jason-gao
 * Date: 2018/2/2 12:05
 */
namespace App\Transformer;

class LessonTransformer extends Transformer
{

    public function transform($lesson)
    {
        return [
            'title'   => $lesson['title'],
            'content' => $lesson['body'],
            'if_free' => (boolean)$lesson['free']
        ];
    }
}