<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use Illuminate\Http\Request;
use App\Custom\Bot as BotLogic;

class BotController extends Controller
{
    public string $error;

    public function interact(Request $request)
    {
        $participation = $request->get('participation');

        $bot = Participant::where('participation', $participation)->first()->bot;

        if ($bot->stage == 'salute_stage') {
            return response()->json([
                'response' => 'Bienvenido al bot Botsin, dinos un Hola .'
            ]);
        }
        else if ($bot->stage == 'question_stage') {
            return response()->json([
                'response' => 'Bienvenido al bot Botsin, te recordamos que ahora debes escoger una de las siguientes opciones.' . "\n" .
                    "1️⃣: Ayuda" . "\n" .
                    "2️⃣: Solicitar mi participación" . "\n" .
                    "3️⃣: Terminar chat"
            ]);
        }
        else if ($bot->stage == "conversation_stage") {
            return response()->json([
                'response' => 'Parece que ya has solicitado lo que querías' . "\n" . "¿Necesitas algo más? (Responde con un Sí o un No)"
            ]);
        }
    }

    public function conversation(Request $request)
    {

        $answer = $request->get('answer');
        $participation = $request->get('participation');

        $bot = Participant::where('participation', $participation)->first()->bot;

        $current_stage = $bot->stage;

        if ($current_stage == 'salute_stage') {
            $this->assignError($current_stage, $bot);

            $bot_logic = new BotLogic;
            $bot_response = $bot_logic->receivedMessage($answer, $current_stage, $this->error);
            if ($bot_response != $this->error) {
                $this->updateStage($bot, $current_stage);
            }
            return response()->json([
                'bot_response' => $bot_response
            ]);

        } else if ($current_stage == 'question_stage') {
            $this->assignError($current_stage, $bot);

            $bot_logic = new BotLogic;
            $bot_response = $bot_logic->receivedMessage($answer, $current_stage, $this->error);

            if ($bot_response == "1") {
                $bot_response = "Realmente no te puedo ayudar en nada porque soy un bot de prueba XD \n" . "¿Necesitas algo más? (Responde con un Sí o un No)";
                $this->updateStage($bot, $current_stage);
                return response()->json([
                    'bot_response' => $bot_response
                ]);
            }
            else if ($bot_response == "2") {
                $bot_response = "Tu participación es: \n" . "\n" . "$participation" . "\n" . "\n" . "¿Necesitas algo más? (Responde con un Sí o un No)";
                $this->updateStage($bot, $current_stage);
                return response()->json([
                    'bot_response' => $bot_response
                ]);
            }
            else if ($bot_response == "3") {
                $bot_response = "De acuerdo, recuerda que puedes volver a iniciar esta conversación con un Hola";

                $bot->update([
                    'stage' => 'salute_stage'
                ]);

                return response()->json([
                    'bot_response' => $bot_response
                ]);
            }
        }
        else if ($current_stage == 'conversation_stage') {
            $this->assignError($current_stage, $bot);

            $bot_logic = new BotLogic;
            $bot_response = $bot_logic->receivedMessage($answer, $current_stage, $this->error);

            if ($bot_response == "yes") {
                $answer = 'Hola';
                $current_stage = 'salute_stage';
                $bot_response = $bot_logic->receivedMessage($answer, $current_stage, $this->error);
                $this->updateStage($bot, $current_stage);
                return response()->json([
                    'bot_response' => $bot_response
                ]);
            }
            else if ($bot_response == "no") {
                $bot_response = "De acuerdo, recuerda que puedes volver a iniciar esta conversación con un Hola";

                $bot->update([
                    'stage' => 'salute_stage'
                ]);

                return response()->json([
                    'bot_response' => $bot_response
                ]);
            }
        }
    }

    public function assignError($current_stage, $bot)
    {
        if ($current_stage == 'salute_stage') {
            $this->error = $bot::ERRORS['salute_stage_error'];
        }
        else if ($current_stage == 'question_stage') {
            $this->error = $bot::ERRORS['question_stage_error'];
        }
        else if($current_stage == 'conversation_stage') {
            $this->error = $bot::ERRORS['conversation_stage_error'];
        }
    }

    public function updateStage($bot, $current_stage)
    {
        if ($current_stage == 'salute_stage') {
            $bot->update([
                'stage' => 'question_stage'
            ]);
        }
        else if($current_stage == 'question_stage') {
            $bot->update([
                'stage' => 'conversation_stage'
            ]);
        }
        else if ($current_stage == 'conversation_stage') {
            $bot->update([
                'stage' => 'ended'
            ]);
        }
    }
}
