<?php

namespace Idcf\Client;

class Compute extends BaseClient
{
    public function __construct(
        $api_key,
        $secret_key,
        $host = 'compute.jp-east.idcfcloud.com',
        $endpoint = '/client/api',
        $verify_ssl = true
    ) {
        $this->json_request = false;
        parent::__construct($api_key, $secret_key, $host, $endpoint, $verify_ssl);
    }

    /**
     * GET method.
     * @param  array  $params Requrest parameter.
     * @param  array  $header Requrest header.
     * @return object         responce data.
     */
    public function get($params = array(), $header = array())
    {
        return self::apiCall('get', null, $params, $header);
    }

    /**
     * POST method.
     * @param  array  $params Requrest parameter.
     * @param  array  $header Requrest header.
     * @return object         responce data.
     */
    public function post($params = array(), $header = array())
    {
        return self::apiCall('post', null, $params, $header);
    }

    protected function getPath($args)
    {
        extract($args);
        if (empty($query)) {
            return $this->endpoint;
        }
        return $this->endpoint . '?' . http_build_query($query);
    }


    protected function createHeader($args)
    {
        return array(
            'User-Agent: IDCF API Client for PHP v' . self::VERSION
        );
    }

    protected function signature($params)
    {
        return base64_encode(
            hash_hmac('sha1', $params, $this->secret_key, true)
        );
    }

    protected function queryParse($method, $path, $params)
    {
        $query = parent::queryParse($method, $path, $params);
        if ($method == 'get') {
            self::buildQuery($query['query']);
        } else {
            self::buildQuery($query['params']);
        }
        var_dump($query);
        return $query;
    }

    private function buildQuery(&$query)
    {
        $query = array_merge(
            array(
                'apikey' => $this->api_key,
                'response' => 'json',
            ),
            $query
        );
        $query['signature'] = self::calcSignature($query);
    }

    private function calcSignature($query)
    {
        ksort($query, SORT_STRING | SORT_FLAG_CASE);
        return static::signature(
            str_replace(
                array('+', '%2a', '%5b', '%5d'),
                array('%20', '*', '[', ']'),
                strtolower(http_build_query($query))
            )
        );
    }
}

// $client = new \Idcf\Client\Compute($api_key, $secret_key);
// $args = array('command' => 'listZones');
// var_dump($client->get($args));
