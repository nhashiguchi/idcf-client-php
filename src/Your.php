<?php
namespace Idcf\Client;

class Your extends BaseClient
{
    public function __construct(
        $api_key,
        $secret_key,
        $host = 'your.idcfcloud.com',
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
// $client = new \Idcf\Client\Your($api_key, $secret_key);
// $client->get('billings/history');
