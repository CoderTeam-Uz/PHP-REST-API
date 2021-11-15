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

    }

    public static function route($data) {
        try {
            $path = explode("?", trim($_SERVER['REQUEST_URI']));
            $query = explode("/", trim($path[0], '/'));
            if ($query[0] != "api") {
                throw new InvalidArgumentException("This works on api path!!!", 500);
            }
            self::validate($data);
            switch ($query[1]) {
                case "sample":
                    include "Sample.php";
                    $api = new Sample($data, $query);
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