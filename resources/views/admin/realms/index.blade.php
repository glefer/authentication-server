<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('admin.realms.realms') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <div class="flex flex-col">
                        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                                <div class="overflow-hidden">
                                    <table class="admin-table">
                                        <thead>
                                        <tr>
                                            <th scope="col">{{__('admin.realms.name')}}</th>
                                            <th scope="col">{{__('admin.realms.created_at')}}</th>
                                            <th scope="col">{{__('admin.global.actions')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($realms as $realm)
                                            <tr>
                                                <td data-label="{{__('admin.realms.name')}}">
                                                    <a href="{{route('admin.realms.show',['realm'=>$realm->id])}}">
                                                        {{$realm->name}}
                                                    </a>
                                                </td>
                                                <td data-label="{{__('admin.realms.created_at')}}">{{$realm->created_at->format('d/m/Y')}}</td>
                                                <td data-label="{{__('admin.global.actions')}}">
                                                    <a href="{{route('admin.realms.edit',['realm'=>$realm->id])}}">{{ __('admin.global.edit') }}</a>

                                                    <form class="delete-form" method="POST" style="display: inline"
                                                          action="{{route('admin.realms.destroy',['realm' => $realm])}}">
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

                        {{ $realms->links()  }}

                    </div>
                </div>
            </div>
        </div>
</x-app-layout>
