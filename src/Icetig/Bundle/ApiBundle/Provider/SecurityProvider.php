<?php

namespace Icetig\Bundle\ApiBundle\Provider;

use Doctrine\Common\Persistence\ManagerRegistry;
use Icetig\Bundle\UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;

class SecurityProvider
{
    const ALLOWED_HMAC_ALGORITHMS = [
        'sha512' => 'sha512',
    ];
    const ALLOWED_SIGNATURE_DATE_SECONDS_DELAY = 1000;

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

    public function isWellSignedRequest(array $hmacSignatureOptions, Request $request)
    {
        if (
            !array_key_exists('key', $hmacSignatureOptions)
            || !array_key_exists('hash', $hmacSignatureOptions)
            || !array_key_exists('time', $hmacSignatureOptions)
            || !array_key_exists('algo', $hmacSignatureOptions)
            || !array_key_exists($hmacSignatureOptions['algo'], self::ALLOWED_HMAC_ALGORITHMS)
        ) {
            return false;
        }

        $key = $hmacSignatureOptions['key'];
        $hash = $hmacSignatureOptions['hash'];
        $time = intval($hmacSignatureOptions['time']);
        $algo = $hmacSignatureOptions['algo'];

        if ($time + self::ALLOWED_SIGNATURE_DATE_SECONDS_DELAY < time()) {
            return false;
        }

        $method = $request->getMethod();
        $uri = $request->getRequestUri();
        $content = $request->getContent();
        $contentHash = empty($content) ? '' : hash('md5', $content);

        $data = $method.$uri.$contentHash.$time;

        $checkHash = hash_hmac(self::ALLOWED_HMAC_ALGORITHMS[$algo], $data, $key);

        return hash_equals($checkHash, $hash);
    }
}