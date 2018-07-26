<?php
namespace App\Security;

use App\Entity\User;
use App\Exception\AccountBlockedException;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Exception\AccountExpiredException;
use Symfony\Component\Security\Core\Exception\AccountStatusException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user)
    {
        if (!$user instanceof User) {
            return;
        }

        // user account is expired, the user may be notified
        if ($user->getAttempts() >= 5) {
            throw new AccountBlockedException("Account have been blocked due to exceeded number of login attempts.");
        }
    }

    public function checkPostAuth(UserInterface $user)
    {

    }
}