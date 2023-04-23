<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nueva Categoria') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form
                        action="{{ isset($category) ? route('categories.update', $category->id) : route('categories.store') }}"
                        method="post">
                        @csrf

                        @isset($category)
                            @method('put')
                        @endisset

                        <div class="mb-6">
                            <label for=""
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Nombre</label>
                            <input type="text" name="name"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-80 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="Nombre de la Categoría"
                                   value="{{ isset($category) ? $category->name : '' }}">
                        </div>

                        <div class="flex mb-6 w-80">
                            <div class="w-1/2">
                                <x-primary-button>
                                    {{ isset($category) ? 'Actualizar' : 'Guardar' }}
                                </x-primary-button>
                            </div>
                            <div class="w-1/2">
                                <x-button-cancel-component/>
                            </div>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
