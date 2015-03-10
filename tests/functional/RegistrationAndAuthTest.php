<?php

class RegistrationAndAuthTest extends \Silex\WebTestCase
{
    public function createApplication()
    {
        $app = require __DIR__ . '/../../app/app.php';

        $app['session.test'] = true;

        return $app;
    }


    protected function prepareForm($crawler, $username, $email)
    {
        $formData = [
            'nome' => $username,
            'email' => $email
        ];

        $buttonCrawler = $crawler->selectButton('Entra');
        return $buttonCrawler->form($formData, 'POST');
    }

    public function testAnonymousUserRegistrationShouldSuccess()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertCount(3, $crawler->filter('input'));
        $this->assertContains("nome", $crawler->filter('input[type="text"]')->attr('name'));
        $this->assertContains("email", $crawler->filter('input[type="email"]')->attr('name'));
        $this->assertContains("Entra", $crawler->filter('input[type="submit"]')->attr('value'));

        $form = $this->prepareForm($crawler, 'Nicolas', 'nicolas@example.com');

        $client->submit($form);

        $this->assertTrue($client->getResponse()->isRedirect());
        $formCrawler = $client->followRedirect();

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Ciao Nicolas!', $formCrawler->filter('h2')->text());
    }


    public function testRegisteredUserLoginShouldSuccess()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $form = $this->prepareForm($crawler, 'Nicole', 'nicole@example.com');

        $client->submit($form);

        $this->assertTrue($client->getResponse()->isRedirect());
        $formCrawler = $client->followRedirect();

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Ciao Nicole!', $formCrawler->filter('h2')->text());
    }


    public function testLoginOrRegistrationShouldFail()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $form = $this->prepareForm($crawler, 'Nicolas', 'nicole@example.com');

        $client->submit($form);

        $this->assertTrue($client->getResponse()->isRedirect());
        $formCrawler = $client->followRedirect();

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertCount(3, $formCrawler->filter('input'));
    }

}