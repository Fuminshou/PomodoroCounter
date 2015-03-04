<?php

use Pomodoro\Test\MyWebAndDBTestCase;


class RegistrationAndAuthTest extends MyWebAndDBTestCase
{
    public function testAnonymousUserRegistrationShouldSuccess()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');
        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertCount(3, $crawler->filter('html')->filter('input'));
        $this->assertContains("nome", $crawler->filter('input[type="text"]')->attr('name'));
        $this->assertContains("email", $crawler->filter('input[type="email"]')->attr('name'));
        $this->assertContains("Entra", $crawler->filter('input[type="submit"]')->attr('value'));

        $formData = [
            'nome' => 'Nicola',
            'email' => 'example@nicola.com'
        ];

        $buttonCrawler = $crawler->selectButton('Entra');
        $form = $buttonCrawler->form($formData, 'POST');

        $formCrawler = $client->submit($form);
        $client->followRedirects();
        $this->assertTrue($client->getResponse()->isRedirect());
        $this->assertContains('Ciao', $formCrawler->filter('h2')->text());
    }


//    public function testAnonymousUserLoginShouldSuccess()
//    {
//
//    }


    public function testAnonymousUserLoginShouldFail()
    {

        $client = static::createClient();

        $crawler = $client->request('GET', '/');
        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertCount(3, $crawler->filter('input'));
        $this->assertContains("nome", $crawler->filter('input[type="text"]')->attr('name'));
        $this->assertContains("email", $crawler->filter('input[type="email"]')->attr('name'));
        $this->assertContains("Entra", $crawler->filter('input[type="submit"]')->attr('value'));

        $formData = [
            'nome' => 'Nicola',
            'email' => 'nicole@example.com'
        ];

        $buttonCrawler = $crawler->selectButton('Entra');
        $form = $buttonCrawler->form($formData, 'POST');

        $formCrawler = $client->submit($form);
        $client->followRedirects();
        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertCount(3, $formCrawler->filter('input'));
    }

}