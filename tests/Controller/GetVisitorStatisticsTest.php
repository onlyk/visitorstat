<?php
declare(strict_types=1);

namespace App\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class GetVisitorStatisticsTest extends WebTestCase
{
    public function testGetVisitorStatistics()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/statistics');

        $this->assertResponseIsSuccessful();
    }
}