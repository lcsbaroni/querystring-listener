<?php

namespace Dafiti\Silex\Listener;

use Symfony\Component\HttpFoundation;

class QueryStringTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers Dafiti\Silex\Listener\QueryString::getSubscribedEvents
     */
    public function testSubscribedEvents()
    {
        $expectedEvent = [
            \Symfony\Component\HttpKernel\KernelEvents::REQUEST => ['onKernelRequest', 100],
        ];

        $result = QueryString::getSubscribedEvents();
        $this->assertEquals($expectedEvent, $result);
    }

    /**
     * @covers Dafiti\Silex\Listener\QueryString::onKernelRequest
     */
    public function testShouldParseQueryStringParams()
    {
        $mockedKernel = $this->getMockBuilder('Symfony\Component\HttpKernel\HttpKernelInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $request = new HttpFoundation\Request();
        $request->server->set('QUERY_STRING', 'filter=item:1&filter=item:2&filter=color:branco&q=camisa');

        $requestType = \Symfony\Component\HttpKernel\HttpKernelInterface::MASTER_REQUEST;
        $event = new \Symfony\Component\HttpKernel\Event\GetResponseEvent($mockedKernel, $request, $requestType);

        $listener = new QueryString();
        $listener->onKernelRequest($event);

        $expectedFilter = ["color:branco", "item:1", "item:2"];

        $this->assertEquals("camisa", $request->get('q'));
        $this->assertEquals($expectedFilter, $request->get('filter'));
    }

    /**
     * @covers Dafiti\Silex\Listener\QueryString::onKernelRequest
     */
    public function testShouldParseQueryStringWithOnlyOneParam()
    {
        $mockedKernel = $this->getMockBuilder('Symfony\Component\HttpKernel\HttpKernelInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $request = new HttpFoundation\Request();
        $request->server->set('QUERY_STRING', 'q=camisa');

        $requestType = \Symfony\Component\HttpKernel\HttpKernelInterface::MASTER_REQUEST;
        $event = new \Symfony\Component\HttpKernel\Event\GetResponseEvent($mockedKernel, $request, $requestType);

        $listener = new QueryString();
        $result = $listener->onKernelRequest($event);

        $this->assertEquals("camisa", $request->get('q'));
    }

    /**
     * @covers Dafiti\Silex\Listener\QueryString::onKernelRequest
     */
    public function testShouldParseQueryStringWithEmptyParams()
    {
        $mockedKernel = $this->getMockBuilder('Symfony\Component\HttpKernel\HttpKernelInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $request = new HttpFoundation\Request();
        $request->server->set('QUERY_STRING', '');

        $requestType = \Symfony\Component\HttpKernel\HttpKernelInterface::MASTER_REQUEST;
        $event = new \Symfony\Component\HttpKernel\Event\GetResponseEvent($mockedKernel, $request, $requestType);

        $listener = new QueryString();
        $result = $listener->onKernelRequest($event);

        $this->assertFalse($result);
    }
}
