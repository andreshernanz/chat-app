<?php

namespace App\Console\Commands;

use App\Events\MessageSent;
use Illuminate\Console\Command;
use function Laravel\Prompts\text; //Importar la función text de Laravel Prompts


class SendMessageCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:message'; //Enviar un mensaje

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a message to the chat or channel.'; //Enviar un mensaje a el chat o canal.

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $name = text(
            //Ingrese su nombre
            label: 'Enter your name:',
            required: true,
        );

        $message = text(
            //Ingrese su mensaje
            label: 'Enter your message:',
            required: true,
        );

        MessageSent::dispatch($name, $message);
    }
}
