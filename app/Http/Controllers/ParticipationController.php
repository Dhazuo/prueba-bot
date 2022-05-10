<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ParticipationController extends Controller
{
    public function participation(Request $request, $params)
    {
        $participation_exists = Participant::where('participation', $params)->first();

        if (!$participation_exists) {
            return redirect()->route('index');
        }

        $participation = $participation_exists->participation;
        return Inertia::render('Participation', compact('participation'));
    }
}
