<?php

namespace Icetig\Bundle\ApiBundle\Controller;

use Icetig\Bundle\ApiBundle\Exception\IncorrectPropertyException;
use Icetig\Bundle\UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;

class UserController extends AbstractApiController
{
    public function createAction(Request $request)
    {
        $authenticated = $this->autoAuthenticateUser($request);

        if (!$authenticated instanceof User
            || !$this->isActionAuthorized('create_group_user', $authenticated))
            return $this->getJsonErrorResponse([401]);

        $data = json_decode($request->getContent(), true);
        if ($data == null)
            return $this->getJsonErrorResponse([400], ['Incorrect JSON data']);
        try {
            $user = new User($data);
        } catch (IncorrectPropertyException $e) {
            return $this->getJsonErrorResponse([400], [$e->getMessage()]);
        }

        $errors = $this->get('validator')->validate($user);
        if (count($errors) > 0) {
            $codes = [];
            $descriptions = [];
            foreach ($errors as $error) {
                $codes[] = 400;
                $descriptions[] = $error->getPropertyPath() . ': ' . $error->getMessage();
            }
            return $this->getJsonErrorResponse($codes, $descriptions);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        return $this->getApiJsonResponse([
            'data' => $user->getData(),
        ], 201);
    }

    public function getAction(Request $request, $userId)
    {
        $authenticated = $this->autoAuthenticateUser($request);

        if (!$authenticated instanceof User)
            return $this->getJsonErrorResponse([401]);

        $user = $this->getDoctrine()->getRepository('UserBundle:User')->find($userId);

        if (!$user instanceof User)
            return $this->getJsonErrorResponse([404]);

        if ($user->getId() === $authenticated->getId()) {
            if (!$this->isActionAuthorized('read_own_user', $authenticated))
                return $this->getJsonErrorResponse([403]);
        } else if (!$this->isActionAuthorized('read_group_user', $authenticated))
            return $this->getJsonErrorResponse([403]);

        return $this->getApiJsonResponse([
            'data' => $user->getData(),
        ]);
    }

    public function getSanctionsAction(Request $request, $userId)
    {
        $authenticated = $this->autoAuthenticateUser($request);

        if (!$authenticated instanceof User)
            return $this->getJsonErrorResponse([401]);

        $user = $this->getDoctrine()->getRepository('UserBundle:User')->find($userId);

        if (!$user instanceof User)
            return $this->getJsonErrorResponse([404]);

        if ($user->getId() === $authenticated->getId()) {
            if (!$this->isActionAuthorized('read_own_user_sanctions', $authenticated))
                return $this->getJsonErrorResponse([403]);
        } else if (!$this->isActionAuthorized('read_group_user_sanctions', $authenticated))
            return $this->getJsonErrorResponse([403]);

        return $this->getApiJsonResponse([
            'data' => $user->getSanctionsData(),
        ]);
    }

    public function getPermissionsAction(Request $request, $userId)
    {
        $authenticated = $this->autoAuthenticateUser($request);

        if (!$authenticated instanceof User)
            return $this->getJsonErrorResponse([401]);

        $user = $this->getDoctrine()->getRepository('UserBundle:User')->find($userId);

        if (!$user instanceof User)
            return $this->getJsonErrorResponse([404]);

        if ($user->getId() === $authenticated->getId()) {
            if (!$this->isActionAuthorized('read_own_user_permissions', $authenticated))
                return $this->getJsonErrorResponse([403]);
        } else if (!$this->isActionAuthorized('read_group_user_permissions', $authenticated))
            return $this->getJsonErrorResponse([403]);

        return $this->getApiJsonResponse([
            'data' => $user->getPermissions(),
        ]);
    }

    public function getGroupsAction(Request $request, $userId)
    {
        $authenticated = $this->autoAuthenticateUser($request);

        if (!$authenticated instanceof User)
            return $this->getJsonErrorResponse([401]);

        $user = $this->getDoctrine()->getRepository('UserBundle:User')->find($userId);

        if (!$user instanceof User)
            return $this->getJsonErrorResponse([404]);

        if ($user->getId() === $authenticated->getId()) {
            if (!$this->isActionAuthorized('read_own_user_groups', $authenticated))
                return $this->getJsonErrorResponse([403]);
        } else if (!$this->isActionAuthorized('read_group_user_groups', $authenticated))
            return $this->getJsonErrorResponse([403]);

        return $this->getApiJsonResponse([
            'data' => $user->getGroupsData(),
        ]);
    }
}
