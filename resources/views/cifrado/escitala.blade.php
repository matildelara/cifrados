<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cifrado Escítala</title>
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
        <h1>Cifrado Escítala</h1>

        <!-- Aplicamos la misma estructura que en César, con el div form-wrapper -->
        <div class="form-wrapper">
            <!-- Formulario para cifrar -->
            <form action="/escitala-cifrar" method="POST">
                @csrf
                <input type="text" name="mensaje" placeholder="Mensaje" required>
                <input type="number" name="columnas" placeholder="Número de columnas" required>
                
                <div>
                    <button type="submit">Cifrar</button>
                    <button type="submit" formaction="/escitala-descifrar">Descifrar</button>
                </div>
            </form>

            <h2>Resultado:</h2>
            <textarea readonly>{{ isset($resultado) ? $resultado : '' }}</textarea>

            <!-- Botones de copiar y funcionamiento -->
            <div>
                <button onclick="copyToClipboard()">Copiar</button>
                <button onclick="openModal()">¿Cómo funciona el Cifrado Escítala?</button>
            </div>
        </div>
    </div>

    <!-- Modal para mostrar información -->
    <div id="infoModal" class="modal">
        <div class="modal-content">
            <h2>¿Cómo funciona el Cifrado Escítala?</h2>
            <p>El Cifrado Escítala es un método de cifrado por transposición utilizado en la antigua Grecia. Consiste en enrollar una tira de papel o cuero alrededor de una vara de madera (escítala). El mensaje se escribe en columnas a lo largo de la vara, y luego, al desenrollarlo, las letras quedan desordenadas. El destinatario debe tener una vara del mismo diámetro para descifrar el mensaje.</p>
            <p>La clave del cifrado es el número de columnas o la longitud de la varilla, que es lo que determina cómo se reorganizan las letras en el mensaje cifrado.</p>
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
