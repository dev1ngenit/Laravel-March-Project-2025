<?php

namespace App\Services;

use Illuminate\Http\Request as LaravelRequest;
use GuzzleHttp\Psr7\Request as PsrRequest;
use Clerk\Backend\Helpers\Jwks\AuthenticateRequest;
use Clerk\Backend\Helpers\Jwks\AuthenticateRequestOptions;

class ClerkService
{
    public function isUserAuthenticated(LaravelRequest $laravelRequest): bool
    {
        $psrRequest = $this->convertToPsrRequest($laravelRequest);

        $options = new AuthenticateRequestOptions(
            secretKey: env('CLERK_SECRET_KEY'),
            authorizedParties: [env('FRONTEND_URL')]
        );

        $state = AuthenticateRequest::authenticateRequest($psrRequest, $options);

        return $state->isSignedIn();
    }

    public function getUserId(LaravelRequest $laravelRequest): ?string
    {
        $psrRequest = $this->convertToPsrRequest($laravelRequest);

        $options = new AuthenticateRequestOptions(
            secretKey: env('CLERK_SECRET_KEY'),
            authorizedParties: [env('FRONTEND_URL')]
        );

        $state = AuthenticateRequest::authenticateRequest($psrRequest, $options);

        return $state->isSignedIn() ? $state->payload['sub'] : null;
    }

    private function convertToPsrRequest(LaravelRequest $laravelRequest): PsrRequest
    {
        return new PsrRequest(
            $laravelRequest->method(),
            $laravelRequest->fullUrl(),
            $laravelRequest->headers->all(),
            $laravelRequest->getContent()
        );
    }
}
