<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RC6Controller extends Controller
{
    const WORD_SIZE = 32;
    const ROUNDS = 20; // Número de rondas
    const P32 = 0xb7e15163; // Constante de inicialización
    const Q32 = 0x9e3779b9; // Constante de incremento

    public function index()
    {
        return view('cifrado.rc6'); // Retorna la vista de RC6
    }

    public function cifrar(Request $request)
    {
        $mensaje = $request->input('mensaje'); // Obtener el mensaje del formulario
        $clave = $request->input('clave'); // Obtener la clave del formulario

        // Calcular el resultado del cifrado utilizando RC6
        $resultado = $this->rc6Encrypt($mensaje, $clave);

        return view('cifrado.rc6', ['resultado' => $resultado]); // Retornar la vista con el resultado
    }

    public function descifrar(Request $request)
    {
        $mensaje = $request->input('mensaje'); // Obtener el mensaje del formulario
        $clave = $request->input('clave'); // Obtener la clave del formulario

        // Calcular el resultado del descifrado utilizando RC6
        $resultado = $this->rc6Decrypt($mensaje, $clave);

        return view('cifrado.rc6', ['resultado' => $resultado]); // Retornar la vista con el resultado
    }

    private function rc6Encrypt($mensaje, $clave)
    {
        $key = $this->expandKey($clave);
        $plaintext = $this->stringToWords($mensaje);

        // Comprobación de longitud del plaintext
        if (count($plaintext) < 4) {
            // Llenar el plaintext si es necesario
            $plaintext = array_pad($plaintext, 4, 0); // Rellenar con ceros
        }

        // Inicialización
        $A = $plaintext[0];
        $B = $plaintext[1];
        $C = $plaintext[2];
        $D = $plaintext[3];

        // Cifrado
        $B += $key[0]; // Añadir clave
        $D += $key[1]; // Añadir clave

        for ($i = 0; $i < self::ROUNDS; $i++) {
            $t = $this->rotateLeft($B * (2 * $B + 1), 5);
            $A = $this->rotateLeft($A ^ $t, 5) + $B; // Mezcla
            $A = ($A + $key[2 * $i + 2]) & 0xFFFFFFFF; // Añadir clave

            $u = $this->rotateLeft($D * (2 * $D + 1), 5);
            $C = $this->rotateLeft($C ^ $u, 5) + $D; // Mezcla
            $C = ($C + $key[2 * $i + 3]) & 0xFFFFFFFF; // Añadir clave

            // Rotar
            list($A, $B, $C, $D) = [$B, $C, $D, $A];
        }

        // Convertir a hexadecimal para evitar problemas de visualización
        return bin2hex(implode('', array_map('chr', [$A, $B, $C, $D])));
    }

    private function rc6Decrypt($mensaje, $clave)
    {
       // Convertir el mensaje desde hexadecimal antes de descifrar
    $decodedMessage = hex2bin($mensaje); // Usar hex2bin en lugar de base64_decode
    $key = $this->expandKey($clave);
    $ciphertext = $this->stringToWords($decodedMessage);

    // Comprobación de longitud del ciphertext
    if (count($ciphertext) < 4) {
        // Llenar el ciphertext si es necesario
        $ciphertext = array_pad($ciphertext, 4, 0); // Rellenar con ceros
    }

    // Inicialización
    $A = $ciphertext[0];
    $B = $ciphertext[1];
    $C = $ciphertext[2];
    $D = $ciphertext[3];

    for ($i = self::ROUNDS - 1; $i >= 0; $i--) {
        // Rotar
        list($A, $B, $C, $D) = [$D, $A, $B, $C];

        $C = $this->rotateRight($C - $key[2 * $i + 3], 5) ^ $this->rotateLeft($D * (2 * $D + 1), 5);
        $D = ($D - $key[2 * $i + 2]) & 0xFFFFFFFF; // Restar clave

        $A = $this->rotateRight($A - $key[2 * $i], 5) ^ $this->rotateLeft($B * (2 * $B + 1), 5);
        $B = ($B - $key[2 * $i + 1]) & 0xFFFFFFFF; // Restar clave
    }

    // Retornar resultado como un string
    return implode('', array_map('chr', [$A, $B, $C, $D]));
}

    private function expandKey($clave)
    {
        $key = []; // Inicializar la clave expandida
        $key[0] = self::P32;

        // Rellenar las claves
        for ($i = 1; $i < 44; $i++) { // Cambia esto para que recorra hasta 44 claves
            $key[$i] = ($key[$i - 1] + self::Q32) & 0xFFFFFFFF; // Rellenar la clave
        }

        $L = $this->stringToWords($clave); // Convertir la clave a palabras
        $v = 3 * max(count($L), count($key));
        $A = 0;
        $B = 0;

        for ($j = 0; $j < $v; $j++) {
            $A = $key[$j % count($key)] = $this->rotateLeft(($A + $B) & 0xFFFFFFFF, 3);
            $B = ($L[$j % count($L)] ?? 0) + $A + $B; // Asegúrate que $L se haya inicializado correctamente
        }

        return $key; // Retornar la clave expandida
    }

    private function stringToWords($string)
    {
        $words = [];
        for ($i = 0; $i < strlen($string); $i += 4) {
            $words[] = ord($string[$i]) | (ord($string[$i + 1] ?? 0) << 8) | (ord($string[$i + 2] ?? 0) << 16) | (ord($string[$i + 3] ?? 0) << 24);
        }
        return $words;
    }

    private function rotateLeft($value, $shift)
    {
        return (($value << $shift) | ($value >> (32 - $shift))) & 0xFFFFFFFF; // Rotar a la izquierda
    }

    private function rotateRight($value, $shift)
    {
        return (($value >> $shift) | ($value << (self::WORD_SIZE - $shift))) & 0xFFFFFFFF; // Rotar a la derecha
    }
}
