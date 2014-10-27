<?php

namespace Namshi\Bundle\PhoneBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Namshi\Bundle\PhoneBundle\Service\PhoneService;
use JMS\Serializer\SerializationContext;
use Symfony\Component\HttpFoundation\JsonResponse;
use Namshi\Bundle\PhoneBundle\Entity\Phone;

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

    public function indexAction()
    {
        /** @var PhoneService $phoneService */
        $phoneService = $this->get("namshi.phone.service.phone");

        $phoneData = $phoneService->model->findAll();

        $serializer = \JMS\Serializer\SerializerBuilder::create()->build();
        $phoneDataAsJson = $serializer->serialize(
            $phoneData,
            'json',
            SerializationContext::create()->setGroups(array('api'))
        );

        $phoneDataAsJson = json_decode($phoneDataAsJson);

        $this->ajaxResponse->success = self::STATUS_SUCCESS;
        $this->ajaxResponse->result = $phoneDataAsJson;

        return new JsonResponse($this->ajaxResponse);
    }

    public function listAction($customer)
    {
        /** @var PhoneService $phoneService */
        $phoneService = $this->get("namshi.phone.service.phone");

        $phoneData = $phoneService->model->findBy(array('customer' => $customer));

        $serializer = \JMS\Serializer\SerializerBuilder::create()->build();
        $phoneDataAsJson = $serializer->serialize(
            $phoneData,
            'json',
            SerializationContext::create()->setGroups(array('api'))
        );

        $phoneDataAsJson = json_decode($phoneDataAsJson);

        $this->ajaxResponse->success = self::STATUS_SUCCESS;
        $this->ajaxResponse->result = $phoneDataAsJson;

        return new JsonResponse($this->ajaxResponse);
    }

    public function activateAction($phoneId)
    {
        try{
            /** @var PhoneService $phoneService */
            $phoneService = $this->get("namshi.phone.service.phone");

            /** @var Phone $phone */
            $phone = $phoneService->model->find($phoneId);

            if ($phone) {
                $phone->setStatus('active');

                $phoneService->em->persist($phone);
                $phoneService->em->flush();

                $this->ajaxResponse->success = self::STATUS_SUCCESS;
                $this->ajaxResponse->result = "Phone is activated";
            } else {
                $this->ajaxResponse->success = self::STATUS_ERROR;
                $this->ajaxResponse->result = "Phone not found!";
            }

        } catch(\Exception $e) {
            $this->ajaxResponse->success = self::STATUS_ERROR;
            $this->ajaxResponse->result = $e->getMessage();
        }

        return new JsonResponse($this->ajaxResponse);
    }
}
