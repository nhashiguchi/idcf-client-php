<?php
declare(strict_types=1);

namespace Idcf\Client;

use PHPUnit\Framework\TestCase;

/**
 * @covers Dns
 */
final class DnsTest extends TestCase
{
    public function testListZones(): void
    {
        $client = new Dns($_ENV['API_KEY'], $_ENV['SECRET_KEY']);
        $this->assertContainsOnly('stdClass', $client->get('zones'));
    }
}
