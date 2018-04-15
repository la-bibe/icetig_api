<?php

namespace Icetig\Bundle\ApiBundle\Controller;

use Icetig\Bundle\ApiBundle\Entity\Access;
use Icetig\Bundle\UserBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

abstract class AbstractApiController extends Controller
{
    const ACCESS_TOKEN_COOKIE_NAME = 'access_token';
    const HTTP_CODES = [
        100 => 'Continue',
        101 => 'Switching Protocols',
        102 => 'Processing',
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        207 => 'Multi Status',
        208 => 'Already Reported',
        226 => 'IM Used',
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        306 => 'Switch Proxy',
        307 => 'Temporary Redirect',
        308 => 'Permanent Redirect',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Payload Too Large',
        414 => 'URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Range Not Satisfiable',
        417 => 'Expectation Failed',
        418 => 'I\'m a teapot',
        421 => 'Misdirected Redirect',
        422 => 'Unprocessable Entity',
        423 => 'Locked',
        424 => 'Failed Dependency',
        426 => 'Upgrade Required',
        428 => 'Precondition Required',
        429 => 'Too Many Requests',
        431 => 'Request Header Fields Too Large',
        451 => 'Unavailable For Legal Reasons',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported',
        506 => 'Variant Also Negotiates',
        507 => 'Insufficient Storage',
        508 => 'Loop Detected',
        510 => 'Not Extended',
        511 => 'Network Authentication Required',
    ];

    /**
     * Generate error response respecting http://jsonapi.org/ specifications
     * given an array of error codes. The function is meant to be enhanced by
     * logging all the errors in the db and describing them better
     *
     * @param array $errorCodes
     * @param array $details
     *
     * @return JsonResponse
     */
    protected function getJsonErrorResponse(array $errorCodes = [], array $details = [])
    {
        $data = [];
        $data['errors'] = [];

        $errorGroupsScores = [
            100 => 0,
            200 => 0,
            300 => 0,
            400 => 0,
            500 => 0,
        ];

        foreach ($errorCodes as $errorCode) {
            if (!array_key_exists($errorCode, self::HTTP_CODES)) {
                $errorCode = 500;
            }

            ++$errorGroupsScores[intval($errorCode / 100) * 100];

            $data['errors'][] = [
                'status' => strval($errorCode),
                'title' => self::HTTP_CODES[$errorCode],
                'id' => null,
                'links' => [
                    'about' => null,
                ],
                'code' => null,
                'detail' => null,
                'source' => null,
                'meta' => null,
            ];
        }

        if (1 === count($errorCodes)) {
            $responseStatus = $errorCodes[0];
        } else {
            $responseStatus = array_keys($errorGroupsScores, max($errorGroupsScores))[0];
        }

        $response = $this->getApiJsonResponse(
            $data,
            $responseStatus
        );

        if (401 === $responseStatus) {
            $wwwAuthenticateValue = 'Basic realm:"';
            $wwwAuthenticateValue .= isset($details['www-authenticate']) ?
                $details['www-authenticate'] :
                'Can\'t access to the resource without proper authentication';
            $wwwAuthenticateValue .= '"';
            $response->headers->set('WWW-Authenticate', $wwwAuthenticateValue);
        }

        return $response;
    }

    /**
     * Simply return a JsonResponse but set some mandatory headers before
     * returning it
     *
     * @param null  $data
     * @param int   $status
     * @param array $headers
     * @param bool  $json
     *
     * @return JsonResponse
     */
    protected function getApiJsonResponse($data = null, $status = 200, $headers = array(), $json = false)
    {
        $response = new JsonResponse($data, $status, $headers, $json);

        return $response;
    }

    /**
     * Generate empty response but with good mandatory headers
     *
     * @return Response
     */
    protected function getApiEmptyResponse()
    {
        return new Response(
            '',
            204
        );
    }

    /**
     * Try to authenticate the user based on the request
     *
     * @param Request $request
     *
     * @return Access|null
     */
    protected function autoAuthenticate(Request $request)
    {
        $accessRepository = $this->getDoctrine()->getRepository('ApiBundle:Access');
        $securityProvider = $this->get('icetig_api.provider.security');

        if (
            null !== ($authorizationHeader = $request->headers->get('Authorization'))
            && ($authorizationHeader = explode(' ', $authorizationHeader))
            && 2 === count($authorizationHeader)
            && ($hmacOptions = explode(',', $authorizationHeader[1]))
            && 'HMAC' === $authorizationHeader[0]
            && null !== ($accessToken = $request->cookies->get(self::ACCESS_TOKEN_COOKIE_NAME))
            && ($access = $accessRepository->findOneBy(['accessToken' => $accessToken])) instanceof Access
        ) {
            $hmacOptionsArray = [];
            foreach ($hmacOptions as $hmacOption) {
                if (
                    ($hmacOptionArray = explode('=', $hmacOption))
                    && 2 === count($hmacOptionArray)
                ) {
                    $hmacOptionsArray[$hmacOptionArray[0]] = $hmacOptionArray[1];
                }
            }

            $hmacOptionsArray['key'] = $access->getSignatureToken();

            if ($securityProvider->isWellSignedRequest($hmacOptionsArray, $request)) {
                return $access;
            }
        }

        return null;
    }

    /**
     * Try to authenticate the user based on the request
     *
     * @param Request $request
     *
     * @return User|null
     */
    protected function autoAuthenticateUser(Request $request)
    {
        $access = $this->autoAuthenticate($request);

        if ($access instanceof Access)
            return $access->getUser();

        return null;
    }

    /**
     * Test if authenticated user have enough rights to perform an action
     *
     * @param string $action    The requested action
     * @param User $authenticated   The authenticated user
     * @param User|null $subject    The subject of the action if needed
     *
     * @return bool
     */
    protected function isActionAuthorized(string $action, User $authenticated, User $subject = null)
    {
        $actionsAcl = $this->container->getParameter('actions_acl');
        $securityProvider = $this->get('icetig_api.provider.security');

        return $securityProvider->isActionAuthorized($action, $authenticated, $subject, $actionsAcl);
    }
}