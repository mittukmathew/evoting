@extends('layouts.app')

@section('content')

   <div class="row">

        {{-- ========================= --}}
        {{-- Left Column: Voter Chart --}}
        {{-- ========================= --}}
        @if(Auth::user() && Auth::user()->role == 'admin')
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    Voter Statistics
                </div>
                <div class="card-body">
                    <canvas id="voterChart" width="400" height="300"></canvas>
                </div>
            </div>
        </div>
           <div class="col-md-6">
            <div class="card mb-4">
               <h1>Election Results</h1>

            <div class="card">
                <div class="card-body">
                    <canvas id="candidatePieChart" width="400" height="400"></canvas>
                </div>
            </div>
            </div>
        </div>
   
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
var ctx = document.getElementById('voterChart').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Voted', 'Not Voted'],
        datasets: [{
            label: 'Voter Count',
            data: [{{ $voted }}, {{ $notVoted }}],
            backgroundColor: ['rgba(54, 162, 235, 0.7)','rgba(255, 99, 132, 0.7)'],
            borderColor: ['rgba(54, 162, 235, 1)','rgba(255, 99, 132, 1)'],
            borderWidth: 1
        }]
    },
    options: { scales: { y: { beginAtZero:true } } }
});
</script>
<script>
window.onload = function() {
    var ctx = document.getElementById('candidatePieChart').getContext('2d');

    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: @json($labels), // Candidate names
            datasets: [{
                data: @json($votes), // Votes per candidate
                backgroundColor: [
                    'rgba(255, 99, 132, 0.7)',
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(255, 206, 86, 0.7)',
                    'rgba(75, 192, 192, 0.7)',
                    'rgba(153, 102, 255, 0.7)',
                    'rgba(255, 159, 64, 0.7)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'right', // show labels on the right
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let total = context.dataset.data.reduce((a, b) => a + b, 0);
                            let percent = ((context.raw / total) * 100).toFixed(2);
                            return context.label + ': ' + context.raw + ' (' + percent + '%)';
                        }
                    }
                }
            }
        }
    });
};
</script>
</div>
      @endif
   
   {{-- Success or error flash messages --}}
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
 @if(Auth::user() && Auth::user()->role == 'voter')
    @if(session('hasVoted') == 1)
       <h3>Dashboard</h3>
        <div class="alert alert-info">
            You have already voted.
        </div>
    @else
        <div class="alert alert-warning mt-3">
            <a href="{{ route('vote.index') }}" class="btn btn-sm btn-success ms-2">
                Check your status
            </a>
        </div>
    @endif
@endif

{{-- Admin Dashboard Section --}}
@if(Auth::user() && Auth::user()->role == 'admin')
    <div class="card mt-4">
        <div class="card-header bg-primary text-white">
            Admin Dashboard
        </div>
        <div class="card-body">
            <p>Total Voters: {{ $totalVoters}}</p>
            <p>Total Votes: {{ $totalVotes}}</p>
            <a href="{{ route('admin.results') }}" class="btn btn-sm btn-warning">
                View Election Results
            </a>
        </div>
    </div>
@endif
</div>

@endsection