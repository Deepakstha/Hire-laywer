<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            
            Hellosdsdfsjsl
        </h2>
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
                    @if (Auth::user()->role == 'client')
                    <th scope="col">Lawyer Name</th>
                    <th scope="col">Lawyer Email</th>
                    @endif
                    @if (Auth::user()->role == 'lawyer')
                    <th scope="col">Client Name</th>
                    <th scope="col">Client Email</th>
                    @endif
                    
                    <th scope="col">Booking Start Date</th>
                    <th scope="col">Booking End Date</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($appointments as $item)
                  <tr>
                    <td>{{$item->name}} </td> 
                    <td>{{$item->email}}</td>
                    <td>{{$item->booking_start_date}}</td>
                    <td>{{$item->booking_end_date}}</td>
                    <td> <a href="/delete-appointment/{{$item->id}}" class="btn btn-danger">Delete</a> </td>
                  </tr>
                  @empty
                  <tr>
                    <td colspan="3" class="text-center">No Clients found.</td>
                  </tr>
                  @endforelse
                 
                </tbody>
              </table>
        </div>
    </div>
</x-app-layout>
