<?php

namespace Sainsburys\Tests;

class IndexControllerTest extends \PHPUnit_Framework_TestCase {

    private $_response;

    public function setUp() {
        parent::setUp();
        $controller = new \Sainsburys\IndexController();
        $this->_response = $controller->run();
    }

    public function testResponseProperties() {
        $resposeArray = json_decode($this->_response, true);

        $this->assertEquals(12, count($resposeArray['results']));
        $this->assertEquals(22.5, $resposeArray['total']);
    }

    public function testResponseElementProperties() {
        $resposeArray = json_decode($this->_response, true);

        $results = $resposeArray['results'];
        $this->assertEquals("Sainsbury's Apricot Ripe & Ready 320g", $results[0]['title']);
        $this->assertContains("kb", $results[1]['size']);
        $this->assertEquals("1.50", $results[2]['unit_price']);
        $this->assertEquals("Avocados", $results[3]['description']);
    }

}