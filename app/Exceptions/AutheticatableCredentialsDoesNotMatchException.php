<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class AutheticatableCredentialsDoesNotMatchException extends Exception
{
    /**
     * @param string $message
     */
    public function __construct($message = 'Credentials does not match.')
    {
        parent::__construct($message, Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @return Response
     */
    public function render(): Response
    {
        return response(
            ['message' => $this->getMessage()],
            $this->getCode()
        );
    }
}