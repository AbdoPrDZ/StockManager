@props(['disabled' => false])

@php
  $isTextarea = $attributes->get('type') === 'textarea';
  $isSelect = $attributes->get('type') === 'select';
  $attributes->merge(['class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm'])
@endphp

@if ($isTextarea)
  <textarea {{ $disabled ? 'disabled' : '' }} {!! $attributes !!}>
{{ $attributes->get('value') }}
  </textarea>
@elseif ($isSelect)
  <select {{ $disabled ? 'disabled' : '' }} {!! $attributes !!}>
    {{ $slot }}
  </select>
@else
  <input {{ $disabled ? 'disabled' : '' }} {!! $attributes !!}>
@endif
