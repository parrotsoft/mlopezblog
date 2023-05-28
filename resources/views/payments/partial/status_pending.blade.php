<div class="flex items-center justify-center">
    <img width="200"
         src="https://cdn-icons-png.flaticon.com/512/3756/3756719.png"
         alt="Pago Pendiente">
</div>

<div class="flex items-center justify-center">
    <h1>Pago está Pendiente !</h1>
</div>

<div class="flex items-center justify-center">
    <h4>Su pago está pendiente con {{ $processor }}</h4>
</div>

<div class="my-4 flex items-center justify-center">
    <x-button-component :label="'Posts'" route="{{ route('posts.index') }}"/>
</div>
