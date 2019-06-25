<?php

namespace stlswm\WxMp\Request;

use function implode;
use const PHP_OS;
use const PHP_VERSION;
use stlswm\WxMp\WeChatPay;

/**
 * Class UserAgent
 *
 * @package stlswm\WxMp\Request
 */
class UserAgent
{

    /**
     * @var array
     */
    private static $userAgent = [];

    /**
     * @var array
     */
    private static $guard = [
        'client',
        'php',
    ];

    /**
     * UserAgent constructor.
     */
    private static function defaultFields()
    {
        if (self::$userAgent === []) {
            self::$userAgent = [
                'Client' => WeChatPay::VERSION,
                'PHP'    => PHP_VERSION,
            ];
        }
    }

    /**
     * @param array $append
     *
     * @return string
     */
    public static function toString(array $append = [])
    {
        self::defaultFields();

        $os = PHP_OS;
        $os_version = php_uname('r');
        $os_mode = php_uname('m');
        $userAgent = "WeChatPayment ($os $os_version; $os_mode) ";

        $newUserAgent = [];

        $append = self::clean($append);

        $append = array_merge(self::$userAgent, $append);

        foreach ($append as $key => $value) {
            if ($value === null) {
                $newUserAgent[] = $key;
                continue;
            }
            $newUserAgent[] = "$key/$value";
        }

        return $userAgent . implode(' ', $newUserAgent);
    }

    /**
     * @param array $append
     *
     * @return array
     */
    public static function clean(array $append)
    {
        foreach ($append as $key => $value) {
            if (self::isGuarded($key)) {
                unset($append[$key]);
                continue;
            }
        }

        return $append;
    }

    /**
     * @param $name
     * @param $value
     *
     * @Author: wm
     * @Date  : 19-2-26
     * @Time  : 下午3:34
     */
    public static function append($name, $value)
    {
        self::defaultFields();

        if (!self::isGuarded($name)) {
            self::$userAgent[$name] = $value;
        }
    }

    /**
     * @param array $userAgent
     */
    public static function with(array $userAgent)
    {
        self::$userAgent = self::clean($userAgent);
    }

    /**
     * Clear all of the User Agent.
     */
    public static function clear()
    {
        self::$userAgent = [];
    }

    /**
     * @param $name
     *
     * @return bool
     */
    public static function isGuarded($name)
    {
        return in_array(strtolower($name), self::$guard, true);
    }
}
