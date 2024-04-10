@extends('layouts.clientLayout')

@section('head-section')
<title>Wakil Sathi</title>
<style>
    .message {
        margin-bottom: 10px;
    }

    .message p {
        margin: 0;
        padding: 10px;
        border-radius: 20px;
        max-width: 70%;
        word-wrap: break-word;
    }

    .message p.you {
        background-color: rgb(7, 132, 200);
        color: white;
        float: right;
        clear: both;
    }

    .message p.receiver {
        background-color: rgb(7, 200, 81);
        color: white;
        float: left;
        clear: both;
    }

    .message-input {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px;
        background-color: #f8f9fa;
        border-top: 1px solid #dee2e6;
    }

    .message-input input {
        flex-grow: 1;
        border: none;
        border-radius: 20px;
        padding: 10px;
        margin-right: 10px;
    }

    .message-input button {
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 20px;
        padding: 10px 20px;
        cursor: pointer;
    }
</style>
@endsection

@section('client')
<br/>
<br/>
<br/>
<br/>
<div class="container mt-5">
    <div class="">
        <div class="card" >
            <div class="card-header">
                Message to {{$receiver->name}}
            </div>
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

            <div style="padding: 15px;">
                @foreach ($message as $msg)
                    <div class="message">
                        @if($msg->sender == Auth::user()->id)
                            <p class="you">{{ $msg->message }}</p>
                        @else
                            <p class="receiver">{{ $msg->message }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
            <form class="message-input" action="/send-message" method="get">
                <input type="text" name="message" placeholder="Type your message..."/>
                <input type="hidden" name="receiver" value="{{$receiver->id}}"/>
                <button type="submit">Send</button>
            </form>
        </div>
    </div>
</div>
@endsection
