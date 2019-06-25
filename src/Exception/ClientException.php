<?php

namespace stlswm\WxMp\Exception;

/**
 * Class ClientException
 *
 * @package Exception
 */
class ClientException extends WeChatPaymentException
{
    /**
     * ClientException constructor.
     *
     * @param string          $errorMessage
     * @param string          $errorCode
     * @param \Exception|null $previous
     */
    public function __construct($errorMessage, $errorCode, $previous = null)
    {
        parent::__construct($errorMessage, 0, $previous);
        $this->errorMessage = $errorMessage;
        $this->errorCode = $errorCode;
    }

    /**
     * @codeCoverageIgnore
     *
     * @deprecated deprecated since version 2.0.
     *
     * @return string
     */
    public function getErrorType()
    {
        return 'Client';
    }
}