<?php

namespace Idcf\Client;

class BaseClient extends Version
{
    public $return_assoc = false;
    protected $api_key;
    protected $secret_key;
    protected $hmac_raw_output = true;
    private $host;
    private $endpoint;
    private $verify_ssl;

    public function __construct(
        $api_key,
        $secret_key,
        $host,
        $endpoint = '/api/v1',
        $verify_ssl = true
    ) {
        $this->api_key = $api_key;
        $this->secret_key = $secret_key;
        $this->host = $host;
        $this->endpoint = $endpoint;
        $this->verify_ssl = $verify_ssl;
    }

    /**
     * GET method.
     * @param  string $path   URI path.
     * @param  array  $params Requrest parameter.
     * @param  array  $header Requrest header.
     * @return object         responce data.
     */
    public function get($path, $params = array(), $header = array())
    {
        return self::apiCall('get', $path, $params, $header);
    }

    /**
     * POST method.
     * @param  string $path   URI path.
     * @param  array  $params Requrest parameter.
     * @param  array  $header Requrest header.
     * @return object         responce data.
     */
    public function post($path, $params = array(), $header = array())
    {
        return self::apiCall('post', $path, $params, $header);
    }

    /**
     * PUT method.
     * @param  string $path   URI path.
     * @param  array  $params Requrest parameter.
     * @param  array  $header Requrest header.
     * @return object         responce data.
     */
    public function put($path, $params = array(), $header = array())
    {
        return self::apiCall('put', $path, $params, $header);
    }

    /**
     * DELETE method.
     * @param  string $path   URI path.
     * @param  array  $params Requrest parameter.
     * @param  array  $header Requrest header.
     * @return object         responce data.
     */
    public function delete($path, $params = array(), $header = array())
    {
        return self::apiCall('delete', $path, $params, $header);
    }

    private function apiCall($method, $path, $params, $header)
    {
        $curl = curl_init();
        curl_setopt_array($curl, self::setOpts($method, $path, $params, $header));
        $body = curl_exec($curl);
        $errno = curl_errno($curl);
        $error = curl_error($curl);
        $info = curl_getinfo($curl);
        curl_close($curl);
        if (CURLE_OK !== $errno) {
            throw new Exception\ClientError($error, $errno);
        }
        if ($info['http_code'] < 200 || 300 <= $info['http_code']) {
            throw new Exception\ServerError($body, $info['http_code']);
        }
        $result = json_decode($body);
        $errno = json_last_error();
        if (JSON_ERROR_NONE !== $errno) {
            throw new Exception\DecodeError($errno);
        }
        return $result;
    }

    private function setOpts($method, $path, $params, $header)
    {
        $query = self::queryParse($method, $path, $params);
        $args = static::createArgs($method, $query);
        $opts = array(
            CURLOPT_URL => self::getUrl($query),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => $this->verify_ssl ? 1 : 0,
            CURLOPT_SSL_VERIFYHOST => $this->verify_ssl ? 2 : 0,
            CURLOPT_HTTPHEADER => array_merge(static::createHeader($args), $header)
        );
        switch ($method) {
            case 'get':
                break;
            case 'post':
                $opts[CURLOPT_POST] = true;
                break;
            default:
                $opts[CURLOPT_CUSTOMREQUEST] = $args['method'];
        }
        if ($method != 'get' && !is_null($query['params'])) {
            $opts[CURLOPT_POSTFIELDS] = json_encode($query['params'], $this->return_assoc);
        }
        return $opts;
    }

    protected function createArgs($method, $query)
    {
        return array(
            'method' => strtoupper($method),
            'path' => $this->endpoint . '/' . $query['path'],
            'api_key' => $this->api_key,
            'expired' => time() + 60,
            'query' => http_build_query($query['query'])
        );
    }

    protected function createHeader($args)
    {
        return array(
            'X-IDCF-APIKEY: ' . $this->api_key,
            'X-IDCF-Signature: ' . self::signature($args),
            'X-IDCF-Expires: ' . $args['expired'],
            'Content-Type: application/json',
            'User-Agent: IDCF API Client for PHP v' . self::VERSION
        );
    }

    protected function signature($args)
    {
        return base64_encode(
            hash_hmac('sha256', implode("\n", $args), $this->secret_key, $this->hmac_raw_output)
        );
    }

    private function getUrl($args)
    {
        return self::urlPrefix() . self::getPath($args);
    }

    protected function getPath($args)
    {
        extract($args);
        if (is_null($query)) {
            return $this->endpoint . '/' . $path;
        }
        return $this->endpoint . '/' . $path . '?' . http_build_query($query);
    }

    private function urlPrefix()
    {
        return 'https://' . $this->host;
    }

    private function queryParse($method, $path, $params)
    {
        $args = explode('?', $path, 2);
        if (array_key_exists(1, $args)) {
            parse_str($args[1], $query);
            if ($method == 'get') {
                return array(
                    'query' => array_merge($query, $params),
                    'path' => $args[0],
                    'params' => null
                );
            }
            return array(
                'query' => $query,
                'path' => $args[0],
                'params' => $params
            );
        } elseif ($method == 'get') {
            return array(
                'query' => $params,
                'path' => $path,
                'params' => null
            );
        }
        return array(
            'query' => array(),
            'path' => $path,
            'params' => $params
        );
    }
}
