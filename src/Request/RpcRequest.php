<?php

namespace stlswm\WxMp\Request;

use stlswm\WxMp\Traits\DataTransferTrait;
use function strpos;

/**
 * Class RpcRequest
 *
 * RESTful RPC Request.
 *
 * @package stlswm\WxMp\Request
 * @mixin DataTransferTrait
 */
class RpcRequest extends Request
{
    use DataTransferTrait;
    /**
     * @var string
     */
    private $dateTimeFormat = 'Y-m-d\TH:i:s\Z';

    /**
     * Resolve request parameter.
     */
    public function resolveParameters()
    {
        $this->options['query']['sign'] = $this->signature(
            $this->options['query'],
            $this->httpClient()->secret
        );

        if ($this->method === 'POST') {
            switch ($this->inputFormat) {
                case 'XML':
                    $this->body(self::arrayToXml($this->options['query']));
                    break;
                case 'JSON':
                    $this->jsonBody($this->options['query']);
                    break;
                default:
                    foreach ($this->options['query'] as $apiParamKey => $apiParamValue) {
                        $this->options['form_params'][$apiParamKey] = $apiParamValue;
                    }
            }
            unset($this->options['query']);
        }
    }

    /**
     * Sign the parameters.
     *
     * @param $parameters
     * @param $accessKeySecret
     *
     * @return string
     * @Author: wm
     * @Date  : 19-2-27
     * @Time  : 下午1:47
     */
    private function signature($parameters, $accessKeySecret)
    {
        ksort($parameters);
        $tmpStr = '';
        foreach ($parameters as $key => $value) {
            if ($key != 'sign' && $value != '' && !is_array($value)) {
                $tmpStr .= $key . '=' . $value . '&';
            }
        }
        $this->stringToBeSigned = substr($tmpStr, 0, -1) . '&key=' . $accessKeySecret;
        return $this->httpClient()
            ->getSignature()
            ->sign($this->stringToBeSigned, $accessKeySecret);
    }

    /**
     * Magic method for set or get request parameters.
     *
     * @param string $name
     * @param mixed  $arguments
     *
     * @return $this
     */
    public function __call($name, $arguments)
    {
        if (strpos($name, 'get') !== FALSE) {
            $parameterName = $this->propertyNameByMethodName($name);
            return $this->__get($parameterName);
        }

        if (strpos($name, 'with') !== FALSE) {
            $parameterName = $this->propertyNameByMethodName($name, 4);
            $this->__set($parameterName, $arguments[0]);
            $this->options['query'][$parameterName] = $arguments[0];
        }

        return $this;
    }
}
