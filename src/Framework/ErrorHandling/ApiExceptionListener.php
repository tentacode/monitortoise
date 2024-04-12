<?php

declare(strict_types=1);

namespace App\Framework\ErrorHandling;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\Validator\Exception\ValidationFailedException;

class ApiExceptionListener
{
    public function onKernelException(ExceptionEvent $event)
    {
        $request = $event->getRequest();

        // Check if the request is for the API
        if (strpos($request->getPathInfo(), '/api') !== 0) {
            return;
        }

        $exception = $event->getThrowable();
        if ($exception->getPrevious() instanceof ValidationFailedException) {
            $exception = $exception->getPrevious();
        }

        // Here you can add any specific handlers for different types of exceptions
        if ($exception instanceof ValidationFailedException) {
            $response = $this->createValidationErrorResponse($exception);
        } else {
            $response = $this->createExceptionResponse($exception);
        }

        $event->setResponse($response);
    }
    
    private function createExceptionResponse(\Throwable $exception): Response
    {
        $data = [
            'type' => 'exception',
            'class' => get_class($exception),
            'message' => $exception->getMessage(),
        ];

        return new Response(json_encode($data), Response::HTTP_INTERNAL_SERVER_ERROR, ['Content-Type' => 'application/json']);
    }

    private function createValidationErrorResponse(ValidationFailedException $exception): Response
    {

        $errors = [];
        foreach ($exception->getViolations() as $violation) {
            $errors[$violation->getPropertyPath()][] = $violation->getMessage();
        }

        $data = [
            'type' => 'validation_error',
            'message' => 'The given data was invalid.',
            'errors' => $errors,
        ];

        return new Response(json_encode($data), Response::HTTP_UNPROCESSABLE_ENTITY, ['Content-Type' => 'application/json']);
    }
}

