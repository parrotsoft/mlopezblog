<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Posts') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="flex justify-between">
                        <x-button-component :label="'Nuevo'" route="{{ route('posts.create') }}"/>
                        <x-button-component :label="'Exportar'" route="{{ route('posts.export') }}"/>
                    </div>

                    <div class="my-4">
                        <x-table-component :headers="$headers" :collections="$posts"
                                           :fields="$fields" :model="'posts'"></x-table-component>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
