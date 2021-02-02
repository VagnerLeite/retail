<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Libraries\RabbitMq;

class RabbitMqSend extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rabbitmq:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a message to queue';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        system('clear');
        $strMessage = array(
            'carId' => 159
            , 'marca' => 'jeep'
            , 'modelo' => 'renegade'
            , 'versao' => '1.8 Limited Auto'
            , 'fotos_processadas' => true
            , 'array_fotos' => array(
                'foto_1' => 'endereco_foto1.jgp'
                , 'foto_2' => 'endereco_foto2.jgp'
                , 'foto_3' => 'endereco_foto3.jgp'
                , 'foto_4' => 'endereco_foto4.jgp'
                , 'foto_5' => 'endereco_foto5.jgp'
            )
        );
        $strFinalMsg = base64_encode(json_encode($strMessage));

        $strFinalMsg = "Hello..World";

        $fila = 'hello';

        $sendMessage = new RabbitMq($fila);
        return $sendMessage->sendMessage($strFinalMsg);
    }
}
