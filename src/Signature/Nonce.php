<?php

namespace stlswm\WxMp\Signature;

/**
 * Class Nonce
 *
 * @package stlswm\Signature
 */
class Nonce
{
    /**
     * @var string
     */
    protected static $seek = '01234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    /**
     * 32位随机字符串
     *
     * @return string
     * @Author: wm
     * @Date  : 19-2-26
     * @Time  : 下午4:46
     */
    public static function str32(): string
    {
        return substr(str_shuffle(self::$seek), 0, 32);
    }
}