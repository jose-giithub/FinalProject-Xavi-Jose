<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiempo Expirado</title>
    <style>
         body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            background-color: #ffffff;
            margin: 50px auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
        }
        .header {
            background-color: #007bff;
            color: #ffffff;
            padding: 10px 0;
            text-align: center;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }
        .header h1 {
            margin: 0;
        }
        .content {
            padding: 20px;
        }
        .content p {
            font-size: 16px;
            line-height: 1.5;
            color: #333333;
        }
        .footer {
            text-align: center;
            padding: 10px;
            color: #777777;
            font-size: 12px;
            border-bottom-left-radius: 8px;
            border-bottom-right-radius: 8px;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 20px;
            font-size: 16px;
            color: #ffffff;
            background-color: #007bff;
            text-decoration: none;
            border-radius: 5px;
        }
        .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<div class="container">
        <div class="header">
            <h1>Solo Faltan  {{ $diasRestantes }} días</h1>
        </div>
        <div class="content">
            <p>Hola {{ $user->name }},</p>
            <p>Hola {{ $user->email }},</p>
            <p>Te contactamos desde Tu Taller +.</p>
            <p>Queremos recordarte que solo te faltan {{$diasRestantes }} días para que tu {{ $tipoRecordatorio }} expire.</p>
            <p>Recuerda que desde Tu Taller + estamos para ayudarte a encontrar los mejores profesionales que atiendan a ti y a tu vehículo de la mejor manera posible.</p>
            <p>Encuentra los mejores talleres de tu ciudad en nuestra web:</p>
            <p><a href="http://127.0.0.1:8000/" class="button">Visitar Nuestra Web</a></p>
        </div>
        <div class="footer">
            <p>&copy; 2024 Tu Taller+. Todos los derechos reservados.</p>
        </div>
    </div>
</body>
</html>
