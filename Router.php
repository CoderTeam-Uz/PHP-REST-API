<?php
include_once "Api.php";
class Router
{
    private static function response($data, $code)
    {
        http_response_code($code);
        echo json_encode($data);
    }

    private static function validate($data) {
        if (!isset($data["table"])) {
            throw new InvalidArgumentException("table field required!!", 500);
        }
    }

    public static function route($data) {
        try {
            self::validate($data);
            switch ($data["table"]) {
                case "sample":
                    include "Sample.php";
                    $api = new Sample($data);
                    $result = $api->run();
                    break;
                default:
                    throw new RuntimeException("This API is not exists", 500);
            }
        } catch (Exception $ex) {
            $result = array(
                "message" => $ex->getMessage(),
                "code" => $ex->getCode()
            );
            self::response($result, $ex->getCode());
            exit;
        }
        self::response($result, 200);
    }
}