<?php

namespace Namshi\Bundle\CustomerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Namshi\Bundle\CustomerBundle\Service\CustomerService;
use JMS\Serializer\SerializationContext;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller
{
    const STATUS_SUCCESS = 1;
    const STATUS_ERROR = -1;

    protected $response;

    public function __construct()
    {
        $this->ajaxResponse = (object) array(
            'success'    => self::STATUS_ERROR,
            'result'    => ''
        );
    }

    public function indexAction($customer)
    {
        /** @var CustomerService $customerService */
        $customerService = $this->get("namshi.customer.service.customer");

        $customerData = $customerService->model->find($customer);

        $serializer = \JMS\Serializer\SerializerBuilder::create()->build();
        $customerDataAsJson = $serializer->serialize(
            $customerData,
            'json',
            SerializationContext::create()->setGroups(array('api'))
        );

        $customerDataAsJson = json_decode($customerDataAsJson);

        $this->ajaxResponse->success = self::STATUS_SUCCESS;
        $this->ajaxResponse->result = $customerDataAsJson;

        return new JsonResponse($this->ajaxResponse);
    }
}
