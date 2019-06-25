<?php

namespace stlswm\WxMp\Signature;

/**
 * Class MD5
 *
 * @package stlswm\WxMp\Signature
 */
class MD5 implements SignatureInterface
{

    /**
     * @param string $string
     * @param string $accessKeySecret
     *
     * @return string
     */
    public function sign($string, $accessKeySecret)
    {
        return strtoupper(md5($string));
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return 'MD5';
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return '1.0';
    }

    /**
     * @return string
     */
    public function getType()
    {
        return '';
    }
}
