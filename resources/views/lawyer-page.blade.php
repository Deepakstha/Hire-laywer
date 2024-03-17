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

            
        </div>
    </div>


    <div class="row">
        @foreach ($lawyers as $lawyer)

    <div class="col-lg-4 col-md-6 d-flex align-items-stretch">
      <div class="course-item">
        <a href="/lawyer/{{$lawyer->id}}">
        <img src="{{ asset('storage/images/' . $lawyer->image) }}" class="img-fluid" alt="..."></a>
        {{-- <img src="{{ asset('storage/images/' . $lawyer->lawyerDetails->lawyer_card) }}" class="img-fluid" alt="..."> --}}
        <div class="course-content">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h4>{{ $lawyer->role }}</h4>
            <p class="price">Rs.  {{ $lawyer->price }}</p>
          </div>

          <h3><a href="course-details.html">{{ $lawyer->name }}</a></h3>
          <p> {{ $lawyer->bio }}</p>
          <div class="trainer d-flex justify-content-between align-items-center">
           
            <div class="review-stars">
              @for($i =  1; $i <=  5; $i++)
                  @if($i <= $lawyer->average_rating)
                      <i class="fa fa-star" style="color: #ffbb2c" aria-hidden="true"></i>
                  @else
                      <i class="fa fa-star-o" aria-hidden="true"></i>
                  @endif
              @endfor
          </div>
            <div class="trainer-rank d-flex align-items-center">
              <i class="bx bx-user"></i>&nbsp; total hires 50
              &nbsp;&nbsp;
              <i class="bx bx-heart"></i>&nbsp;65
            </div>
          </div>
        </div>
      </div>
    </div> 
    @endforeach
    </div>
</div>
@endsection
