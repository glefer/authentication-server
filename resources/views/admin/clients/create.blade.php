<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('admin.global.creation_title',['type'=> 'Client' ])}}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">


                    <form method="POST" action="{{route('admin.realms.clients.store', ['realm'=> $realm])}}">
                        @csrf
                        <x-label for="name" value="{{__('admin.clients.name')}}"/>
                        <x-input value="{{old('name')}}" name="name"/>

                        <div class="mt-6 text-right">
                            <button
                                class="bg-sky-600 hover:bg-sky-700 px-5 py-2.5 text-sm leading-5 rounded-md font-semibold text-white ">
                                Save changes
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
