@extends('layouts.app')

@section('content')

<div class="container">

    <h3>Dashboard</h3>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <a href="{{ route('vote') }}" class="btn btn-primary">
        Go to Voting Page
    </a>

</div>

@endsection