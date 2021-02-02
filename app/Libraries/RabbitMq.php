<?php

namespace App\Libraries;

require_once './vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use App\Libraries\VerificacaoDeRequisitos;

class RabbitMq
{
    private $nomeDaFila;
    private $channel;
    private $connection;
    private $msg;
    private $callback;

    public function __construct($fila)
    {
        $this->nomeDaFila = $fila;
        //Inicia a conexão
        $this->connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
        $this->channel = $this->connection->channel();

        //Declara qual a fila que será usada
        $this->channel->queue_declare($this->nomeDaFila, false, false, false, false);
    }

    public function sendMessage($strMessage)
    {
        // Cria a nova mensagem
        $this->msg = new AMQPMessage($strMessage);

        //Envia para a fila
        $this->channel->basic_publish($this->msg, '', $this->nomeDaFila);

        //echo " [x] Sent $strMessage \n";
        echo ' [x] Sent ', $strMessage, "\n";

        //Encerra conexão
        $this->channel->close();
        $this->connection->close();
    }

    public function receiveMessage()
    {
        echo ' [*] Waiting for messages. To exit press CTRL+C', "\n";

        //Função que vai receber e tratar efetivamente a mensagem
        $this->callback = function ($msg) {
            // Faço as verificações de requisito
            /*$verificaRequisitos = new VerificacaoDeRequisitos($msg->body);

            if (!$verificaRequisitos->executaVerificacao()) {
                // devolvo pra fila
                echo " [x] Devolver para a fila: ", base64_decode($msg->body), "\n";
            } else {
                echo " [x] Recebida e Processada: ", base64_decode($msg->body), "\n";
            }*/
            echo ' [x] Received ', $msg->body, "\n";
            sleep(substr_count($msg->body, '.'));
            echo " [x] Done\n";
        };

        // Adiciona esse "callback" para a fila
        $this->channel->basic_consume($this->nomeDaFila, '', false, true, false, false, $this->callback);

        //  Mantem a função escutando a fila por tempo indeterminado, até que seja encerrada
        while (count($this->channel->callbacks)) {
            $this->channel->wait();
        }

        $this->channel->close();
        $this->connection->close();
    }
}
