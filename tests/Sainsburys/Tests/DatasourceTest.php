<?php

namespace Sainsburys\Tests;

class DatasourceTest extends \PHPUnit_Framework_TestCase {

    public function testClient() {
        $datasource = new \Sainsburys\Datasource();
        $client = $datasource->getClient();

        $this->assertInstanceOf('\Guzzle\Http\Client', $client);
        $this->assertEquals('http://www.sainsburys.co.uk', $client->getBaseUrl());
    }

    public function testRequestAll() {
        $client = $this->getMockBuilder('\Guzzle\Http\Client')
            ->setMethods(array('get'))
            ->getMock();
        $client->method('get')
            ->willReturn(new MockRequest());

        $datasource = $this->getMockBuilder('\Sainsburys\Datasource')
            ->setMethods(array('getClient'))
            ->getMock();
        $datasource->method('getClient')
            ->willReturn($client);

        $response = $datasource->requestAll();
        $this->assertEquals($response, '<html>body</html>');
    }

    public function testRequestItemAndArgument() {
        $fakeUrl = 'someUrl';

        $client = $this->getMockBuilder('\Guzzle\Http\Client')
            ->setMethods(array('get'))
            ->getMock();
        $client->expects($this->once())
            ->method('get')
            ->with($this->equalTo($fakeUrl)) // testing argument
            ->willReturn(new MockRequest());

        $datasource = $this->getMockBuilder('\Sainsburys\Datasource')
            ->setMethods(array('getClient'))
            ->getMock();
        $datasource->method('getClient')
            ->willReturn($client);

        $response = $datasource->requestItem($fakeUrl);
        $this->assertEquals($response, '<html>body</html>');
    }

}

class MockRequest
{
    function send()
    {
        return new MockResponse();
    }
}
class MockResponse
{
    function getBody($boolean)
    {
        return '<html>body</html>';   
    }
}