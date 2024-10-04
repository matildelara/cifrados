<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HASH BLAKE2</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        /* Estilos del modal */
        .modal {
            display: none; /* Ocultar el modal por defecto */
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Fondo semitransparente */
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            width: 80%;
            max-width: 600px;
        }

        .close-btn {
            background-color: #5e4b8b;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 20px;
        }

        .close-btn:hover {
            background-color: #4b3e72;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="/">Acerca de</a>
        <a href="/cifrado-cesar">Cifrado César</a>
        <a href="/cifrado-escitala">Cifrado Escítala</a>
        <a href="/cifrado-rc6">Método Simétrico RC6</a>
        <a href="/cifrado-rabin">Método Asimétrico Rabin</a>
        <a href="/cifrado-blake2">HASH BLAKE2</a>
    </div>

    <div class="container">
        <h1>HASH BLAKE2</h1>

        <div class="form-wrapper">
            <form action="/blake2-calculate" method="POST">
                @csrf
                <input type="text" name="input" placeholder="Ingresa tu texto aquí" required>
                <button type="submit">Calcular Hash</button>
            </form>

            @if(isset($hash))
                <h2>Hash Blake2:</h2>
                <p>{{ $hash }}</p>
            @endif

            <!-- Botón para el funcionamiento del HASH -->
            <div>
                <button onclick="openModal()">¿Cómo funciona el HASH BLAKE2?</button>
            </div>
        </div>
    </div>

    <!-- Modal para mostrar información -->
    <div id="infoModal" class="modal">
        <div class="modal-content">
            <h2>¿Cómo funciona el HASH BLAKE2?</h2>
            <p>El algoritmo BLAKE2 es una función criptográfica de hash que genera un resumen único y fijo de una entrada (mensaje). Es más rápido que MD5 y SHA-2 y está diseñado para proporcionar un nivel alto de seguridad mientras es eficiente en términos de recursos.</p>
            <p>El algoritmo BLAKE2 se usa ampliamente en aplicaciones como la verificación de la integridad de datos, almacenamiento de contraseñas, y generación de identificadores únicos.</p>
            <button class="close-btn" onclick="closeModal()">Cerrar</button>
        </div>
    </div>

    <script>
        // Función para abrir el modal
        function openModal() {
            document.getElementById('infoModal').style.display = 'flex';
        }

        // Función para cerrar el modal
        function closeModal() {
            document.getElementById('infoModal').style.display = 'none';
        }
    </script>
</body>
</html>
