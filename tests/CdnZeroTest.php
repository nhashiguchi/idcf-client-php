<?php
declare(strict_types=1);

namespace Idcf\Client;

use PHPUnit\Framework\TestCase;

/**
 * @covers CdnZero
 */
final class CdnZeroTest extends TestCase
{
    public function testListCacheServers(): void
    {
        $client = new CdnZero($_ENV['API_KEY'], $_ENV['SECRET_KEY']);
        $args = array('api_key' => $_ENV['API_KEY']);
        $fqdns = $client->get('fqdns', $args);
        $this->assertObjectHasAttribute('status', $fqdns);
        $this->assertObjectHasAttribute('customer_domain', $fqdns);
    }
}
