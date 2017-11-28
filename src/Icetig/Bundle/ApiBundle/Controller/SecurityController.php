<?php

namespace Icetig\Bundle\ApiBundle\Controller;

use Icetig\Bundle\UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends AbstractApiController
{
    public function getAccessAction(Request $request)
    {
        $securityProvider = $this->get('icetig_api.provider.security');

        if (!($authenticated = $securityProvider->getAuthenticated($request, $this->getDoctrine())) instanceof User) {
            return $this->getJsonErrorResponse(
                [401],
                [
                    'www-authenticate' => 'Can\'t create access for provided tokens',
                ]
            );
        }

        $accessRepository = $this->getDoctrine()->getRepository('ApiBundle:Access');

        $access = $accessRepository->createNew($authenticated);
        $access->setAccessToken($securityProvider->getRandomToken());
        $access->setSignatureToken($securityProvider->getRandomToken());

        $em = $this->getDoctrine()->getManager();
        $em->persist($access);
        $em->flush();

        $response =  $this->getApiJsonResponse([
            'data' => $access->getData(),
        ]);

        $accessCookie = new Cookie(
            'access_token',
            $access->getAccessToken(),
            $access->getExpirationDate(),
            '/',
            null,
            true
        );

        $response->headers->setCookie($accessCookie);

        return $response;
    }
}
