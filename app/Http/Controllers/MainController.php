<?php

namespace App\Http\Controllers;

use App\Models\Bot;
use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use App\Http\Requests\RegisterRequest;

class MainController extends Controller
{

    public function index()
    {
        return Inertia::render('Index');
    }

    public function register(RegisterRequest $request)
    {
        $name = $request->get('name');
        $last_name = $request->get('last_name');
        $email = $request->get('email');
        $password = $request->get('password');
        $arr = [];
        for ($i = 0; $i < 3; $i++) {
            $rand = random_bytes(5);
            $bin = bin2hex($rand);
            $arr[$i] = $bin;
        }
        $participation = implode('-', $arr);

        $participant = Participant::create([
            'name' => $name,
            'last_name' => $last_name,
            'email' => $email,
            'password' => Hash::make($password),
            'participation' => $participation
        ]);

        Bot::create([
            'participant_id' => $participant->id
        ]);

        return response()->json([
            'participation' => $participation
        ]);
    }

    public function login(Request $request)
    {
        $email = $request->get('email');
        $password = $request->get('password');
        $comprobation = Participant::where('email', $email)
                                    ->first();
        if ($comprobation) {
            if (Hash::check($password, $comprobation->password)) {
                return response()->json([
                    'participation' => $comprobation->participation
                ]);
            }
            return response()->json([
                'error' => 'Cuenta o contraseña incorrectos.'
            ], 404);
        }
        return response()->json([
            'error' => 'Cuenta o contraseña incorrectos.'
        ], 404);



    }
}
