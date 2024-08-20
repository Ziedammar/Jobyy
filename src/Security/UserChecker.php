<?php


namespace App\Security;


use Symfony\Component\Security\Core\Exception\AccountStatusException;
use App\Entity\User;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;

class UserChecker implements \Symfony\Component\Security\Core\User\UserCheckerInterface
{

    /**
     * @inheritDoc
     */
    public function checkPreAuth(UserInterface $user)
    {
        {
            if ($user->getStatus()==1) {
                throw new CustomUserMessageAuthenticationException("Your account has been banned ! If you think this was a mistake please contact us by email at contact@jobby.tn .");
            }
            if ($user->getVerToken()!='Active') {
                throw new CustomUserMessageAuthenticationException("Your account hasn't been verified. Please Check your email .");
            }

        }
    }

    /**
     * @inheritDoc
     */
    public function checkPostAuth(UserInterface $user)
    {
        // TODO: Implement checkPostAuth() method.
    }
}