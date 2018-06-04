<?php

namespace Icetig\Bundle\ApiBundle\Controller;

use Icetig\Bundle\PedagoBundle\Entity\Sanction;
use Icetig\Bundle\UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;

class SanctionController extends AbstractApiController
{
    public function listAction(Request $request)
    {
        $authenticated = $this->autoAuthenticateUser($request);

        if (!$authenticated instanceof User)
            return $this->getJsonErrorResponse([401]);

        $groups = $this->getDoctrine()->getRepository("UserBundle:Group")->findAll();

        $sanctions = [];

        $sanctionRepository = $this->getDoctrine()->getRepository('PedagoBundle:Sanction');

        foreach ($groups as $group) {
            if ($this->isGroupActionAuthorized('read_group_user_sanctions', $authenticated, $group)) {
                $groupSanctions = $sanctionRepository->getGroupSanctions($group);
                $sanctions = array_unique(array_merge($sanctions, $groupSanctions), SORT_REGULAR);
            }
        }

        $data = [];

        foreach ($sanctions as $sanction) {
            if ($sanction instanceof Sanction)
                $data[] = $sanction->getShortData();
        }

        return $this->getApiJsonResponse([
            'data' => $data,
        ]);
    }
}
