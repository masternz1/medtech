<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn bg-rose-700 text-white hover:bg-rose-800']) }}>
    {{ $slot }}
</button>
