<?php

namespace stlswm\WxMp\Request\Traits;

use function mb_strcut;
use stlswm\WxMp\Request\Request;


/**
 * Trait MagicTrait
 *
 * @package WeChatPayment\Client\Request\Traits
 * @mixin Request
 */
trait MagicTrait
{
    /**
     * @param string $methodName
     * @param int    $start
     *
     * @return string
     */
    protected function propertyNameByMethodName($methodName, $start = 3)
    {
        return mb_strcut($methodName, $start);
    }
}
