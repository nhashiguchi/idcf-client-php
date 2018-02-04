<?php
namespace Idcf\Client;

class Dns extends IdcfBaseClient
{
    public function __construct(
        $api_key,
        $secret_key,
        $host = 'dns.idcfcloud.com',
        $endpoint = '/api/v1',
        $verify_ssl = true
    ) {
        parent::__construct($api_key, $secret_key, $host, $endpoint, $verify_ssl);
    }
}

// # Usage
// require_once 'vendor/autoload.php';
// $api_key = '';
// $secret_key = '';
// $client = new \Idcf\Client\Dns($api_key, $secret_key);
// $client->get('zones');
