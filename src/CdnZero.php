<?php
namespace Idcf\Client;

class CdnZero extends BaseClient
{
    public function __construct(
        $api_key,
        $secret_key,
        $host = 'cdn.idcfcloud.com',
        $endpoint = '/api/v0',
        $verify_ssl = true
    ) {
        $this->hmac_raw_output = false;
        parent::__construct($api_key, $secret_key, $host, $endpoint, $verify_ssl);
    }

    protected function createHeader($args)
    {
        return array(
            'signature: ' . parent::signature($args),
            'expired: ' . $args['expired'],
            'Content-Type: application/json',
            'User-Agent: IDCF API Client for PHP v' . self::VERSION
        );
    }

    protected function createArgs($method, $query)
    {
        return array(
            'method' => strtoupper($method),
            'api_key' => $this->api_key,
            'secret_key' => $this->secret_key,
            'expired' => time() + 60,
            'uri' => parent::getPath($query),
            'request_body' => is_null($query['params']) ? null : json_encode($query['params'])
        );
    }
}

// # Usage
// require_once 'vendor/autoload.php';
// $api_key = '';
// $secret_key = '';
// $client = new \Idcf\Client\CdnZero($api_key, $secret_key);
// $args = array('api_key' => $api_key);
// $client->get('fqdns', $args);
