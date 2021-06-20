<?php

use App\Common\Session;

function view($view, $data = [], $layout = "layout")
{
    extract($data);
    ob_start();
    require_once  root . "/views/" . $layout . ".php";
    $result = ob_get_clean();

    return $result;
}

function auth()
{
    return Session::getInstance();
}
