<?php

namespace Icetig\Bundle\ApiBundle\Controller;

use Icetig\Bundle\ApiBundle\Entity\Access;
use Icetig\Bundle\UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends AbstractApiController
{
    public function getAccessAction(Request $request)
    {
        $securityProvider = $this->get('icetig_api.provider.security');

        if (!($authenticated = $securityProvider->getAuthenticated($request, $this->getDoctrine())) instanceof User) {
            return $this->getJsonErrorResponse(
                [401],
                [],
                [
                    'www-authenticate' => 'Can\'t create access for provided tokens',
                ]
            );
        }

        $accessRepository = $this->getDoctrine()->getRepository('ApiBundle:Access');

        $delay = $request->get('stay_connected') ? 'P1M' : 'PT20M';
        $access = $accessRepository->createNew($authenticated, $delay);

        $access->setAccessToken($securityProvider->getRandomToken());
        $access->setSignatureToken($securityProvider->getRandomToken());

        $em = $this->getDoctrine()->getManager();
        $em->persist($access);
        $em->flush();

        $response =  $this->getApiJsonResponse([
            'data' => $access->getData(),
        ]);

        $accessCookie = new Cookie(
            self::ACCESS_TOKEN_COOKIE_NAME,
            $access->getAccessToken(),
            $access->getExpirationDate(),
            '/',
            null,
            true
        );

        $response->headers->setCookie($accessCookie);

        return $response;
    }

    public function deleteAccessAction(Request $request)
    {
        $access = $this->autoAuthenticate($request);

        if (!$access instanceof Access) {
            return $this->getJsonErrorResponse([401]);
        }

        $em = $this->getDoctrine()->getManager();

        $access->setExpirationDate(new \DateTime());
        $em->persist($access);
        $em->flush();

        $response = $this->getApiEmptyResponse();

        $resetAccessCookie = new Cookie(
            self::ACCESS_TOKEN_COOKIE_NAME,
            '',
            -1,
            '/',
            null,
            true
       	);

        $response->headers->setCookie($resetAccessCookie);

        return $response;
    }
}
