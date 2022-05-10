<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bot extends Model
{
    use HasFactory;

    const ERRORS = [
        'salute_stage_error' => "Perdón, no entiendo lo que dices. Por favor, dínos un Hola.",
        'question_stage_error' => "Perdón, no entiendo lo que dices. Por favor, responde con una de las opciones correspondientes" . "\n" . "\n" . "1️⃣: Ayuda" . "\n" .
            "2️⃣: Solicitar mi participación" . "\n" .
            "3️⃣: Terminar chat",
        'conversation_stage_error' => "Perdón, no entiendo lo que dices. \n" . "Por favor, contesta con un Sí o un No"
    ];
    protected $fillable = [
        'participant_id',
        'stage'
    ];

    public function participant()
    {
        return $this->belongsTo(Participant::class);
    }
}
