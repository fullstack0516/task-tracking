<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center justify-center px-6 py-3 text-red-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-50 focus:outline-none focus:border-red-700 focus:ring focus:ring-red-200 active:bg-red-600 active:text-white disabled:opacity-25 transition']) }}>
    {{ $slot }}
</button>
