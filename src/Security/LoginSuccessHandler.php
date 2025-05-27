<?php

namespace App\Security;

use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;

class LoginSuccessHandler implements AuthenticationSuccessHandlerInterface
{
    private UrlGeneratorInterface $urlGenerator;

    public function __construct(UrlGeneratorInterface $router)
    {
        $this->urlGenerator = $router;
    }

    // Ici la signature correcte avec 2 arguments uniquement
    public function onAuthenticationSuccess(Request $request, TokenInterface $token): ?Response
    {
        $user = $token->getUser();
        $roles = $user->getRoles();

        if (in_array('ROLE_ADMIN', $roles)) {
            $route = 'admin_dashboard';
        } elseif (in_array('ROLE_ORGANISATEUR', $roles)) {
            $route = 'organisateur_dashboard';
        } else {
            $route = 'app_home';
        }

        return new RedirectResponse($this->urlGenerator->generate($route));
    }
}
