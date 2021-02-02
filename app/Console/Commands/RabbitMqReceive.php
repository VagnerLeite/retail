<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Libraries\RabbitMq;

class RabbitMqReceive extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rabbitmq:receive';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Receive a message from RabbitMq queue';

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
        $fila = 'hello';

        $receiveMessage = new RabbitMq($fila);
        return $receiveMessage->receiveMessage();
    }
}
