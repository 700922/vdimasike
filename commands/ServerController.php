<?php
namespace app\commands;

use app\models\EchoServer;
use yii\console\Controller;

class ServerController extends Controller
{
    public function actionStart($port = 8082)
    {
        // $server = new EchoServer();
        // if ($port) {
        //     $server->port = $port;
        // }
        // $server->start();
        require_once __DIR__ . "/../vendor/autoload.php";
		$port = 9911;
		$server = new \app\models\chat\BasicMultiRoomServer;
		\app\models\chat\BasicMultiRoomServer::run($server, $port);
    }
}