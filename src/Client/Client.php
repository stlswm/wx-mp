<?php

namespace stlswm\WxMp\Client;


use stlswm\WxMp\Signature\MD5;
use stlswm\WxMp\Signature\ShaHmac256Signature;
use stlswm\WxMp\Signature\SignatureInterface;

/**
 * Class Client
 *
 * @package WeChatPayment
 */
class Client
{
    /**
     * @var string
     */
    public $appId;
    /**
     * @var string
     */
    public $secret;

    /**
     * @var SignatureInterface
     */
    protected $signature;

    /**
     * Client constructor.
     *
     * @param string $appId
     * @param string $secret
     */
    public function __construct(string $appId, string $secret)
    {
        $this->appId = $appId;
        $this->secret = $secret;
    }

    /**
     * @param string $type
     *
     * @Author: wm
     * @Date  : 19-2-27
     * @Time  : 上午10:08
     */
    public function setSignature(string $type)
    {
        switch ($type) {
            case 'MD5':
                $this->signature = new MD5();
                break;
            case 'HMAC-SHA256':
                $this->signature = new ShaHmac256Signature();
                break;
            default:
                $this->signature = new MD5();
        }
    }

    /**
     * @return SignatureInterface
     */
    public function getSignature()
    {
        return $this->signature;
    }
}