<?php

/**
 * Created by PhpStorm.
 * User: M4rk0
 * Date: 1/24/2018
 * Time: 1:45 AM
 */
namespace App\Listener;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class LoginListener implements AuthenticationSuccessHandlerInterface
{

    protected $router;
    protected $security;
    protected $em;

    public function __construct(RouterInterface $router, AuthorizationCheckerInterface $authChecker, ObjectManager $em)
    {
        $this->router = $router;
        $this->security = $authChecker;
        $this->em = $em;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        $user = $token->getUser();
        $user->setAttempts(0);
        $this->em->merge($user);
        $this->em->flush();

        return new RedirectResponse($this->router->generate('page_list'));
    }

}