<?php

include_once "Router.php";

function decode_data($data) {
    return json_decode($data);
}

$data = "";
if (isset($_GET)) {
    $data = $_GET;
} else
if (isset($_POST)) {
    $data = $_POST;
} else {
    $data = decode_data(file_get_contents("php://input"));
}

Router::route($data);