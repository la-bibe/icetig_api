<?php

namespace Icetig\Bundle\ApiBundle\Provider;

use Doctrine\Common\Persistence\ManagerRegistry;
use Icetig\Bundle\UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;

class SecurityProvider
{
    /**
     * @return string An hexadecimal random string
     */
    public function getRandomToken()
    {
        return bin2hex(random_bytes(16));
    }

    public function getAuthenticated(Request $request, ManagerRegistry $doctrine)
    {
        $authorization = explode(' ', $request->headers->get('authorization'));
        if (2 === count($authorization) || 'Basic' === $authorization[0]) {
            $credentials = explode(':', base64_decode($authorization[1]));
            if (2 === count($credentials)) {
                $user = $doctrine->getRepository('UserBundle:User')->findOneBy(['email' => $credentials[0]]);
                if (
                    $user instanceof User
                    && null !== ($password = $user->getPassword())
                    && hash('sha512', "{$credentials[1]}{$user->getSalt()}") === $password
                ) {
                    return $user;
                }
            }
        }
        return null;
    }
}