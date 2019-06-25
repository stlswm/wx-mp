<?php

namespace stlswm\WxMp\Traits;

use Exception;
use InvalidArgumentException;

/**
 * Trait DataTransferTrait
 *
 * @package stlswm\WxMp\Traits
 */
trait DataTransferTrait
{
    /**
     * @param array $data
     *
     * @return string
     * @Author: wm
     * @Date  : 19-2-27
     * @Time  : 下午2:32
     */
    public static function arrayToXml(array $data): string
    {
        $xml = "<xml>";
        foreach ($data as $key => $val) {
            if (is_integer($val) || is_float($val)) {
                $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
            } else {
                $xml .= "<" . $key . "><![CDATA[" . $val . "]]></" . $key . ">";
            }
        }
        $xml .= "</xml>";
        return $xml;
    }

    /**
     * @param string $data
     *
     * @return array
     * @Author: wm
     * @Date  : 19-2-27
     * @Time  : 下午2:32
     */
    public static function xmlToArray(string $data): array
    {
        try {
            return json_decode(json_encode(simplexml_load_string($data, 'SimpleXMLElement', LIBXML_NOCDATA)), TRUE);
        } catch (Exception $exception) {
            return [];
        }
    }

    /**
     * @param string $data
     *
     * @return array
     */
    private function jsonToArray(string $data): array
    {
        try {
            return \GuzzleHttp\json_decode($data, TRUE);
        } catch (InvalidArgumentException $e) {
            return [];
        }
    }
}