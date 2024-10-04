<?php

namespace App\Services;

class RC6
{
    private $w = 32; // Tamaño de palabra en bits (32 bits)
    private $r = 20; // Número de rondas
    private $P32 = 0xb7e15163; // Constante de inicialización
    private $Q32 = 0x9e3779b9; // Constante de incremento

    private function rotateLeft($x, $y)
    {
        error_log("rotateLeft: x = $x, y = $y");
        // Asegurarse de que $y esté dentro de los límites
    if ($y < 0 || $y >= $this->w) {
        // Si $y es negativo, ajustarlo a 0; si es mayor que $this->w, ajustarlo a $this->w - 1
        $y = ($y < 0) ? 0 : ($this->w - 1);
    }
    return (($x << $y) | ($x >> ($this->w - $y))) & 0xFFFFFFFF; // Asegura que el resultado sea sin signo
    }

    private function rotateRight($x, $y)
    {
          // Asegurarse de que $y esté dentro de los límites
    if ($y < 0 || $y >= $this->w) {
        $y = ($y < 0) ? 0 : ($this->w - 1);
    }
    return (($x >> $y) | ($x << ($this->w - $y))) & 0xFFFFFFFF; // Asegura que el resultado sea sin signo
    }

    public function expandKey($key)
    {
        $key = array_map('ord', str_split($key));
        $keySize = count($key);
        $keyArray = array_fill(0, 2 * ($this->r + 1), 0);
        $keyArray[0] = 0xB7E15163;
    
        for ($i = 1; $i < count($keyArray); $i++) {
            $keyArray[$i] = ($keyArray[$i - 1] + 0x9E3779B9) & 0xFFFFFFFF;
        }
    
        // Construir el arreglo L
        $L = [];
        for ($i = 0; $i < ceil($keySize / 4); $i++) {
            $L[$i] = ($key[$i * 4] | ($key[$i * 4 + 1] << 8) | ($key[$i * 4 + 2] << 16) | ($key[$i * 4 + 3] << 24)) & 0xFFFFFFFF;
        }
    
        // Asegurarse de que $keyArray sea lo suficientemente grande
        if (count($keyArray) < 2 * $this->r + 2) {
            throw new \Exception('El tamaño de keyArray es insuficiente.');
        }
    return $keyArray;
    }

    public function encrypt($plaintext, $key)
    {
        $keyArray = $this->expandKey($key);
        $plaintext = str_pad($plaintext, 16, "\0"); // Asegúrate de que el texto tenga longitud 16
        list($A, $B, $C, $D) = array_values(unpack('V4', $plaintext));

        $B += $keyArray[0];
        $D += $keyArray[1];

        for ($i = 0; $i < $this->r; $i++) {
            $t = ($B * (2 * $B + 1)) << ($this->w - 5) & 0xFFFFFFFF;
            $u = ($D * (2 * $D + 1)) << ($this->w - 5) & 0xFFFFFFFF;

            $A = ($this->rotateLeft(($A ^ $t), $u) + $keyArray[2 * $i + 2]) & 0xFFFFFFFF;
            $C = ($this->rotateLeft(($C ^ $u), $t) + $keyArray[2 * $i + 3]) & 0xFFFFFFFF;

            list($A, $B, $C, $D) = [$B, $C, $D, $A];
        }

        $A += $keyArray[2 * $this->r + 2];
        $C += $keyArray[2 * $this->r + 3];

        return pack('V4', $A, $B, $C, $D);
    }

    public function decrypt($ciphertext, $key)
    {
        $keyArray = $this->expandKey($key);
        list($A, $B, $C, $D) = array_values(unpack('V4', $ciphertext));

        $C -= $keyArray[2 * $this->r + 3];
        $A -= $keyArray[2 * $this->r + 2];

        for ($i = $this->r - 1; $i >= 0; $i--) {
            list($A, $B, $C, $D) = [$D, $A, $B, $C];

            $u = ($D * (2 * $D + 1)) << ($this->w - 5) & 0xFFFFFFFF;
            $t = ($B * (2 * $B + 1)) << ($this->w - 5) & 0xFFFFFFFF;

            $C = ($this->rotateRight(($C - $keyArray[2 * $i + 3]), $t) ^ $u) & 0xFFFFFFFF;
            $A = ($this->rotateRight(($A - $keyArray[2 * $i + 2]), $u) ^ $t) & 0xFFFFFFFF;
        }

        $D -= $keyArray[1];
        $B -= $keyArray[0];

        return pack('V4', $A, $B, $C, $D);
    }
}
