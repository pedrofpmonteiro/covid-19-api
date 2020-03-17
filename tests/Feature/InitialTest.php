<?php


namespace pedrofpmonteiro\Covid19\Tests;


use pedrofpmonteiro\Covid19\WorldOMeterParser;

class InitialTest extends TestCase
{
    /** @test */
    public function check_parser()
    {
        $data = WorldOMeterParser::get();

        $this->assertArrayHasKey(0, $data, 'The data is empty');

        $this->assertArrayHasKey('Country', $data[0], "Checking Country Key");
        $this->assertArrayHasKey('totalCases', $data[0], "Checking totalCases Key");
        $this->assertArrayHasKey('newCases', $data[0], "Checking totalDeaths Key");
        $this->assertArrayHasKey('totalDeaths', $data[0], "Checking totalDeaths Key");
        $this->assertArrayHasKey('newDeaths', $data[0], "Checking newDeaths Key");
        $this->assertArrayHasKey('totalRecovered', $data[0], "Checking totalRecovered Key");
        $this->assertArrayHasKey('activeCases', $data[0], "Checking activeCases Key");
        $this->assertArrayHasKey('seriousCases', $data[0], "Checking seriousCases Key");
        $this->assertArrayHasKey('total1Mpop', $data[0], "Checking total1Mpop Key");

    }
}