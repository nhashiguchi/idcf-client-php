<?php

namespace Idcf\Client;

class IdcfBaseClient extends BaseClient
{
    public function __construct(
        $api_key,
        $secret_key,
        $host,
        $endpoint = '/api/v1',
        $verify_ssl = true
    ) {
        parent::__construct($api_key, $secret_key, $host, $endpoint, $verify_ssl);
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
}
