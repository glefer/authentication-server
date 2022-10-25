<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{$realm->name}}
            >
            {{$client->name}}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">


                    <div class="container">

                        <div class="container mb-2  pb-2">
                            <span class="font-bold text-gray-700 ">{{ __('Client ID') }} : </span> <br>
                            {{$client->clientId}}
                        </div>


                        <div class="mt-6 text-right">
                            <a href="{{route('admin.realms.clients.edit',['realm'=>$realm->id, 'client'=>$client->id])}}"
                               class="mr-0.5 bg-sky-600 hover:bg-sky-700 px-5 py-2.5 text-sm leading-5 rounded-md font-semibold text-white ">
                                {{ __('admin.global.edit') }}
                            </a>
                            <form
                                class="delete-form bg-red-600 hover:bg-red-700 px-5 py-2.5 text-sm leading-5 rounded-md font-semibold text-white"
                                method="POST" style="display: inline"
                                action="{{route('admin.realms.destroy',['realm' => $realm])}}">
                                @csrf
                                @method("DELETE")
                                <button type="submit">{{__('admin.global.delete')}}</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
</x-app-layout>
