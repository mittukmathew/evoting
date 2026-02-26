@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-10">
    <h2 class="text-2xl font-bold mb-6">Cast Your Vote</h2>

    @if(session('error'))
        <div class="text-red-600">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('vote.store') }}">
        @csrf

        @foreach($candidates as $candidate)
            <div class="border p-4 mb-3 rounded">
                <label>
                    <input type="radio" name="candidate_id" value="{{ $candidate->id }}">
                    <strong>{{ $candidate->name }}</strong>
                    <span class="text-gray-600">({{ $candidate->party }})</span>
                </label>
            </div>
        @endforeach

        <button class="bg-blue-600 text-white px-6 py-2 rounded">
            Submit Vote
        </button>
    </form>
</div>
@endsection