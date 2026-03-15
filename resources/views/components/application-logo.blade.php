<div class="flex flex-col items-center">
    <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name') }}" onerror="this.style.display='none'; this.nextElementSibling.style.display='block'" {{ $attributes }}>
    <span class="hidden font-bold text-blue-600 text-xl">{{ config('app.name') }}</span>
</div>
