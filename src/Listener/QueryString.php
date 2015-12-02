<?php

namespace Dafiti\Silex\Listener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class QueryString implements EventSubscriberInterface
{
    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => ['onKernelRequest', 100],
        ];
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();

        $query = urldecode($request->getQueryString());

        if (!$query) {
            return false;
        }

        $params = explode('&', $query);

        $filters = [];
        foreach ($params as $item) {
            $filter = explode('=', $item);
            $filters[$filter[0]][] = $filter[1];
        }

        foreach ($filters as $key => $values) {
            if (count($values) == 1) {
                $values = current($values);
            }

            $request->query->set($key, $values);
        }
    }
}
