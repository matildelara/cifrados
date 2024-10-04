<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Blake2Controller extends Controller
{
    public function index()
    {
        return view('cifrado.blake2'); // Retorna la vista de BLAKE2
    }

    public function calcularHash(Request $request)
    {
        $input = $request->input('input'); // Obtener el input del formulario

        // Calcular el hash utilizando BLAKE2
        $hash = $this->blake2Hash($input);

        // Retornar la vista con el hash calculado
        return view('cifrado.blake2', ['hash' => $hash, 'input' => $input]);
    }

    private function blake2Hash($input)
    {
        // Paso 1: Inicialización
        $hashLength = 64; // 512 bits para BLAKE2b
        $state = array_fill(0, 8, 0); // Inicializar el estado con ceros

        // Inicializar valores de estado
        $state[0] = 0x6a09e667;
        $state[1] = 0xbb67ae85;
        $state[2] = 0x3c6ef372;
        $state[3] = 0xa54ff53a;
        $state[4] = 0x510e527f;
        $state[5] = 0x9b05688c;
        $state[6] = 0x1f83d9ab;
        $state[7] = 0x5be0cd19;

        // Paso 3: División en bloques
        $blocks = str_split($input, 64); // Dividir en bloques de 64 bytes

        // Paso 4: Compresión
        foreach ($blocks as $block) {
            $this->compressBlock($block, $state);
        }

        // Paso 5: Digestión
        $finalHash = $this->digest($state, $hashLength);

        return bin2hex($finalHash); // Convertir a hexadecimal
    }

    private function compressBlock($block, &$state)
    {
        // Operaciones de mezcla: rotaciones, sumas y XOR
        $blockArray = array_fill(0, 16, 0); // Inicializar el bloque
        for ($i = 0; $i < strlen($block); $i++) {
            // Convertir cada byte del bloque a entero
            $blockArray[$i >> 2] |= ord($block[$i]) << (8 * ($i % 4)); // Llenar el bloque
        }

        // Implementar las operaciones de mezcla
        for ($i = 0; $i < 12; $i++) {
            // Ejemplo de operaciones de mezcla (simplificadas)
            $state[0] += $state[1] + $blockArray[$i % 16];
            $state[1] = $this->rotateLeft($state[1], 32) ^ $state[0];
            $state[0] = $this->rotateLeft($state[0], 16);
        }
    }

    private function rotateLeft($value, $shift)
    {
        return (($value << $shift) | ($value >> (32 - $shift))) & 0xFFFFFFFF; // Rotar a la izquierda
    }

    private function digest($state, $hashLength)
{
    // Producir el valor de hash final a partir del estado
    $hashBytes = '';
    
    foreach ($state as $value) {
        $hashBytes .= pack('L', $value); // Convertir a bytes en formato de 32 bits
    }

    // Retornar solo la longitud deseada en bytes
    return substr($hashBytes, 0, $hashLength); // Obtener solo la cantidad de bytes del hash
}
}
