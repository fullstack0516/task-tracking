<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center justify-center px-6 py-3 bg-rose-600 border border-transparent rounded-lg font-semibold text-xs text-white tracking-wide hover:bg-rose-500 focus:outline-none focus:border-rose-700 focus:ring focus:ring-rose-200 active:bg-rose-600 disabled:opacity-25 transition']) }}>
    {{ $slot }}
</button>
