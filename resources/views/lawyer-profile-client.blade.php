@extends('layouts.clientLayout')

@section('head-section')
<title>Wakil Sathi</title>
<style>
    .profile-picture-container {
    width: 150px; 
    height: 150px; 
    overflow: hidden;
    border-radius: 50%;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); 
}

.profile-picture {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
</style>
@endsection

@section('client')
<br/>
<br/>
<br/>
<br/>
<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    Wakil Sathi
                </div>
                <div class="card-body">
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

                    {{-- <h5 class="card-title">{{$lawyers->id}}</h5> --}}
                   
                    <div class="profile-picture-container">
                        <img src="{{ asset('storage/images/' . $lawyers->image) }}" class="rounded-circle shadow-sm object-fit-cover profile-picture" alt="Lawyer Image">
                    </div>
                    <h5 class="card-title">{{$lawyers->name}}</h5>
                    <p class="card-text">{{$lawyers->bio}}</p>
                    <img src="{{ asset('storage/documents/lawyers/' . $lawyers->lawyer_card) }}" class="img-fluid" alt="Lawyer Card">
                    <form action="/hire-lawyer" method="post">
                        @csrf
                        <input type="hidden" name="lawyer_id" value="{{$lawyers->id}}">
                        <button type="submit" class="btn btn-primary">Request to Hire</button>
                    </form>
                    <a href="/book-appointment/{{$lawyers->id}}" class="btn btn-secondary">Book Appointment</a>
                    <a href="/message/{{$lawyers->id}}" class="btn btn-secondary">Message</a>
                </div>
            </div>

            <form action="/ratings" method="get">
                <div class="mb-3">
                  <label for="reviews" class="form-label">Reviews</label>
                  <input type="text" name="reviews" class="form-control" id="reviews" aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                  <label for="rating" class="form-label">Rating</label>
                  <input type="number" name="rating" class="form-control" id="rating">
                </div>
                <input type="hidden" value="{{$lawyers->id}}"  name="lawyer_id"/>
               
                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
        </div>
    </div>
</div>
@endsection
