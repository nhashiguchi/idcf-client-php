<?php
declare(strict_types=1);

namespace Idcf\Client;

use PHPUnit\Framework\TestCase;

/**
 * @covers Ilb
 */
final class IlbTest extends TestCase
{
    public function testListZones(): void
    {
        $client = new Ilb($_ENV['API_KEY'], $_ENV['SECRET_KEY']);
        $this->assertContainsOnly('stdClass', $client->get('loadbalancers'));
    }
}
