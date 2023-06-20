<?php

namespace Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testHome(): void
    {
        $client = static::createClient();

        $homePageUrl = $client->getContainer()->get('router')->generate('homepage', array(), false);

        $client->request('GET', $homePageUrl);

        $this->assertResponseIsSuccessful();
    }
}