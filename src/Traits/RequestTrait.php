<?php

namespace stlswm\WxMp\Traits;

use stlswm\WxMp\Client\Client;
use stlswm\WxMp\WeChatPay;
use stlswm\WxMp\Request\RpcRequest;
use stlswm\WxMp\Request\UserAgent;

/**
 * Trait RequestTrait
 *
 * @package stlswm\WxMp\Traits
 * @mixin     WeChatPay
 */
trait RequestTrait
{
    /**
     * @param string $name
     * @param string $value
     */
    public static function appendUserAgent($name, $value)
    {
        UserAgent::append($name, $value);
    }

    /**
     * @param array $userAgent
     */
    public static function withUserAgent(array $userAgent)
    {
        UserAgent::with($userAgent);
    }

    /**
     * @param Client $client
     * @param array  $options
     *
     * @return RpcRequest
     * @Author: wm
     * @Date  : 19-2-27
     * @Time  : 上午9:41
     */
    public static function rpcRequest(Client $client, array $options = [])
    {
        return new RpcRequest($client, $options);
    }
}
