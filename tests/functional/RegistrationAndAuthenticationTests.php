<?php

require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/../../src/MyWebAndDBTestCase.php';


class RegistrationAndAuthenticationTests extends MyWebAndDBTestCase
{
    public function testAnonymousUserRegistrationShouldSuccess()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');
        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertCount(3, $crawler->filter('input'));
        $this->assertContains("nome", $crawler->filter('input[type="text"]')->attr('name'));
        $this->assertContains("email", $crawler->filter('input[type="email"]')->attr('name'));
        $this->assertContains("Entra", $crawler->filter('input[type="submit"]')->attr('value'));

        /*
         * NON sono convinta di questa cosa
         * come faccio a controllare che i dati inseriti nel form siano corretti?
         * in che punto devo mettermi per intercettare la submit e usare il db mockato per controllare?
         */
        $formData = [
            'nome' => 'Nicola',
            'email' => 'example@nicola.com'
        ];

        $buttonCrawler = $crawler->selectButton('Entra');
        $form = $buttonCrawler->form($formData, 'POST');

        $expectedTable = $this->getConnection()->createDataSet()->getTable('User');
        $queryTable = $this->getConnection()->createQueryTable(
            'User', 'SELECT * FROM User'
        );

        $this->assertTablesEqual($expectedTable, $queryTable);  //le tabelle sono uguali

        $filteredTable = $this->getConnection()->createQueryTable(
            'User',
            'SELECT * FROM User WHERE user.email = \'' . $formData['email'] . '\''
        );

        $this->assertEquals(0, $filteredTable->getRowCount());  //nel db non esiste la mail inserita, nuovo utente

        $formCrawler = $client->submit($form);
        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertContains("Il form", $formCrawler->filter('h4')->text());
    }

//
//    public function testAnonymousUserLoginShouldSuccess()
//    {
//
//    }

}