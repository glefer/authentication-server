@props(['value', 'for'])

<label {{ $attributes->class(['block font-medium text-sm text-gray-700', 'text-red-900'=> $errors->has($for)]) }}>
  {{ $value ?? $slot }}
</label>
