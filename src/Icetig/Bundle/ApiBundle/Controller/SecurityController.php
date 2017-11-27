<?php

namespace Icetig\Bundle\ApiBundle\Controller;

use Icetig\Bundle\UserBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends Controller
{
    public function getAccessAction(Request $request)
    {
        $securityProvider = $this->get('icetig_api.provider.security');

        if (!($authenticated = $securityProvider->getAuthenticated($request, $this->getDoctrine())) instanceof User) {
            $response = new JsonResponse(
                [
                    'errors' => [
                        'id' => null,
                        'links' => [
                            'about' => null,
                        ],
                        'status' => null,
                        'code' => null,
                        'title' => 'Unauthorized',
                        'detail' => null,
                        'source' => null,
                        'meta' => null,
                    ]
                ],
                401
            ); // TODO uniform error response
            $response->headers->set('WWW-Authenticate', 'Basic realm:"Can\'t create access for provided tokens"');
            return $response;
        }

        $accessRepository = $this->getDoctrine()->getRepository('ApiBundle:Access');

        $access = $accessRepository->createNew($authenticated);
        $access->setAccessToken($securityProvider->getRandomToken());
        $access->setSignatureToken($securityProvider->getRandomToken());

        $em = $this->getDoctrine()->getManager();
        $em->persist($access);
        $em->flush();

        $response =  new JsonResponse([
            'data' => $access->getData(),
        ]);

        // TODO set httpOnly accessToken cookie

        return $response;
    }
}
