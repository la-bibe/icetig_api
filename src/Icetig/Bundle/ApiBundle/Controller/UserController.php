<?php

namespace Icetig\Bundle\ApiBundle\Controller;

use Icetig\Bundle\UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;

class UserController extends AbstractApiController
{
    public function getAction(Request $request, $userId)
    {
        $authenticated = $this->autoAuthenticateUser($request);

        if (!$authenticated instanceof User)
            return $this->getJsonErrorResponse([401]);

        $user = $this->getDoctrine()->getRepository('UserBundle:User')->find($userId);

        if (!$user instanceof User)
            return $this->getJsonErrorResponse([404]);

        if (!$this->isActionAuthorized('read_group_user', $authenticated, $user))
            return $this->getJsonErrorResponse([403]);

        return $this->getApiJsonResponse([
            'data' => $user->getData(),
        ]);
    }
}
