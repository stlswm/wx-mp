<?php

namespace stlswm\WxMp\Signature;

/**
 * Interface SignatureInterface
 *
 * @package stlswm\WxMp\Signature
 */
interface SignatureInterface
{
    /**
     * @return string
     */
    public function getMethod();

    /**
     * @return string
     */
    public function getVersion();

    /**
     * @param string $string
     * @param string $accessKeySecret
     *
     * @return string
     */
    public function sign($string, $accessKeySecret);

    /**
     * @return string
     */
    public function getType();
}