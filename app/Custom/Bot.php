<?php

namespace App\Custom;

class Bot {
    const MESSAGES_FIRST_STAGE = [
        'HOLA',
        'hola',
        'Hola',
        'ola',
        'hello',
        'holA',
    ];
    const MESSAGES_SECOND_STAGE = [
        'option_1' => [
            'uno',
            'UNO',
            '1',
            'ONE',
            'one',
        ],
        'option_2' => [
            'dos',
            'DOS',
            '2',
            'TWO',
            'two',
        ],
        'option_3' => [
            'tres',
            'TRES',
            '3',
            'THREE',
            'three'
        ]
    ];
    const MESSAGES_THIRD_STAGE = [
        'yes' => [
            'Sí',
            'sí',
            'SÍ',
            'si',
            'SI',
            'yes',
            'YES'
        ],
        'no' => [
            'no',
            'NO',
            'nO',
            'No'
        ]
    ];

    public function receivedMessage($message, $current_stage, $error): string
    {
        if ($current_stage == 'salute_stage') {
            $exists = array_search($message, self::MESSAGES_FIRST_STAGE);
            if (!is_numeric($exists)) {
                return $error;
            }
            return "Te damos la bienvenida a nuestro bot de prueba, Botsin." .
                "\n" .
                "Por favor introduce el número correspondiente a la opción que deseas" . "\n" . "\n" .
                "1️⃣: Ayuda" . "\n" .
                "2️⃣: Solicitar mi participación" . "\n" .
                "3️⃣: Terminar chat";
        }
        else if ($current_stage == 'question_stage') {
            $exists_in_1 = array_search($message, self::MESSAGES_SECOND_STAGE['option_1']);
            $exists_in_2 = array_search($message,self::MESSAGES_SECOND_STAGE['option_2']);
            $exists_in_3 = array_search($message, self::MESSAGES_SECOND_STAGE['option_3']);
            if (!is_numeric($exists_in_1) && !is_numeric($exists_in_2) && !is_numeric($exists_in_3)) {
                return $error;
            }
            if (is_numeric($exists_in_1)) {
                return "1";
            }
            else if (is_numeric($exists_in_2)) {
                return "2";
            }
            else if (is_numeric($exists_in_3)) {
                return "3";
            }
        }
        else if ($current_stage == 'conversation_stage') {
            $exists_in_yes = array_search($message, self::MESSAGES_THIRD_STAGE['yes']);
            $exists_in_no = array_search($message, self::MESSAGES_THIRD_STAGE['no']);

            if (!is_numeric($exists_in_yes) && !is_numeric($exists_in_no)) {
                return $error;
            }
            if (is_numeric($exists_in_yes)) {
                return "yes";
            }
            else if (is_numeric($exists_in_no)) {
                return "no";
            }
        }
    }
}




