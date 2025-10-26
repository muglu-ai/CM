<label for="{{ $attributes->get('for') }}" {{ $attributes->except('for')->merge(['class' => 'block text-sm text-gray-700 dark:text-gray-300']) }}>
    {{ $value ?? $slot }}
</label>
