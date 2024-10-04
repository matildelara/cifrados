<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RabinController extends Controller
{
    // Verifica si un número es primo
    private function isPrime($num) {
        if ($num <= 1) return false;
        for ($i = 2; $i <= sqrt($num); $i++) {
            if ($num % $i === 0) return false; // Cambiado $i para que lo reconozca como variable
        }
        return true;
    }

    // Método para mostrar la vista
    public function index() {
        return view('cifrado.rabin'); // Llamada a la vista en la subcarpeta 'cifrado'
    }

    // Cifrar el mensaje
    public function cifrar(Request $request) {
        $p = intval($request->input('p'));
        $q = intval($request->input('q'));
        $message = intval($request->input('mensaje'));

        // Validación de números primos
        if (!$this->isPrime($p) || !$this->isPrime($q)) {
            return back()->with('resultado', 'Ambos números deben ser primos.');
        }

        // Generar la clave pública n = p * q
        $n = $p * $q;

        // Cifrado: c = m^2 mod n
        $cipheredMessage = ($message * $message) % $n;

        return view('cifrado.rabin', [
            'resultado' => "Mensaje cifrado: $cipheredMessage"
        ]);
    }

    // Función auxiliar para calcular inversos modulares
    private function modInverse($a, $m) {
        $m0 = $m;
        $y = 0;
        $x = 1;

        if ($m == 1) return 0;

        while ($a > 1) {
            $q = intval($a / $m);
            $t = $m;
            $m = $a % $m;
            $a = $t;
            $t = $y;
            $y = $x - $q * $y;
            $x = $t;
        }

        if ($x < 0) $x += $m0;

        return $x;
    }

    // Descifrar el mensaje cifrado
    public function descifrar(Request $request) {
        $p = intval($request->input('p'));
        $q = intval($request->input('q'));
        $cipheredMessage = intval($request->input('mensaje'));

        // Validación de números primos
        if (!$this->isPrime($p) || !$this->isPrime($q)) {
            return back()->with('resultado', 'Ambos números deben ser primos.');
        }

        $n = $p * $q;

        // Calcular las raíces cuadradas modulares
        $m1 = intval(bcmod(bcsqrt($cipheredMessage), $p));
        $m2 = $p - $m1;
        $m3 = intval(bcmod(bcsqrt($cipheredMessage), $q));
        $m4 = $q - $m3;

        // Inversos modulares de p y q
        $invP = $this->modInverse($p, $q);
        $invQ = $this->modInverse($q, $p);

        // Teorema chino del resto para combinar soluciones
        $x1 = ( ($m1 * $q * $invQ) + ($m3 * $p * $invP) ) % $n;
        $x2 = ( ($m1 * $q * $invQ) + ($m4 * $p * $invP) ) % $n;
        $x3 = ( ($m2 * $q * $invQ) + ($m3 * $p * $invP) ) % $n;
        $x4 = ( ($m2 * $q * $invQ) + ($m4 * $p * $invP) ) % $n;

        // Mensajes descifrados
        $decryptedMessages = [$x1, $x2, $x3, $x4];

        return view('cifrado.rabin', [
            'resultado' => "Mensajes descifrados: " . implode(', ', $decryptedMessages)
        ]);
    }
    // Función para completar la cadena del mensaje a 16 bits
    private function completarCadena($mensaje) {
        $tam = strlen($mensaje);
        $diferencia = 16 - $tam;

        if ($tam < 16) {
            $aux = substr($mensaje, $diferencia, $tam);
            $nuevo_mensaje = $mensaje . $aux;
        } else {
            $nuevo_mensaje = $mensaje;
        }

        return $nuevo_mensaje;
    }
}
