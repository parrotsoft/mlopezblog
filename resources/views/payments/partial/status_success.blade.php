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
