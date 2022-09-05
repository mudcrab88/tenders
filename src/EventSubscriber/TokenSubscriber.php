<?php

// src/EventSubscriber/TokenSubscriber.php
namespace App\EventSubscriber;

use App\Controller\TokenAuthenticatedController;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class TokenSubscriber implements EventSubscriberInterface
{
    private string $token;

    public function __construct(ParameterBagInterface $params)
    {
        $this->token = $params->get('api.token.tenders');
    }

    public function onKernelController(ControllerEvent $event)
    {
        $controller = $event->getController();

        if (is_array($controller)) {
            $controller = $controller[0];
        }

        if ($controller instanceof TokenAuthenticatedController) {
            $authorization = $event->getRequest()->headers->get('Authorization');
            $auth_token = str_replace('Bearer ', '', $authorization);

            if ($auth_token !== $this->token) {
                throw new AccessDeniedHttpException('This action needs a valid token!');
            }
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }
}
