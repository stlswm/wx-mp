<?php

namespace stlswm\WxMp\Exception;

use Exception;

/**
 * Class WeChatPaymentException
 *
 * @package Exception
 */
class WeChatPaymentException extends Exception
{
    /**
     * @var string
     */
    protected $errorCode;

    /**
     * @var string
     */
    protected $errorMessage;

    /**
     * @return string
     */
    public function getErrorCode()
    {
        return $this->errorCode;
    }

    /**
     * @param $errorCode
     *
     * @Author: wm
     * @Date  : 19-2-21
     * @Time  : 上午9:34
     */
    public function setErrorCode($errorCode)
    {
        $this->errorCode = $errorCode;
    }

    /**
     * @return string
     * @Author: wm
     * @Date  : 19-2-21
     * @Time  : 上午9:34
     */
    public function getErrorMessage()
    {
        return $this->errorMessage;
    }

    /**
     * @param $errorMessage
     *
     * @Author: wm
     * @Date  : 19-2-21
     * @Time  : 上午9:34
     */
    public function setErrorMessage($errorMessage)
    {
        $this->errorMessage = $errorMessage;
    }

    /**
     * @Author: wm
     * @Date  : 19-2-21
     * @Time  : 上午9:34
     */
    public function setErrorType()
    {
    }
}