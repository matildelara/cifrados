<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CifradoController extends Controller
{
    public function comparacion()
    {
        return view('cifrado.comparacion'); // Vista principal con comparación
    }

    public function cesar()
    {
        return view('cifrado.cesar'); // Vista para el cifrado César
    }

    public function escitala()
    {
        return view('cifrado.escitala'); // Vista para el cifrado Escítala
    }

    public function rc6()
    {
        return view('cifrado.rc6'); // Vista para el cifrado RC6
    }

    public function rabin()
    {
        return view('cifrado.rabin'); // Vista para el cifrado Rabin
    }

    public function blake2()
    {
        return view('cifrado.blake2'); // Vista para el hash BLAKE2
    }

    // Métodos para Cifrado César
    public function cifrar(Request $request)
    {
        $mensaje = $request->input('mensaje');
        $desplazamiento = $request->input('desplazamiento');
        $resultado = $this->cifrarCesar($mensaje, $desplazamiento);
        return view('cifrado.cesar', ['resultado' => $resultado]);
    }

    public function descifrar(Request $request)
    {
        $mensaje = $request->input('mensaje');
        $desplazamiento = $request->input('desplazamiento');
        $resultado = $this->descifrarCesar($mensaje, $desplazamiento);
        return view('cifrado.cesar', ['resultado' => $resultado]);
    }

    // Lógica del Cifrado César
    private function cifrarCesar($mensaje, $desplazamiento)
    {
        $resultado = '';
        foreach (str_split($mensaje) as $char) {
            if (ctype_alpha($char)) {
                $offset = ctype_upper($char) ? ord('A') : ord('a');
                $resultado .= chr(($offset + (ord($char) - $offset + $desplazamiento) % 26));
            } else {
                $resultado .= $char; // No cifrar caracteres no alfabéticos
            }
        }
        return $resultado;
    }

    private function descifrarCesar($mensaje, $desplazamiento)
    {
        return $this->cifrarCesar($mensaje, 26 - ($desplazamiento % 26)); // Desplazar hacia atrás
    }

    // Métodos para Cifrado Escítala
    public function cifrarEscitala(Request $request)
{
    $mensaje = $request->input('mensaje');
    $columnas = $request->input('columnas');
    $resultado = $this->cifrarEscitalaLogic($mensaje, $columnas);
    return view('cifrado.escitala', ['resultado' => $resultado, 'mensaje' => $mensaje, 'columnas' => $columnas]);
}

public function descifrarEscitala(Request $request)
{
    $mensaje = $request->input('mensaje');
    $columnas = $request->input('columnas');
    $resultado = $this->descifrarEscitalaLogic($mensaje, $columnas);
    return view('cifrado.escitala', ['resultado' => $resultado, 'mensaje' => $mensaje, 'columnas' => $columnas]);
}

private function cifrarEscitalaLogic($mensaje, $columnas)
{
    if ($columnas <= 0) {
        return "El número de columnas debe ser mayor que cero.";
    }

    $resultado = '';
    $numCols = (int)$columnas; // Convertir a entero
    $rows = ceil(strlen($mensaje) / $numCols); // Calcular el número de filas

    for ($col = 0; $col < $numCols; $col++) {
        for ($row = 0; $row < $rows; $row++) {
            $index = $row * $numCols + $col;
            if ($index < strlen($mensaje)) {
                $resultado .= $mensaje[$index]; // Añadir carácter al resultado
            }
        }
    }

    return $resultado; // Retornar el mensaje cifrado
}

private function descifrarEscitalaLogic($mensaje, $columnas)
{
    if ($columnas <= 0) {
        return "El número de columnas debe ser mayor que cero.";
    }

    $numCols = (int)$columnas; // Convertir a entero
    $numRows = ceil(strlen($mensaje) / $numCols); // Calcular el número de filas
    $numChars = strlen($mensaje); // Cantidad total de caracteres en el mensaje

    // Crear una matriz de filas por columnas para reorganizar los caracteres
    $matriz = array_fill(0, $numRows, '');

    $index = 0; // Índice para recorrer el mensaje cifrado
    for ($col = 0; $col < $numCols; $col++) {
        for ($row = 0; $row < $numRows; $row++) {
            // Verificamos que el índice no exceda la longitud del mensaje
            if ($index < $numChars) {
                $matriz[$row] .= $mensaje[$index];
                $index++;
            }
        }
    }

    // Ahora volvemos a construir el mensaje original recorriendo por filas
    $resultado = '';
    foreach ($matriz as $fila) {
        $resultado .= $fila;
    }

    return $resultado; // Retornar el mensaje descifrado
}
}