<x-app-layout>
    <x-slot name="header">
        
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" >
           
                
            @foreach($users as $user)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg  " style="margin-bottom:50px;">
                <div class="p-6 bg-white border-b border-gray-200">
                    {{ $loop->iteration }}
                   {{$user->name}}
                   <a href="/message/{{$user->id}}" class=" btn-primary float-right" >Message</a>
                </div></div>
            @endforeach

<!-- Modal -->
        </div>
    </div>
</x-app-layout>
