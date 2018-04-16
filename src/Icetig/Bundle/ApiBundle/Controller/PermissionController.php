<?php

namespace Icetig\Bundle\ApiBundle\Controller;

use Icetig\Bundle\UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;

class PermissionController extends AbstractApiController
{
    public function getAction(Request $request)
    {
        $authenticated = $this->autoAuthenticateUser($request);

        if (!$authenticated instanceof User)
            return $this->getJsonErrorResponse([401]);

//        if ($user->getId() === $authenticated->getId()) {
//            if (!$this->isActionAuthorized('read_own_user', $authenticated))
//                return $this->getJsonErrorResponse([403]);
//        } else if (!$this->isActionAuthorized('read_group_user', $authenticated))
//            return $this->getJsonErrorResponse([403]);
//
//        return $this->getApiJsonResponse([
//            'data' => $user->getData(),
//        ]);
        // TODO

        return $this->getJsonErrorResponse([503]);
    }
}
