<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-teal-700 dark:bg-teal-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-teal-800 uppercase tracking-widest hover:bg-teal-600 dark:hover:bg-teal-100 focus:bg-teal-600 dark:focus:bg-teal-100 active:bg-teal-800 dark:active:bg-teal-300 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 dark:focus:ring-offset-teal-800 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
