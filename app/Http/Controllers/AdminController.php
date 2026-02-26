<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidate;
use App\Models\Vote;

class AdminController extends Controller
{
    public function index() {
    return view('admin.dashboard');
    }
    public function results()
    {
        // Get all candidates with votes
        $candidates = Candidate::all();
        $candidates = $candidates->map(function ($candidate) {
            $candidate->votes_count = Vote::where('candidate_id', $candidate->id)->count();
            return $candidate;
        });
        // Total votes overall
        $totalVotes = $candidates->sum('votes_count');

        return view('admin.results', compact('candidates', 'totalVotes'));
    }
}