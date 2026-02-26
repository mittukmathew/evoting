<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidate;
use App\Models\Vote;
use App\Models\User;

class VoteController extends Controller
{
    public function index()
    {
     $user = auth()->user();
    $totalVoters =User::where('role', 'voter')->count();
    $totalVotes = Vote::count();// total registered voters
    $voted = User::where('role', 'voter')->where('has_voted',1)->count();
    $notVoted = $totalVoters - $voted;
    $candidates = Candidate::all();
    $labels = $candidates->pluck('name');  // Candidate names
       $candidates = $candidates->map(function ($candidate) {
            $candidate->votes_count = Vote::where('candidate_id', $candidate->id)->count();
            return $candidate;
        });
        // Total votes overall
        $totalVotes = $candidates->sum('votes_count');
        $votes = $candidates->pluck('votes_count');
    if ((int) $user->has_voted === 0 &&  $user->role=='admin') {
         $role ='admin';
         $hasVoted=0;
         return view('dashboard', compact('totalVoters', 'totalVotes', 'role','voted','notVoted','labels','votes'));
    } 
    if ((int) $user->has_voted === 1 &&  $user->role=='voter') {
       return redirect('/dashboard')->with('hasVoted', 1)->with('role','voter')->with('totalVoters', $totalVoters)
        ->with('totalVotes', $totalVotes);
    }     
     else {
        $candidates = Candidate::all();
        return view('vote.index', compact('candidates'));
    }
    }
    public function store(Request $request)
    {
         $user = auth()->user();
         $has_voted = $user->has_voted;
        $request->validate([
            'candidate_id' => 'required|exists:candidates,id'
        ]);

        if (auth()->user()->vote) {
           return redirect('/dashboard')->with('hasVoted', 1);
        }

        Vote::create([
            'user_id' => auth()->id(),
            'candidate_id' => $request->candidate_id
        ]);
        $user->has_voted = 1;
        $user->save();
        return redirect('/dashboard');
    }
}
