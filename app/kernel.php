<?php

namespace App;

use App\Common\Config;
use App\Common\Request;
use App\Models\User;
use Illuminate\Database\Capsule\Manager as Capsule;

class Kernel
{
    function __construct()
    {
        require_once app_root . "/Common/functions.php";
        $this->initDataBase();
    }

    public static function execute()
    {
        $controller = Request::getRequestController();
        $response =  (new $controller['controller'])->{$controller['method']}(new Request(), ...$controller['args']);
        if (is_array($response)) {
            echo json_encode($response);
        } else {
            echo $response;
        }
    }

    function initDataBase()
    {
        $capsule = new Capsule;
        $capsule->addConnection(Config::get('database'));
        $capsule->bootEloquent();
    }
}
