<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('admin.clients.clients') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('clientSecret'))
                <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md mb-4" role="alert">
                    <div class="flex">
                        <div class="py-1"><svg class="fill-current h-6 w-6 text-teal-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
                        <div>
                            <p class="font-bold">Nouveau client créé</p>
                            <p class="text-sm"><span class="font-bold">Secret :</span> {{session('clientSecret')}}</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <div class="flex flex-col">
                        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                                <div class="overflow-hidden">
                                    <table class="admin-table">
                                        <thead>
                                        <tr>
                                            <th scope="col">{{__('admin.clients.name')}}</th>
                                            <th scope="col">{{__('admin.clients.created_at')}}</th>
                                            <th scope="col">{{__('admin.global.actions')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($clients as $client)
                                            <tr>
                                                <td data-label="{{__('admin.clients.name')}}">
                                                    <a href="{{route('admin.realms.clients.show',['realm'=> $realm->id, 'client'=>$client->id])}}">
                                                        {{$client->name}}
                                                    </a>
                                                </td>
                                                <td data-label="{{__('admin.clients.created_at')}}">{{$client->created_at->format('d/m/Y')}}</td>
                                                <td data-label="{{__('admin.global.actions')}}">
                                                    <a href="{{route('admin.realms.clients.edit',['realm'=> $realm->id, 'client'=>$client->id])}}">{{ __('admin.global.edit') }}</a>

                                                    <form class="delete-form" method="POST" style="display: inline"
                                                          action="{{route('admin.realms.clients.destroy',['realm'=> $realm->id, 'client' => $client])}}">
                                                        @csrf
                                                        @method("DELETE")
                                                        <button type="submit">{{__('admin.global.delete')}}</button>
                                                    </form>

                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        {{ $clients->links()  }}

                    </div>
                </div>
            </div>
        </div>
</x-app-layout>
