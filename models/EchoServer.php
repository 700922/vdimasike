<?php
namespace app\models;

use consik\yii2websocket\events\WSClientEvent;
use consik\yii2websocket\WebSocketServer;
use Ratchet\ConnectionInterface;
use app\models\chat\ConnectedClient;

use app\models\chat\Interfaces\ConnectedClientInterface;

class EchoServer extends WebSocketServer
{
    public static $messageButch = array();
	public $rooms = array();
    public $clients = array();

    public function init()
    {
        parent::init();

        $this->on(self::EVENT_CLIENT_CONNECTED, function(WSClientEvent $e) {
            $e->client->name = null;
        });
    }


    protected function getCommand(ConnectionInterface $from, $msg)
    {
        $request = json_decode($msg, true);
        return !empty($request['action']) ? $request['action'] : parent::getCommand($from, $msg);
    }

    /**
     * @param ConnectedClientInterface $client
     * @param $roomId
     */
    protected function connectUserToRoom(ConnectedClientInterface $client, $roomId)
    {
        $this->rooms[$roomId][$client->getResourceId()] = $client;
        var_dump(count($this->clients));
        $this->clients[$client->getResourceId()] = $client;
    }
    /**
     * @param ConnectedClientInterface $client
     * @param $roomId
     */
    protected function createClient(ConnectionInterface $con, $name)
    {
        $client = new ConnectedClient;
        $client->setResourceId($con->resourceId);
        $client->setConnection($con);
        $client->setName($name);

        return $client;
    }


    /**
     * @param $roomId
     * @return mixed
     */
    protected function makeRoom($roomId)
    {
        if (!isset($this->rooms[$roomId])) {
            $this->rooms[$roomId] = array();
        }

        return $roomId;
    }

    public function commandWelcome(ConnectionInterface $conn, $msg){
        $request = json_decode($msg, true);
        $roomId = $this->makeRoom($request['roomId']);
        $client = $this->createClient($conn, $request['name']);
        $this->connectUserToRoom($client, $roomId);
        var_dump(123);
        foreach ($this->clients as $chatClient) {
            $chatClient->send( json_encode([
                // 'type' => 'chat',
                'action' => 'welcome',
                'from' => $client->name,
                'message' => 'qq'  ])); 
        }
    }
    public function commandChat(ConnectionInterface $client, $msg)
    {
        $request = json_decode($msg, true);
        $result = ['message' => ''];
        self::$messageButch[] = $msg;
        // var_dump(self::$messageButch);
        if(count(self::$messageButch) == 4 )
        	// var_dump('сейви по братски');
                var_dump(123);




        // if (!$client->name) {
        //     $result['message'] = 'Set your name';
        // } elseif (!empty($request['message']) && $message = trim($request['message']) ) {
        //     foreach ($this->clients as $chatClient) {
        //         var_dump($chatClient);
        //         $chatClient->send( json_encode([
        //             'type' => 'chat',
        //             'from' => $client->name,
        //             'message' => $message
        //         ]) );
        //     }
        // } else {
        //     $result['message'] = 'Enter message';
        // }

        // $client->send(json_encode($result));
    }

    public function commandSetName(ConnectionInterface $client, $msg)
    {
        $request = json_decode($msg, true);
        $result = ['message' => 'Username updated'];

        if (!empty($request['name']) && $name = trim($request['name'])) {
            $usernameFree = true;
            foreach ($this->clients as $chatClient) {
                if ($chatClient != $client && $chatClient->name == $name) {
                    $result['message'] = 'This name is used by other user';
                    $usernameFree = false;
                    break;
                }
            }

            if ($usernameFree) {
                $client->name = $name;
            }
        } else {
            $result['message'] = 'Invalid username';
        }

        $client->send( json_encode($result) );
    }

}