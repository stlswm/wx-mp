<?php

namespace stlswm\WxMp\Signature;

use const OPENSSL_ALGO_SHA256;
use stlswm\WxMp\Exception\ClientException;
use Exception;
use const WX_MP_INVALID_CREDENTIAL;

/**
 * Class ShaHmac256WithRsaSignature
 *
 * @package WeChatPayment\Client\Signature
 */
class ShaHmac256WithRsaSignature implements SignatureInterface
{

    /**
     * @param string $string
     * @param string $privateKey
     *
     * @return string
     * @throws ClientException
     */
    public function sign($string, $privateKey)
    {
        $binarySignature = '';
        try {
            openssl_sign(
                $string,
                $binarySignature,
                $privateKey,
                OPENSSL_ALGO_SHA256
            );
        } catch (Exception $exception) {
            throw  new ClientException(
                $exception->getMessage(),
                WX_MP_INVALID_CREDENTIAL
            );
        }

        return base64_encode($binarySignature);
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return 'SHA256withRSA';
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
        return 'PRIVATEKEY';
    }
}