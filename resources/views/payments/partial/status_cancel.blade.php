<div class="flex items-center justify-center">
    <img width="200"
         src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/53/OOjs_UI_icon_cancel-destructive.svg/1200px-OOjs_UI_icon_cancel-destructive.svg.png"
         alt="Pago Cancelado">
</div>

<div class="flex items-center justify-center">
    <h1>Pago Cancelado !</h1>
</div>

<div class="flex items-center justify-center">
    <h4>Su pago fue cancelado con {{ $processor }}</h4>
</div>

<div class="my-4 flex items-center justify-center">
    <x-button-component :label="'Posts'" route="{{ route('posts.index') }}"/>
</div>
