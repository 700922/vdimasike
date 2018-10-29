<?php
namespace app\models\chat;

use app\models\chat\Interfaces\ConnectedClientInterface;
use Ratchet\ConnectionInterface;
use app\models\Rooms;
use app\models\Messages;
use app\models\User;

class BasicMultiRoomServer extends AbstractMultiRoomServer
{

    protected function makeUserWelcomeMessage(ConnectedClientInterface $client, $timestamp)
    {
        return vsprintf('Здарова пидр %s!', array($client->getName()));
    }

    protected function makeUserConnectedMessage(ConnectedClientInterface $client, $timestamp)
    {
        return vsprintf('%s подключился', array($client->getName()));
    }

    protected function makeUserDisconnectedMessage(ConnectedClientInterface $client, $timestamp)
    {
        return vsprintf('%s сьебался', array($client->getName()));
    }

    protected function makeMessageReceivedMessage(ConnectedClientInterface $from, $message, $timestamp)
    {
        return $message;
    }

    protected function logMessageReceived(ConnectedClientInterface $from, $roomId, $message, $timestamp)
    {
        $model = new Messages;
        $user = User::find()->where(['username' => $from->getName()])->one();
        $model->user_id = $user->id;
        $model->room_id = $roomId;
        $model->message = $message;
        $model->save();
    }

    protected function createClient(ConnectionInterface $conn, $name)
    {
        $client = new ConnectedClient;
        $client->setResourceId($conn->resourceId);
        $client->setConnection($conn);
        $client->setName($name);

        return $client;
    }

}