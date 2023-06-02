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
                    @if($status == 'PENDING')
                        @include('payments.partial.status_pending')
                    @endif

                    @if($status == 'COMPLETED')
                        @include('payments.partial.status_success')
                    @endif

                    @if($status == 'CANCELED')
                        @include('payments.partial.status_cancel')
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
