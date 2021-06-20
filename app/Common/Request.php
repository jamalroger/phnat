<?php

namespace App\Common;

class Request
{

    public static function getMethod()
    {

        return $_SERVER['REQUEST_METHOD'];
    }
    public function __get($name)
    {

        return isset(self::getRequestData()[$name]) ? self::getRequestData()[$name]  : null;
    }

    public static function getHost()
    {

        return $_SERVER['HTTP_HOST'];
    }

    public static function getRequestData()
    {
        $data =  json_decode(file_get_contents('php://input'));
        if (!$data) {
            $data  = $_REQUEST;
        }
        return $data;
    }
    public static function getRoot()
    {
        return rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\') . '/';
    }
    public static function getRequestPath()
    {
        return substr(explode('?', $_SERVER['REQUEST_URI'], 2)[0], strlen(self::getRoot()));
    }

    public static function getRequestController()
    {
        $paths =  explode('/', self::getRequestPath());
        $filename =  app_root . '/Controllers';
        $controller = null;
        $method = null;
        $args =  [];
        foreach ($paths as $key => $path) {
            $filename .= '/' . ucfirst($path);
            $next_filename = isset($paths[$key + 1]) ? $filename . '/' . ucfirst($paths[$key + 1]) : '';

            if ((file_exists($filename . 'Index.php') || file_exists($filename . '.php')) && !(file_exists($next_filename . 'Index.php') || file_exists($next_filename . '.php'))) {
                $exists_file = file_exists($filename . 'Index.php') ? $filename . 'Index' : $filename;
                $controller =  str_replace('/', '\\', "App" . substr($exists_file, strlen(app_root)));
                $method =  isset($paths[$key + 1]) ? $paths[$key + 1] : 'index';
                if (!method_exists($controller, $method)) {
                    continue;
                }
                for ($i = $key + 2; $i < count($paths); $i++) {
                    $args[] = $paths[$i];
                }
                return [
                    'controller' => $controller,
                    'method' => $method,
                    'args' => $args,
                ];
            }
        }

        echo "Uknown Request 404";
        exit(0);
    }
}
