<?php

namespace App\Controller;

use App\DataTransferObject\TenderDTO;
use App\Service\TenderService;
use App\Controller\TokenAuthenticatedController;
use App\Util\RequestValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class ApiController extends AbstractController implements TokenAuthenticatedController
{
    protected TenderService $service;

    public function __construct(TenderService $service, RequestValidator $validator)
    {
        $this->service = $service;
        $this->validator = $validator;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     * @Route("/tenders", name="tenders_get_all", methods={"GET"})
     */
    public function getTenders(Request $request): JsonResponse
    {
        try {
            $this->validator->validateGetTenders($request);

            $params = $this->getTendersParams($request);

            $tenders = $this->service->getByParams($params);

            return new JsonResponse($tenders);
        } catch (BadRequestHttpException $e) {
            return new JsonResponse([
                'message' => 'Неверные параметры запроса. '.$e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        } catch (AccessDeniedHttpException $e) {
            return new JsonResponse([
                'message' => 'Доступ запрещен.'
            ], Response::HTTP_FORBIDDEN);
        } catch (NotFoundHttpException $e) {
            return new JsonResponse([
                'message' => $e->getMessage()
            ], Response::HTTP_NOT_FOUND);
        } catch (\Throwable $e) {
            return new JsonResponse([
                'message' => 'Внутренняя ошибка сервера!'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     * @Route("/tenders/{id}", name="tenders_get_one", methods={"GET"})
     */
    public function getTender(Request $request, int $id): JsonResponse
    {
        try {
            $tender = $this->service->getById($id);

            return new JsonResponse($tender, Response::HTTP_OK);
        } catch (AccessDeniedHttpException $e) {
            return new JsonResponse([
                'message' => 'Доступ запрещен.'
            ], Response::HTTP_FORBIDDEN);
        } catch (NotFoundHttpException $e) {
            return new JsonResponse([
                'message' => $e->getMessage()
            ], Response::HTTP_NOT_FOUND);
        } catch (\Throwable $e) {
            return new JsonResponse([
                'message' => 'Внутренняя ошибка сервера.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     * @Route("/tenders", name="tenders_create_one", methods={"POST"})
     */
    public function createTender(Request $request): JsonResponse
    {
        try {
            $data = json_decode($request->getContent(), true);
            $this->validator->validateCreateTender($data);

            $dto = TenderDTO::fromJsonDecoded($data);
            $this->service->createFromDto($dto);

            return new JsonResponse([
                'message' => 'Тендер успешно создан.'
            ], Response::HTTP_CREATED);
        } catch (BadRequestHttpException $e) {
            return new JsonResponse([
                'message' => 'Неверные параметры запроса. '.$e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        } catch (AccessDeniedHttpException $e) {
            return new JsonResponse([
                'message' => 'Доступ запрещен.'
            ], Response::HTTP_FORBIDDEN);
        }  catch (\Throwable $e) {
            return new JsonResponse([
                'message' => 'Внутренняя ошибка сервера!'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    /**
     * @param Request $request
     *
     * @return array
     */
    protected function getTendersParams(Request $request)
    {
        $params = [];

        if ($request->get("name") !== null) {
            $params["name"] = $request->get("name");
        }

        if ($request->get("date") !== null) {
            $params["date"] = $request->get("date");
        }

        return $params;
    }
}