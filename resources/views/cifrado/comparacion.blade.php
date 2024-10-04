<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comparación de Cifrados</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        /* Estilos para centrar la sección de datos personales */
        .personal-info {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
        }

        /* Estilos para el contenedor y tabla */
        .container {
            margin: 20px auto;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            max-width: 1200px; /* Aumentar el ancho máximo */
        }

        table {
            width: 100%; /* Asegurar que la tabla ocupe el 100% del contenedor */
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #5e4b8b; /* Borde en la tabla */
            padding: 10px;
            text-align: left;
            vertical-align: top; /* Alinear el contenido en la parte superior */
        }

        th {
            background-color: #5e4b8b;
            color: white;
            font-weight: 600;
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9; /* Alternar color de filas */
        }

        /* Aumentar el tamaño de la fuente para mejor legibilidad */
        th, td {
            font-size: 16px;
        }
    </style>
</head>
<body>
    <!-- Barra de navegación -->
    <div class="navbar">
        <a href="/">Acerca de</a>
        <a href="/cifrado-cesar">Cifrado César</a>
        <a href="/cifrado-escitala">Cifrado Escítala</a>
        <a href="/cifrado-rc6">Método Simétrico RC6</a>
        <a href="/cifrado-rabin">Método Asimétrico Rabin</a>
        <a href="/cifrado-blake2">HASH BLAKE2</a>
    </div>
    
    <!-- Contenido principal -->
    <div class="container">
        <h1>Comparación de Métodos de Cifrado</h1>
        <table>
            <thead>
                <tr>
                    <th>Criterio</th>
                    <th>Cifrado César</th>
                    <th>Cifrado Escítala</th>
                    <th>Método Simétrico RC6</th>
                    <th>Método Asimétrico Rabin</th>
                    <th>HASH BLAKE2</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Método de Cifrado:</td>
                    <td>Cifrado por sustitución. Desplazamiento de letras en el alfabeto.</td>
                    <td>Cifrado por transposición. Reorganización de letras en función de una varilla.</td>
                    <td>Cifrado simétrico por bloques. Encriptación de bloques de datos en rondas.</td>
                    <td>Cifrado asimétrico basado en números primos.</td>
                    <td>Algoritmo de hash criptográfico. Produce un resumen fijo de los datos.</td>
                </tr>
                <tr>
                    <td>Complejidad:</td>
                    <td>Muy simple, fácil de implementar y de romper.</td>
                    <td>Requiere clave física (diámetro de varilla), pero sigue siendo simple.</td>
                    <td>Más complejo, utiliza varias rondas de cifrado y claves más largas.</td>
                    <td>Moderadamente complejo debido a la matemática involucrada.</td>
                    <td>Moderada, pero muy eficiente en comparación con otros hashes como SHA.</td>
                </tr>
                <tr>
                    <td>Clave:</td>
                    <td>Desplazamiento entre 1 y 25.</td>
                    <td>Número de columnas (basado en la varilla).</td>
                    <td>Clave simétrica, de longitud variable.</td>
                    <td>Clave pública y privada basadas en números primos.</td>
                    <td>No hay clave, es un algoritmo de hash.</td>
                </tr>
                <tr>
                    <td>Vulnerabilidad a Ataques:</td>
                    <td>Vulnerable a ataques de fuerza bruta y análisis de frecuencia.</td>
                    <td>Menos vulnerable al análisis de frecuencia, pero susceptible si se conoce la longitud de la varilla.</td>
                    <td>Resistente a la mayoría de los ataques conocidos cuando se usa correctamente.</td>
                    <td>Vulnerable si se descubre la clave privada o si se usan números primos pequeños.</td>
                    <td>Muy seguro, casi imposible de revertir, pero ataques de colisión son posibles.</td>
                </tr>
                <tr>
                    <td>Velocidad de Encriptación:</td>
                    <td>Muy rápida, debido a su simplicidad.</td>
                    <td>Moderada, depende de la longitud del mensaje y el tamaño de la varilla.</td>
                    <td>Rápida para grandes cantidades de datos.</td>
                    <td>Más lenta debido a la matemática involucrada en el proceso asimétrico.</td>
                    <td>Extremadamente rápido en la generación del hash.</td>
                </tr>
                <tr>
                    <td>Aplicaciones Comunes:</td>
                    <td>Historia, como encriptación en tiempos antiguos.</td>
                    <td>Usado en la antigüedad para transmitir mensajes secretos en la guerra.</td>
                    <td>Usado en sistemas de almacenamiento, comunicaciones seguras.</td>
                    <td>Firmas digitales, cifrado de mensajes privados.</td>
                    <td>Almacenamiento de contraseñas, verificación de integridad de datos.</td>
                </tr>
            </tbody>
        </table>

        <h2>Análisis de Seguridad</h2>
        <h3>Cifrado César:</h3>
        <ul>
            <li><strong>Fuerza Bruta:</strong> Solo hay 25 posibles desplazamientos, por lo que es fácil de romper.</li>
            <li><strong>Análisis de Frecuencia:</strong> Muy susceptible al análisis de frecuencia ya que las letras conservan su frecuencia.</li>
        </ul>

        <h3>Cifrado Escítala:</h3>
        <ul>
            <li><strong>Fuerza Bruta:</strong> Depende del número de columnas, pero sigue siendo susceptible a un ataque de prueba y error.</li>
            <li><strong>Seguridad Limitada:</strong> Es un método de transposición, lo que complica el análisis de frecuencia pero no lo hace significativamente más seguro.</li>
        </ul>

        <h3>Método Simétrico RC6:</h3>
        <ul>
            <li><strong>Seguridad Alta:</strong> Si se configura correctamente, es resistente a la mayoría de los ataques criptográficos conocidos.</li>
            <li><strong>Requiere Clave Secreta:</strong> Como es simétrico, el cifrado y descifrado requieren la misma clave, lo que añade riesgo si la clave no se gestiona correctamente.</li>
        </ul>

        <h3>Método Asimétrico Rabin:</h3>
        <ul>
            <li><strong>Clave Pública y Privada:</strong> El sistema utiliza dos claves diferentes, haciendo que el cifrado y descifrado sean más seguros.</li>
            <li><strong>Dependencia de Primos Grandes:</strong> La seguridad depende del uso de números primos grandes para evitar ataques de factorización.</li>
        </ul>

        <h3>HASH BLAKE2:</h3>
        <ul>
            <li><strong>Alta Velocidad:</strong> Uno de los algoritmos de hash más rápidos.</li>
            <li><strong>Imposible de Revertir:</strong> Como cualquier función de hash, no se puede revertir para obtener el mensaje original.</li>
        </ul>

        <!-- Sección de Datos Personales centrada -->
        <div class="personal-info">
            <h2>Datos Personales</h2>
            <p><strong>Nombre:</strong> Matilde Lara Guzmán</p>
            <p><strong>Cuatrimestre y Grupo:</strong> 7º "B"</p>
            <p><strong>Carrera:</strong> Ing. Desarrollo y Gestión de Software</p>
            <p><strong>Universidad:</strong> UTHH</p>
        </div>
    </div>
</body>
</html>
