<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Http\Request;

final class RequirePassword
{
    protected ResponseFactory $responseFactory;

    protected UrlGenerator $urlGenerator;

    protected int $passwordTimeout;

    public function __construct(ResponseFactory $responseFactory, UrlGenerator $urlGenerator, int $passwordTimeout = null)
    {
        $this->responseFactory = $responseFactory;
        $this->urlGenerator = $urlGenerator;
        $this->passwordTimeout = $passwordTimeout ?: 7200;
    }

    /**
     * @param  Request  $request
     */
    public function handle($request, Closure $next, string $redirectToRoute = null): mixed
    {
        if ($this->shouldConfirmPassword($request)) {
            if ($request->ajax()) {
                return $this->responseFactory->json(view('auth.passwords.modal.confirm')->render(), 423);
            }
            return $this->responseFactory->redirectGuest(
                $this->urlGenerator->route($redirectToRoute ?? 'password.confirm')
            );
        }
        if ($request->ajax()) {
            return $this->responseFactory->json();
        }
        return $next($request);
    }

    /**
     * Determine if the confirmation timeout has expired.
     *
     * @param  Request  $request
     */
    protected function shouldConfirmPassword($request): bool
    {
        $confirmedAt = time() - $request->session()->get('auth.password_confirmed_at', 0);

        return $confirmedAt > $this->passwordTimeout;
    }
}
