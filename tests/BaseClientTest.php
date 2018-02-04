<?php
declare(strict_types=1);

namespace Idcf\Client;

use PHPUnit\Framework\TestCase;

/**
 * @covers BaseClient
 */
final class BaseClientTest extends TestCase
{
    public function testInvalidEndpoint(): void
    {
        $this->expectException(Exception\ClientError::class);
        $client = new BaseClient('api_key', 'secret_key', 'hostname');
        $client->get('zones');
    }

    public function testInvalidHostname(): void
    {
        $this->expectException(Exception\ServerError::class);
        $client = new BaseClient('api_key', 'secret_key', 'example.com');
        $client->get('zones');
    }

    public function testInvalidKeys(): void
    {
        $this->expectException(Exception\ServerError::class);
        $client = new BaseClient('api_key', 'secret_key', 'dns.idcfcloud.com');
        $client->get('zones');
    }
}
