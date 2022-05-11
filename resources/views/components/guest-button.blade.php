<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-3 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white tracking-wide hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring focus:ring-indigo-300 disabled:opacity-25 transition']) }}>
    {{ $slot }}
</button>
