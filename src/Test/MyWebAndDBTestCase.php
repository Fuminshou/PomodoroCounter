<?php

namespace Pomodoro\Test;

use Symfony\Component\HttpKernel\Client;


class MyWebAndDBTestCase extends \PHPUnit_Extensions_Database_TestCase
{

    protected $app;
    protected $conn;

    /**
     * @return PHPUnit_Extensions_Database_DB_IDatabaseConnection
     */
    public function getConnection()
    {
        if ($this->conn === null) {
            try {
                $pdo = new \PDO('mysql:host=localhost;dbname=PomodoroCounter', 'root', '123456ciao');
                $this->conn = $this->createDefaultDBConnection($pdo, 'PomodoroCounter');
            } catch (\PDOException $e) {
                echo $e->getMessage();
            }
        }

        return $this->conn;
    }

    /**
     * @return PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    public function getDataSet()
    {
        return $this->createMySQLXMLDataSet(__DIR__ . '/dataset.xml');
    }


    public function createApplication()
    {
        return require __DIR__ . '/../../app/app.php';
    }

    /**
     * PHPUnit setUp for setting up the application.
     *
     * Note: Child classes that define a setUp method must call
     * parent::setUp().
     */
    public function setUp()
    {
        parent::setUp();
        $this->app = $this->createApplication();

    }

    /**
     * Creates a Client.
     *
     * @param array $server An array of server parameters
     *
     * @return Client A Client instance
     */
    public function createClient(array $server = array())
    {
        return new Client($this->app, $server);
    }

}