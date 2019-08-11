<?php


namespace SoftUniBlogBundle\Redirect;

use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class AcmeExceptionListener
{

    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        // You get the exception object from the received event
        $exception = $event->getException();

        if ($event->getException() instanceof NotFoundHttpException) {

            $response = new RedirectResponse('/');
            $event->setResponse($response);
        }
    }
}