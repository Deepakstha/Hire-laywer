<x-app-layout>
    <x-slot name="header">
        <div class=" d-flex  justify-content-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Profile') }}
            </h2>
            <a href="{{route('profile.edit')}}" class="font-semibold text-xl text-gray-800 leading-tight" style="cursor: pointer">
                {{ __('Edit Profile') }}
            </a>
        </div>
    </x-slot>
    <div>
           {{old('name', $user->name)}}
        </div>


        <div class="container">
    <div class="row">
        <!-- Profile Picture Column -->
        <div class="col-md-4">
            <img src="{{ asset('storage/images/' . $user->image) }}" class="img-thumbnail" alt="Profile Picture">
        </div>

        <!-- Profile Information Column -->
        <div class="col-md-8">
            <h1>{{ $user->name}}</h1>
            <p>{{ $user->role}}</p> {{ $user->is_verified ? 'verified' : 'not verified' }}
            <hr>
            
            <!-- Contact Information -->
            <p><strong>Email:</strong> {{$user->email}}</p>


            <!-- Social Links -->
            <h3>Connect</h3>
            <a href="#" class="btn btn-primary">Facebook</a>
            <a href="#" class="btn btn-info">Twitter</a>
            <a href="#" class="btn btn-danger">Instagram</a>

            <!-- Bio -->
            <h3>Bio</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero.</p>
        </div>
    </div>
</div>

</x-app-layout>
