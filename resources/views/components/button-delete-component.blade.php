<div>
    <form action="{{ $url }}" method="post">
        @method('delete')
        @csrf
        <x-primary-button>Eliminar</x-primary-button>
    </form>
</div>
