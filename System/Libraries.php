<?php
/**
 * Load libraries that you need
 */
use Medoo\Medoo;

class Libraries
{       
    public static function db()
    {
        return new Medoo([
            'database_type' => DB_TYPE,
            'database_name' => $_ENV['DB_NAME'],
            'server' => DB_HOST,
            'username' => $_ENV['DB_USERNAME'],
            'password' => $_ENV['DB_PASSWORD'],
            'port' => DB_PORT,
            'prefix' => DB_PREFIX
        ]);
    }

    public static function router()
    {
        $router = new AltoRouter();
        $router->setBasePath(PATH);
        include_once 'Router.php';
        $match = $router->match();
        if(!$match) {
            echo 404;
            header( $_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
            die;
        }
        list($controller,$action) = explode('#',$match['target']);
        return array(
            'controller'=>$controller,
            'action'=>$action,
            'params'=>$match['params'],
            'name'=>$match['name']
        );
    }

    public static function smarty()
    {
        $smarty = new Smarty();
        $smarty->template_dir = 'Views/default';
        $smarty->compile_dir = 'Views/template_c';
        return $smarty;
    }

    public static function error()
    {
        $whoops = new \Whoops\Run;
        $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
        $whoops->register();
    }
    
}
