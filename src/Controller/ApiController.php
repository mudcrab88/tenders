<?php

namespace App\Controller;

use App\Service\TenderService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Controller\TokenAuthenticatedController;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController implements TokenAuthenticatedController
{
    protected TenderService $service;

    public function __construct(TenderService $service)
    {
        $this->service = $service;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     * @Route("/tenders", name="tenders_get_all", methods={"GET"})
     */
    public function getTenders(Request $request): JsonResponse
    {
        $params = [];

        if ($request->get("name") !== null) {
            $params["name"] = $request->get("name");
        }

        if ($request->get("date") !== null) {
            $params["date"] = $request->get("date");
        }

        $tenders = $this->service->getByParams($params);

        return new JsonResponse($tenders);
    }
}