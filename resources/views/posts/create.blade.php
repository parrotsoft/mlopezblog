<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nueva Post') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ isset($post) ? route('posts.update', $post->id) : route('posts.store') }}"
                          method="post">
                        @isset($post)
                            @method('put')
                        @endisset
                        @csrf

                        <div class="p-2">
                            <label for="" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Categoría</label>
                            <select name="category_id"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-80 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                @foreach($categories as $category)
                                    <option
                                        {{ isset($post) ? $post->category_id == $category->id ? 'selected' : '' : '' }}
                                        value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id') <span class="error text-red-500">{{ $message }}</span> @enderror
                        </div>
                        <div class="p-2">
                            <label for=""
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Titulo</label>
                            <input type="text" name="title"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-80 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   value="{{ isset($post) ? $post->title : '' }}">
                            @error('title') <span class="error text-red-500">{{ $message }}</span> @enderror
                        </div>

                        <div class="p-2">
                            <label for=""
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Cuerpo</label>
                            <textarea name="body" rows="10"
                                      class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-80 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">{{ isset($post) ? $post->body : '' }}</textarea>
                            @error('body') <span class="error text-red-500">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex mb-6 w-80">
                            <div class="w-1/2">
                                <x-primary-button>{{ isset($post) ? 'Actualizar' : 'Guardar' }}</x-primary-button>
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
