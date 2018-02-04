<?php
declare(strict_types=1);

namespace Idcf\Client;

use PHPUnit\Framework\TestCase;

/**
 * @covers Your
 */
final class YourTest extends TestCase
{
    public function testListBillingHistory(): void
    {
        $client = new Your($_ENV['API_KEY'], $_ENV['SECRET_KEY']);
        $history = $client->get('billings/history');
        $this->assertObjectHasAttribute('meta', $history);
        $this->assertObjectHasAttribute('data', $history);
    }
}
