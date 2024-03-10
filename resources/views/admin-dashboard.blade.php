<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            
            Hellosdsdfsjsl
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" >
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg d-flex justify-content-between p-5 my-5">
                {{-- <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div> --}}

                <div class="card  text-center" style="width: 18rem; height:10rem ">
                   

                  <div class="card text-center" style="width: 18rem;">
                    <div class="card-body">
                      <h5 class="card-title">  Lawyer requests</h5>
                      <h6 class="card-subtitle mb-2 text-body-secondary">{{$lawyerRequestCount}}</h6>
                      <a href="/lawyer-request" class="card-link">View</a>
                    </div>
                  </div>
                 

            </div>

            
        </div>
    </div>
</x-app-layout>
