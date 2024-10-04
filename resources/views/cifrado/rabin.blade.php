<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cifrado Asimétrico Rabin</title>
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
        <h1>Cifrado Asimétrico Rabin</h1>

        <div class="form-wrapper">
            <!-- Formulario para CIFRAR -->
            <form action="/rabin-cifrar" method="POST">
                @csrf
                <!-- Campos para los primos p y q -->
                <input type="number" name="p" id="p" placeholder="Primo (p)" required>
                <input type="number" name="q" id="q" placeholder="Primo (q)" required>

                <!-- Campo para el mensaje -->
                <input type="number" name="mensaje" id="mensaje" placeholder="Mensaje a cifrar" required>

                <!-- Botón para cifrar -->
                <div>
                    <button type="submit">Cifrar</button>
                </div>
            </form>

            <!-- Formulario para DESCIFRAR -->
            <form action="/rabin-descifrar" method="POST">
                @csrf
                <!-- Campos para los primos p y q -->
                <input type="number" name="p" id="p" placeholder="Primo (p)" required>
                <input type="number" name="q" id="q" placeholder="Primo (q)" required>

                <!-- Campo para el mensaje -->
                <input type="number" name="mensaje" id="mensaje" placeholder="Mensaje a descifrar" required>

                <!-- Botón para descifrar -->
                <div>
                    <button type="submit">Descifrar</button>
                </div>
            </form>

            <!-- Mostrar el resultado -->
            <h2>Resultado:</h2>
            <textarea readonly>{{ isset($resultado) ? $resultado : '' }}</textarea>

            <!-- Botones de copiar y funcionamiento -->
            <div>
                <button onclick="copyToClipboard()">Copiar</button>
                <button onclick="openModal()">¿Cómo funciona el Cifrado Rabin?</button>
            </div>
        </div>
    </div>

    <!-- Modal para mostrar información -->
    <div id="infoModal" class="modal">
        <div class="modal-content">
            <h2>¿Cómo funciona el Cifrado Rabin?</h2>
            <p>El cifrado Rabin es un sistema de cifrado asimétrico basado en la dificultad de factorizar números grandes. Utiliza dos números primos grandes (p y q) para generar una clave pública y una clave privada.</p>
            <p>El mensaje se cifra mediante operaciones modulares con la clave pública. Para descifrar, es necesario conocer ambos primos p y q, lo que hace que el cifrado Rabin sea seguro si los primos son lo suficientemente grandes.</p>
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
