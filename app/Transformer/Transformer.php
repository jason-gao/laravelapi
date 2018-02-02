<?php

/**
 * Desc: 格式化数据抽象类
 * Created by PhpStorm.
 * User: jason-gao
 * Date: 2018/2/2 12:01
 */
namespace App\Transformer;

abstract class Transformer
{
    public function transformCollection($items){
        return array_map([$this, 'transform'], $items);
    }

    public abstract function transform($item);
}