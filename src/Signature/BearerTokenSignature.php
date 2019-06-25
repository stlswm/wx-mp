<?php

namespace stlswm\WxMp\Signature;

/**
 * Class BearerTokenSignature
 *
 * @package stlswm\WxMp\Signature
 */
class BearerTokenSignature implements SignatureInterface
{

    /**
     * @param string $string
     * @param string $accessKeySecret
     *
     * @return string
     */
    public function sign($string, $accessKeySecret)
    {
        return '';
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return '';
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
        return 'BEARERTOKEN';
    }
}
