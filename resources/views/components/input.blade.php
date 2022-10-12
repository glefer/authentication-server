@props(['disabled' => false, 'type'=> 'text', 'name'])
<div class="mb-6">
    <input name="{{$name}}" type="{{$type}}"   {{ $disabled ? 'disabled' : '' }} {{ $attributes->class(['mt-0 block w-full px-0.5 border-0 border-b-2 border-gray-200 focus:ring-0 focus:border-sky-600', 'border-red-500 text-red-900' => $errors->has($name)]) }}>

    @error($name)
    <div class="text-red-800 alert alert-danger">{{ $message }}</div>
    @enderror
</div>
