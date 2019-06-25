<?php

namespace stlswm\WxMp\Request;

use ArrayAccess;
use function GuzzleHttp\Psr7\parse_query;
use function is_array;
use function is_object;
use function json_encode;
use stlswm\WxMp\Exception\ClientException;
use stlswm\WxMp\Exception\ServerException;
use stlswm\WxMp\Http\GuzzleTrait;
use stlswm\WxMp\Request\Traits\MagicTrait;
use stlswm\WxMp\Result\Result;
use stlswm\WxMp\Traits\ArrayAccessTrait;
use stlswm\WxMp\Traits\ObjectAccessTrait;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Uri;
use function strtolower;
use function strtoupper;
use const WX_MP_SERVER_UNREACHABLE;


/**
 * Class Request
 *
 * @package WeChatPayment\Client\Request
 * @method string resolveParameters()
 */
abstract class Request implements ArrayAccess
{
    use GuzzleTrait;
    use MagicTrait;
    use ArrayAccessTrait;
    use ObjectAccessTrait;

    /**
     * @var string
     */
    public $scheme = 'http';

    /**
     * @var string
     */
    public $method = 'GET';

    /**
     * @var string
     */
    public $inputFormat = 'XML';


    /**
     * @var string
     */
    public $outputFormat = 'XML';

    /**
     * @var \stlswm\WxMp\Client\Client
     */
    private $client;

    /**
     * @var Uri
     */
    public $uri;

    /**
     * @var Client
     */
    public $guzzle;

    /**
     * @var array The original parameters of the request.
     */
    public $data = [];

    /**
     * @var string
     */
    protected $stringToBeSigned = '';

    /**
     * @var array
     */
    private $userAgent = [];

    /**
     * Request constructor.
     *
     * @param \stlswm\WxMp\Client\Client $client
     * @param array                      $options
     */
    public function __construct(\stlswm\WxMp\Client\Client $client, array $options = [])
    {
        $this->client = $client;
        $this->uri = new Uri();
        $this->uri = $this->uri->withScheme($this->scheme);
        $this->guzzle = new Client();
        $this->options['http_errors'] = FALSE;
        $this->options['timeout'] = WECHAT_CLOUD_TIMEOUT;
        $this->options['connect_timeout'] = WECHAT_CLOUD_CONNECT_TIMEOUT;

        if ($options !== []) {
            $this->options($options);
        }
    }

    /**
     * @param string $name
     * @param string $value
     *
     * @return $this
     */
    public function appendUserAgent($name, $value)
    {
        if (!UserAgent::isGuarded($name)) {
            $this->userAgent[$name] = $value;
        }

        return $this;
    }

    /**
     * @param array $userAgent
     *
     * @return $this
     */
    public function withUserAgent(array $userAgent)
    {
        $this->userAgent = UserAgent::clean($userAgent);

        return $this;
    }

    /**
     * Set the request data format.
     *
     * @param string $format
     *
     * @return $this
     */
    public function inputFormat(string $format)
    {
        $this->inputFormat = strtoupper($format);

        return $this;
    }

    /**
     * Set the response data format.
     *
     * @param string $format
     *
     * @return $this
     */
    public function outputFormat(string $format)
    {
        $this->outputFormat = strtoupper($format);

        return $this;
    }

    /**
     * Set the request body.
     *
     * @param string $content
     *
     * @return $this
     */
    public function body($content)
    {
        $this->options['body'] = $content;

        return $this;
    }

    /**
     * Set the json as body.
     *
     * @param array|object $content
     *
     * @return $this
     */
    public function jsonBody($content)
    {
        if (is_array($content) || is_object($content)) {
            $content = json_encode($content);
        }

        return $this->body($content);
    }

    /**
     * Set the request scheme.
     *
     * @param string $scheme
     *
     * @return $this
     */
    public function scheme(string $scheme)
    {
        $this->scheme = strtolower($scheme);
        $this->uri = $this->uri->withScheme($this->scheme);

        return $this;
    }

    /**
     * Set the request host.
     *
     * @param string $host
     *
     * @return $this
     */
    public function host(string $host)
    {
        $this->uri = $this->uri->withHost($host);

        return $this;
    }

    /**
     * @param string $path
     *
     * @return $this
     * @Author: wm
     * @Date  : 19-2-27
     * @Time  : 下午12:40
     */
    public function path(string $path)
    {
        $this->uri = $this->uri->withPath($path);

        return $this;
    }

    /**
     * @param string $method
     *
     * @return $this
     */
    public function method($method)
    {
        $this->method = strtoupper($method);

        return $this;
    }

    /**
     * @return \stlswm\WxMp\Client\Client
     * @Author: wm
     * @Date  : 19-2-27
     * @Time  : 上午10:07
     */
    public function httpClient()
    {
        return $this->client;
    }

    /**
     * @return bool
     * @Author: wm
     * @Date  : 19-2-26
     * @Time  : 下午4:15
     */
    public function isDebug()
    {
        if (isset($this->options['debug'])) {
            return $this->options['debug'] === TRUE;
        }

        return FALSE;
    }

    /**
     * @return Result
     * @throws ClientException
     * @throws ServerException
     */
    public function request()
    {
        $this->options['headers']['User-Agent'] = UserAgent::toString($this->userAgent);

        $this->resolveParameters();

        if (isset($this->options['form_params'])) {
            $this->options['form_params'] = parse_query(
                self::getPostHttpBody($this->options['form_params'])
            );
        }
        $result = new Result($this->response(), $this);

        if (!$result->isSuccess()) {
            throw new ServerException($result);
        }

        return $result;
    }

    /**
     * @param array $post
     *
     * @return bool|string
     */
    public static function getPostHttpBody(array $post)
    {
        $content = '';
        foreach ($post as $apiKey => $apiValue) {
            $content .= "$apiKey=" . urlencode($apiValue) . '&';
        }

        return substr($content, 0, -1);
    }

    /**
     * @throws ClientException
     */
    private function response()
    {
        try {
            return $this->guzzle->request(
                $this->method,
                (string)$this->uri,
                $this->options
            );
        } catch (GuzzleException $e) {
            throw new ClientException(
                $e->getMessage(),
                WX_MP_SERVER_UNREACHABLE,
                $e
            );
        }
    }

    /**
     * @return string
     */
    public function stringToBeSigned()
    {
        return $this->stringToBeSigned;
    }
}
