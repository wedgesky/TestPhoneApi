<?php


namespace App\Tests\Controller;


use PHPUnit\Framework\TestCase;
use App\Controller\TestRecordsController;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TestRecordsControllerTest extends WebTestCase
{
    public function testGetTestPhone()
    {

        $result = TestRecordsController::getTestPhone("ccfd");

        // assert that your calculator added the numbers correctly!
        $this->assertEquals(TestRecordsController::MESSAGE_FAILED, $result->getResult());
    }

    public function testNew()
    {
        $client = static::createClient();

        $client->request('GET', '/new');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}