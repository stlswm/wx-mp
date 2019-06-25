<?php

namespace stlswm\WxMp\Signature;

/**
 * Class ShaHmac256Signature
 *
 * @package stlswm\WxMp\Signature
 */
class ShaHmac256Signature implements SignatureInterface
{

    /**
     * @param string $string
     * @param string $accessKeySecret
     *
     * @return string
     */
    public function sign($string, $accessKeySecret)
    {
        return strtoupper(hash_hmac('sha256', $string, $accessKeySecret));
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return 'HMAC-SHA256';
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
