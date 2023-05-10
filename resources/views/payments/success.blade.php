<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pago Exitoso') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center justify-center">
                        <img width="200"
                             src="https://static.vecteezy.com/system/resources/previews/017/177/933/original/round-check-mark-symbol-with-transparent-background-free-png.png"
                             alt="Pago Exitoso">
                    </div>

                    <div class="flex items-center justify-center">
                        <h1>Pago Exitoso !</h1>
                    </div>

                    <div class="flex items-center justify-center">
                        <h4>Su pago fue procesado Exitosamente con {{ $processor }}</h4>
                    </div>

                    <div class="my-4 flex items-center justify-center">
                        <x-button-component :label="'Posts'" route="{{ route('posts.index') }}"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
