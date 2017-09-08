<?php

namespace Chaplean\Bundle\RestClientBundle\Tests\Resources\Controller;

use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class FakeApiController.
 *
 * @author    Matthias - Chaplean <matthias@chaplean.coop>
 * @copyright 2014 - 2017 Chaplean (http://www.chaplean.coop)
 * @since     3.0.0
 * @
 */
class FakeApiController extends FOSRestController
{
    /**
     * @Annotations\Get("/fake/get")
     *
     * @return Response
     */
    public function getAction()
    {
        $view = $this->view(['result' => 'success']);

        return $this->handleView($view);
    }
}
