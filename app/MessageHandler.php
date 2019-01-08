<?php


namespace App;

use App\Message\ErrorMessage;
use App\Message\Message;
use Nekland\Woketo\Core\AbstractConnection;
use Nekland\Woketo\Exception\WebsocketException;
use Nekland\Woketo\Message\TextMessageHandler;

class MessageHandler extends TextMessageHandler
{
    private $connections = [];

    /**
     * Is called when a new connection is established.
     *
     * @param AbstractConnection $connection
     */
    public function onConnection(AbstractConnection $connection)
    {
        // TODO: Implement onConnection() method.
        $this->connections[] = $connection;
        echo "connected {$connection->getIp()}\n";
    }

    /**
     * Is called on new text data.
     *
     * @param string $data Text data
     * @param AbstractConnection $connection
     * @throws \Nekland\Woketo\Exception\RuntimeException
     */
    public function onMessage(string $data, AbstractConnection $connection)
    {
        echo $data . "\n";

        // TODO: вот сюда будут сыпаться все сообщения. Нужно определиться с форматом сообщения
        // TODO:  и запилить отдельный тип Message для обмена сообщениями с клиентами
        try {
            $message = Message::fromJson($data);

            // TODO: распарсили сообщение, разобрались куда слать - отправляем в приложение.
            // TODO: Например через ZEROMQ.
            $connection->write( $message );
        } catch (\InvalidArgumentException $e) {
            echo $e->getMessage() . "\n";
            $connection->write( new ErrorMessage($e->getMessage()) );
        }
    }

    /**
     * This callback is call when there is an error on the websocket protocol communication.
     *
     * @param WebsocketException $e
     * @param AbstractConnection $connection
     */
    public function onError(WebsocketException $e, AbstractConnection $connection)
    {
        // TODO: Implement onError() method.
        echo "error!\n";
    }

    /**
     * Is called when the connection is closed by the client
     *
     * @param AbstractConnection $connection
     */
    public function onDisconnect(AbstractConnection $connection)
    {
        // TODO: Implement onDisconnect() method.
        echo "disconnected {$connection->getIp()}\n";
    }
}