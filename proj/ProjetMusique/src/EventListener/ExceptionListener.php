<?php
// src/EventListener/ExceptionListener.php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Twig\Environment;

class ExceptionListener
{
    private Environment $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function onKernelException(ExceptionEvent $event)
    {
//        $exception = $event->getThrowable();
//
//// Si l'exception est de type "NotFoundHttpException"
//        if ($exception instanceof NotFoundHttpException) {
//            $response = new Response(
//                $this->twig->render('errors/error404.html.twig'),
//                Response::HTTP_NOT_FOUND
//            );
//        } // Si l'exception est de type "AccessDeniedHttpException"
//        elseif ($exception instanceof AccessDeniedHttpException) {
//            $response = new Response(
//                $this->twig->render('errors/error403.html.twig'),
//                Response::HTTP_FORBIDDEN
//            );
//        } // Si c'est une autre exception
//        else {
////            $response = new Response(
////                $this->twig->render('errors/error500.html.twig'),
////                Response::HTTP_INTERNAL_SERVER_ERROR
////            );
//        }
//
//// Définir la réponse à renvoyer
//        $event->setResponse($response);
    }
}
