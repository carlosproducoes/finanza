<div {{ $attributes->merge(['class' => 'px-3 py-2 rounded']) }}>
    <div>{{ $title }}</div>

    <div class="text-3xl font-bold">R${{ number_format($value, 2, ',', '.') }}</div>
</div>