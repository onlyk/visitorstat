<?php
declare(strict_types=1);

namespace App\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class UpdateVisitorStatisticTest extends WebTestCase
{
    public function testUpdateVisitorStatisticWithGoodRequest()
    {
        $client = static::createClient();

        $crawler = $client->request('POST', '/statistics', ['country' => 'cy']);

        $this->assertResponseIsSuccessful();
    }

    public function testUpdateVisitorStatisticWithBadRequest()
    {
        $client = static::createClient();

        $crawler = $client->request('POST', '/statistics', []);

        $this->assertResponseStatusCodeSame(400);
    }
}