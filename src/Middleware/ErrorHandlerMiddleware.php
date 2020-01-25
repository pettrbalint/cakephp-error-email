<?php

namespace ErrorEmail\Middleware;

use Cake\Error\Middleware\ErrorHandlerMiddleware as CakeErrorHandlerMiddleware;
use ErrorEmail\Traits\EmailThrowableTrait;

/**
 * Error handling middleware.
 *
 * Extends cake's error handling middleware and adds emailing functionality to it.
 */
class ErrorHandlerMiddleware extends CakeErrorHandlerMiddleware
{
    use EmailThrowableTrait;

    /**
     * Add email funcitonality to handle exception
     *
     * @param \Throwable $exception The exception to handle.
     * @param \Psr\Http\Message\ServerRequestInterface $request The request.
     * @param \Psr\Http\Message\ResponseInterface $response The response.
     */
    public function handleException(\Throwable $exception, \Psr\Http\Message\ServerRequestInterface $request): \Psr\Http\Message\ResponseInterface
    {
        // Add emailing throwable functionality
        $this->emailThrowable($exception);
        // Use parent funcitonality
        return $this->_callParent($exception, $request);
    }

    /**
     * Wrap parent functionality so we can isolate our class for testing
     *
     * @param \Throwable $exception The exception to handle.
     * @param \Psr\Http\Message\ServerRequestInterface $request The request.
     * @param \Psr\Http\Message\ResponseInterface $response The response.
     */
    protected function _callParent(\Throwable $exception, \Psr\Http\Message\ServerRequestInterface $request)
    {
        return parent::handleException($exception, $request);
    }
}
