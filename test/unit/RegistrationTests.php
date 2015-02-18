<?php

class RegistrationTests extends \PHPUnit_Framework_TestCase
{
    public function testInitialPage()
    {
        $statusCode = 200;
        $pageContent = "<form action=/'#/' method /'post/'><h3>Contact us</h3></form>";

        $this->assertEquals(200, $statusCode);
        $this->assertContains('Contact us', $pageContent);
        $this->assertContains('<form', $pageContent);
    }
}