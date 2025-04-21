<?php

use App\Events\MessageSent;
use Livewire\Attributes\On;
use Livewire\Volt\Component;

new class extends Component {

    public array $messages = [];
    public string $message = '';


    public function addMessage()
    {
        MessageSent::dispatch(auth()->user()->name, $this->message);
        $this->reset('message');
    }

    #[On('echo:private-messages,MessageSent')] // Escucha el evento MessageSent en el canal privado

    public function onMessageSent($event)
    {
       //dd($event);
       $this->messages[] = $event;
    }
}
?>

<div x-data="{ open: true }">
    <!-- Contenedor principal del chat -->
    <div :class="{'-translate-y-0': open, 'translate-y-full': !open}"
         class="fixed transition-all duration-300 transform bottom-10 right-12 h-60 w-80">
        <div class="mb-2">
            <!-- Botón para abrir/cerrar el chat -->
            <button @click="open = !open" type="button" :class="{ 'text-gray-600 hover:bg-transparent': open }"
                    class="w-full text-start flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-white rounded-lg hover:bg-gray-400 bg-gray-600">
                Chat
            <x-heroicon-o-chevron-up x-show="!open" x-cloak class="ms-auto block size-4"/>
                <x-heroicon-o-chevron-down x-show="open" x-cloak class="ms-auto block size-4"/>
            </button>
        </div>
        <div class="w-full h-full bg-white border border-gray-300 rounded overflow-auto flex flex-col px-2 py-4">
            <div x-ref="chatBox" class="flex-1 p-4 text-sm flex flex-col gap-y-1">
                <!-- Mostrar mensajes del chat -->
                @foreach($messages as $message)
                    <div><span class="text-gray-600">{{ $message['name'] }}:</span> <span
                            class="text-black">{{ $message['message'] }}</span></div>
                @endforeach
            </div>
            <div>
                <!-- Formulario para enviar un mensaje -->
                <form wire:submit.prevent="addMessage" class="flex gap-2">
                    <x-text-input wire:model="message" x-ref="messageInput" name="message" id="message"
                                  class="block w-full"/>
                    <x-primary-button>
                        Enviar
                    </x-primary-button>
                </form>
            </div>
        </div>
    </div>
</div>
