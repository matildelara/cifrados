<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comparación de Cifrados</title>
    <link rel="stylesheet" href="{{ asset('app.css') }}"> <!-- Enlaza tu CSS aquí -->
</head>
<body>
    <div class="container">
        <h1>Comparación entre el Cifrado César y el Cifrado Escítala</h1>
        <table>
            <thead>
                <tr>
                    <th>Criterio</th>
                    <th>Cifrado César</th>
                    <th>Cifrado Escítala</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Método de Cifrado:</td>
                    <td>Cifrado por sustitución. Cada letra del mensaje es desplazada un número fijo de posiciones en el alfabeto.</td>
                    <td>Cifrado por transposición. El orden de las letras del mensaje es reorganizado en función de un patrón geométrico (el enrollado en una varilla).</td>
                </tr>
                <tr>
                    <td>Complejidad:</td>
                    <td>Muy simple y directo, fácil de implementar y comprender, pero fácil de descifrar si se conoce la lógica del desplazamiento.</td>
                    <td>Relativamente simple, pero requiere una "clave" física (el diámetro de la varilla), lo que añade resistencia en ciertos contextos.</td>
                </tr>
                <tr>
                    <td>Clave:</td>
                    <td>Número de desplazamiento entre 1 y 25. Conociendo este valor, es trivial descifrar el mensaje.</td>
                    <td>Diámetro de la varilla, que define cuántas columnas tendrá el mensaje. Requiere probar varias longitudes si no se conoce la longitud del cilindro.</td>
                </tr>
                <tr>
                    <td>Vulnerabilidad a Ataques:</td>
                    <td>Vulnerable a ataques de fuerza bruta (25 desplazamientos) y a análisis de frecuencia.</td>
                    <td>Menos vulnerable al análisis de frecuencia, pero susceptible a ataques por permutaciones y descifrados si se conocen las dimensiones de la varilla.</td>
                </tr>
            </tbody>
        </table>
        
        <h2>Análisis de Seguridad</h2>
        <h3>Cifrado César:</h3>
        <ul>
            <li><strong>Fuerza Bruta:</strong> Solo hay 25 posibles desplazamientos, por lo que un atacante puede probar todas las claves en cuestión de segundos.</li>
            <li><strong>Análisis de Frecuencia:</strong> Como las letras originales se mantienen y solo cambian su posición en el alfabeto, es susceptible al análisis de frecuencia.</li>
        </ul>

        <h3>Cifrado Escítala:</h3>
        <ul>
            <li><strong>Fuerza Bruta:</strong> Un ataque de fuerza bruta implicaría probar todas las posiciones de la varilla, lo que requiere más tiempo que el cifrado César, pero no mucho si el mensaje no es muy largo.</li>
            <li><strong>Seguridad Limitada:</strong> Aunque la transposición complica el análisis de frecuencia, no añade una capa significativa de seguridad moderna.</li>
        </ul>
    </div>
</body>
</html>
