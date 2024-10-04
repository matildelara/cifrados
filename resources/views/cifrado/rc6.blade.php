<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cifrado RC6</title>
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
        <h1>Cifrado RC6</h1>
        <div class="form-wrapper">
            <form action="/rc6-cifrar" method="POST">
                @csrf
                <input type="text" name="mensaje" placeholder="Mensaje" required>
                <input type="text" name="clave" placeholder="Clave" required>
                <div>
                    <button type="submit">Cifrar</button>
                    <button type="submit" formaction="/rc6-descifrar">Descifrar</button>
                </div>
            </form>

            <h2>Resultado:</h2>
            <textarea readonly>{{ isset($resultado) ? $resultado : '' }}</textarea>

            <!-- Botones de copiar y funcionamiento -->
            <div>
                <button onclick="copyToClipboard()">Copiar</button>
                <button onclick="openModal()">¿Cómo funciona el Cifrado RC6?</button>
            </div>
        </div>
    </div>

    <!-- Modal para mostrar información -->
    <div id="infoModal" class="modal">
        <div class="modal-content">
            <h2>¿Cómo funciona el Cifrado RC6?</h2>
            <p>El RC6 es un cifrado simétrico en bloque, diseñado para ser eficiente tanto en software como en hardware. Funciona con bloques de 128 bits y utiliza claves de longitud variable, que pueden ir desde 128 hasta 256 bits.</p>
            <p>RC6 mejora las características de su predecesor, RC5, agregando multiplicación de enteros y una complejidad mayor en su estructura. Utiliza una serie de rondas para mezclar los datos de entrada y hacer que sea difícil revertir el cifrado sin conocer la clave correcta.</p>
            <button class="close-btn" onclick="closeModal()">Cerrar</button>
        </div>
    </div>

    <script>
        function copyToClipboard() {
            const resultText = document.querySelector('textarea').value;
            navigator.clipboard.writeText(resultText).then(() => {
                alert('Resultado copiado al portapapeles');
            });
        }

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
