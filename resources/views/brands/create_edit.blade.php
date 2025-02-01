@php
  if (isset($brand)) $brand = \App\Models\Brand::find($brand);
@endphp

<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ isset($brand) ? __('Update Brand') : __('Create Brand') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
        <form action="{{ isset($brand) ? route('brands.edit', $brand->id) : route('brands.create') }}" method="POST">
          @csrf

          <div class="mt-4">
            <x-label for="name" value="{{ __('Brand Name') }}" />
            <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', isset($brand) ? $brand->name : '')" required autofocus/>
          </div>

          <div class="mt-4">
            <x-label for="description" value="{{ __('Brand description') }}" />
            <x-input id="description" class="block mt-1 w-full" type="textarea" name="description" :value="old('description', isset($brand) ? $brand->description : '')" required autofocus/>
          </div>

          <div class="flex items-center justify-end mt-4">
            <x-button type="submit" class="ms-4">
              {{ __(isset($brand) ? 'Update' : 'Create') }}
            </x-button>
          </div>

        </form>
      </div>
    </div>
  </div>
</x-app-layout>
