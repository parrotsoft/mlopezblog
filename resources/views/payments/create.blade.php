<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nueva Pago') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('payments.processPayment') }}" method="post">
                        @csrf
                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                        <div class="p-2">
                            <label for="" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Articulo</label>
                            <input type="text" name="" value="{{ $post->title }}" readonly
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-80 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        </div>

                        <div class="p-2">
                            <label for=""
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Valor</label>
                            <input type="text" name="" value="10 USD" readonly
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-80 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        </div>

                        <div class="p-2">
                            <label for="" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Medio
                                de Pago</label>
                            <select name="payment_type"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-80 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                @foreach($paymentProcessors as $processor)
                                    <option value="{{ $processor }}">{{ $processor }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="p-2">
                            <x-primary-button>Pagar</x-primary-button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
