@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Election Results</h2>

    <table class="table table-bordered mt-3">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Candidate Name</th>
                <th>Party</th>
                <th>Total Votes</th>
                <th>Percentage</th>
            </tr>
        </thead>
        <tbody>
            @foreach($candidates as $index => $candidate)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $candidate->name }}</td>
                     <td>{{ $candidate->party }}</td>
                    <td>{{ $candidate->votes_count }}</td>
                    <td>
                      {{ $totalVotes > 0 ? round(($candidate->votes_count / $totalVotes) * 100, 2) : 0 }}%
                    </td>
                </tr>
            @endforeach
            <tr class="table-info">
                <td colspan="5"><strong>Total Votes : {{ $totalVotes }}</strong></td>
             
            </tr>
        </tbody>
    </table>
</div>
@endsection