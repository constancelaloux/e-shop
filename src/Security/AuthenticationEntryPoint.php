<?php
namespace App\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class AuthenticationEntryPoint implements AuthenticationEntryPointInterface
{
    private $urlGenerator;
    private $flashBag;

    public function __construct(UrlGeneratorInterface $urlGenerator, FlashBagInterface $flashBag)
    {
        $this->urlGenerator = $urlGenerator;
        $this->flashBag = $flashBag;
    }

    public function start(Request $request, AuthenticationException $authException = null): RedirectResponse
    {
        // Add a custom flash message and redirect to the login page
        $this->flashBag->add('note', 'Vous devez vous connecter afin d\'accéder à cette page.');

        return new RedirectResponse($this->urlGenerator->generate('app_login'));
    }
}

