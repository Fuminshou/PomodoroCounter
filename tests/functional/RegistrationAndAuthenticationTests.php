<?php

require __DIR__ . '/../../vendor/autoload.php';

use Silex\WebTestCase;
use PHPUnit_Extensions_Database_TestCase;

class RegistrationAndAuthenticationTests extends WebTestCase //extends PHPUnit_Extensions_Database_TestCase
{

    public function createApplication()
    {
        return require __DIR__ . '/../../app/app.php';
    }

    public function testAnonymousUserRegistrationShouldSuccess()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');
        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertCount(3, $crawler->filter('input'));
        $this->assertContains("nome", $crawler->filter('input[type="text"]')->attr('name'));
        $this->assertContains("email", $crawler->filter('input[type="email"]')->attr('name'));
        $this->assertContains("Entra", $crawler->filter('input[type="submit"]')->attr('value'));

        $buttonCrawler = $crawler->selectButton('Entra');
        $form = $buttonCrawler->form(
            array(
                'nome' => 'Nicole',
                'email' => 'nicole@example.com'
            ),
            'POST'
        );

        $formCrawler = $client->submit($form);
        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertContains("Il form", $formCrawler->filter('h4')->text());

    }
}