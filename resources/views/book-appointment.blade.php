@extends('layouts.clientLayout')

@section('head-section')
<title>Book Lawyer Appointment</title>

@endsection

@section('client')
<br/>
<br/>
<br/>
<br/>

<div class="container mt-5">
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
    <div class="row">
        <div class="col-md-8 offset-md-2">

            <form action="/book-appointment" method="post">
                @csrf
                <div class="mb-3">
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <div class="form-group">
                                <h3> Book Appointment for {{$lawyerName}} Lawyer</h3>

                            <label for="datetimeInput">Select Appointment Date and Time:</label>
                            <input type="datetime-local" required class="form-control" id="datetimeInput" name="datetimeInput">
                        </div>
                    </div>
                    <input type="hidden" name="lawyerId" value={{$lawyerId}} />
                    </div>
                </div>
               
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Book Date</button>

                        </div>
                    </div>
                </div>
               
              </form>
        </div>
    </div>
</div>
@endsection
