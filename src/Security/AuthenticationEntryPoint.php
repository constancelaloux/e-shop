<?php
namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;

class AuthenticationEntryPoint implements AuthenticationEntryPointInterface
{
    private $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    //une classe qui implémente l'interface 
    //AuthenticationEntryPointInterface. 
    //Cette interface possède une méthode (start()) 
    //qui est appelée chaque fois qu'un utilisateur non authentifié 
    //tente d'accéder à une ressource protégée 
    public function start(Request $request, AuthenticationException $authException = null): RedirectResponse
    {
        // add a custom flash message and redirect to the login page
        // Ajouter un message flash personnalisé et rediriger vers la page de connexion
        $request->getSession()->getFlashBag()->add('note', 'Vous devez vous connecter afin d\'accéder à cette page.');
        return new RedirectResponse($this->urlGenerator->generate('security_login'));
    }
}