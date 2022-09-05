<?php

namespace App\Util;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class RequestValidator
{
    /**
     * @param Request $request
     */
    public function validateGetTenders(Request $request): void
    {
        $name = $request->get("name");
        if ($name !== null) {
            if (mb_strlen($name) <= 0) {
                throw new BadRequestHttpException("Неверный параметр name!");
            }
        }

        $date = $request->get("date");
        if ($date !== null) {
            $match = preg_match("/^[0-2][0-9][0-9][0-9]-[0-1][0-9]-[0-3][0-9]$/", $date);
            if ($match === 0 || $match === false) {
                throw new BadRequestHttpException("Неверный параметр date!");
            }
        }
    }

    public function validateCreateTender(array $data): void
    {
        $properties = ["external_code", "number", "status", "name"];

        foreach ($properties as $property) {
            if (!isset($data[$property]) || empty($data[$property])) {
                throw new BadRequestHttpException("Неверный параметр: ".$property);
            }
        }
    }
}