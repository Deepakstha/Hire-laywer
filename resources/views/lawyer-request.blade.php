<x-app-layout>
    <x-slot name="header">
        {{-- <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            
            Hellosdsdfsjsl
        </h2> --}}
    </x-slot>

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" >
            <table class="table">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">Lawyer Name</th>
                    <th scope="col">Lawyer Email</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($lawyerRequest as $item)
                  <tr>
                    <td>{{$item->name}} </td> 
                    <td>{{$item->email}}</td>
                    <td> <a href="/accept-lawyer-request/{{$item->id}}" class="btn btn-primary">Accept</a> <a href="/delete-lawyer-request/{{$item->id}}" class="btn btn-danger">Delete</a> </td>
                  </tr>
                  @empty
                  <tr>
                    <td colspan="3" class="text-center">No Lawyer requests found.</td>
                  </tr>
                  @endforelse
                 
                </tbody>
              </table>
        </div>
    </div>
</x-app-layout>
