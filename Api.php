<?php

include_once  "Database.php";
include_once  "NotImplementedException.php";

abstract class Api
{
    private $method = ''; //GET|POST|PUT|DELETE
    protected $query = "";
    protected $data = "";

    private static $encrypt_method = "AES-256-CBC";
    private static $secret_key = 'your secret key';
    private static $secret_iv = 'your secret key';
    /**
     * @var PDO
     */
    protected $conn;

    protected static function required($field, $field_name) {
        if (!isset($field)) {
            throw new InvalidArgumentException('"' . $field_name . '" required!!!', 404);
        }
    }

    protected static function encode($uid) {
        $key = hash('sha256', self::$secret_key);
        $iv = substr(hash('sha256', self::$secret_iv), 0, 16);

        return base64_encode(openssl_encrypt($uid, self::$encrypt_method, $key, 0, $iv));
    }

    protected static function decode($uid) {
        $key = hash('sha256', self::$secret_key);
        $iv = substr(hash('sha256', self::$secret_iv), 0, 16);

        return openssl_decrypt(base64_decode($uid), self::$encrypt_method, $key, 0, $iv);
    }

    public function __construct($data, $query) {
        header("Access-Control-Allow-Orgin: *");
        header("Access-Control-Allow-Methods: *");
        header("Content-Type: application/json");
        $this->data = $data;
        $this->query = $query;
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->conn = Database::connect();
    }

    public function run() {
        $action = $this->whatIsAction();

        if (method_exists($this, $action)) {
            return $this->{$action}();
        } else {
            throw new RuntimeException('Invalid Method', 405);
        }
    }

    protected function whatIsAction()
    {
        $method = $this->method;
        switch ($method) {
            case 'GET':
                return 'getAction';
            case 'POST':
                return 'postAction';
            case 'PUT':
                return 'putAction';
            case 'DELETE':
                return 'deleteAction';
            default:
                return null;
        }
    }

    /**
     * @throws NotImplementedException
     */
    protected function getAction() {
        throw new NotImplementedException("This method not implemented", 500);
    }

    /**
     * @throws NotImplementedException
     */
    protected function postAction() {
        throw new NotImplementedException("This method not implemented", 500);
    }

    /**
     * @throws NotImplementedException
     */
    protected function putAction(){
        throw new NotImplementedException("This method not implemented", 500);
    }

    /**
     * @throws NotImplementedException
     */
    protected function deleteAction(){
        throw new NotImplementedException("This method not implemented", 500);
    }

}