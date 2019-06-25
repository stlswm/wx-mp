<?php

namespace stlswm\WxMp\Result;

use ArrayAccess;
use Countable;
use IteratorAggregate;
use stlswm\WxMp\Request\Request;
use stlswm\WxMp\Traits\DataTransferTrait;
use stlswm\WxMp\Traits\HasDataTrait;
use GuzzleHttp\Psr7\Response;
use function strtoupper;


/**
 * Class Result
 *
 * Result from WeChat Cloud
 *
 * @package WeChatPayment\Client\Result
 * @mixin HasDataTrait
 * @mixin DataTransferTrait
 */
class Result implements ArrayAccess, IteratorAggregate, Countable
{
    use HasDataTrait;
    use DataTransferTrait;

    /**
     * Instance of the response.
     *
     * @var Response
     */
    protected $response;

    /**
     * Instance of the request.
     *
     * @var Request
     */
    protected $request;

    /**
     * Result constructor.
     *
     * @param Response $response
     * @param Request  $request
     */
    public function __construct(Response $response, Request $request = null)
    {
        $format = ($request instanceof Request) ? strtoupper($request->outputFormat) : 'XML';

        switch ($format) {
            case 'JSON':
                $data = self::jsonToArray($response->getBody()->getContents());
                break;
            case 'XML':
                $data = self::xmlToArray($response->getBody()->getContents());
                break;
            case 'RAW':
                $data = self::jsonToArray($response->getBody()->getContents());
                break;
            default:
                $data = self::jsonToArray($response->getBody()->getContents());
        }

        if (empty($data)) {
            $data = [];
        }

        $this->dot($data);
        $this->response = $response;
        $this->request = $request;
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @return bool
     */
    public function isSuccess()
    {
        return 200 <= $this->response->getStatusCode()
            && 300 > $this->response->getStatusCode();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->response->getBody();
    }
}
