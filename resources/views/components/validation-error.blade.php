@props(['name'])

<span {{ $attributes->merge(['class' => 'text-sm text-red-600 dark:text-red-400 error_' . $name]) }}>
    {{ $slot }}
</span>
