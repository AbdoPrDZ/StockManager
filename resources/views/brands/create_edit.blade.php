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
            <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="isset($brand) ? $brand->name : old('name')" required autofocus/>
          </div>

          <div class="mt-4">
            <x-label for="description" value="{{ __('Brand description') }}" />
            <x-input id="description" class="block mt-1 w-full" type="textarea" name="description" :value="isset($brand) ? $brand->description : old('description')" required autofocus/>
          </div>

          <div class="flex items-center justify-end mt-4">
            <x-button class="ms-4">
              {{ __(isset($brand) ? 'Update' : 'Create') }}
            </x-button>
          </div>

        </form>
      </div>
    </div>
  </div>
</x-app-layout>
