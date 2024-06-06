<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
           <!-- CDN iconos -->
           <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notificaciones del usuario</title>
    @vite([ 'resources/css/headerNav.css','resources/css/footer.css', ])
    
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 10px auto;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            margin-top: 40px;
        }
        h1.text-center {
            color: #343a40;
        }
        .notification-item {
            background-color: #e9ecef;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 15px;
            border: 1px solid #ced4da;
        }
        .notification-item a {
            color: #007bff;
            text-decoration: none;
        }
        .notification-item a:hover {
            text-decoration: underline;
        }
        .notification-item p {
            margin: 0 0 5px;
            color: #495057;
        }
        .notification-item small.text-muted {
            display: block;
            margin-top: 5px;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            color: #ffffff;
            padding: 5px 10px;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .text-muted {
            color: #6c757d;
        }
        .my-4 {
            margin: 20px 0;
        }
        .mt-2 {
            margin-top: 10px;
        }
        .list-unstyled {
            padding: 0;
            list-style: none;
        }
    </style>
</head>
<body>
<!--******************** inporto el nav desde resources\views\components\navbar.blade.phpD -->
<x-navbar />
@section('content')
<div class="container">
    <h1 class="text-center my-4">Tus Notificaciones</h1>
    @if ($notifications->isEmpty())
        <p>No tienes notificaciones.</p>
    @else
        <ul class="list-unstyled">
            @foreach ($notifications as $notification)
                <li class="notification-item">
                    @if($notification->follower)
                    <a href="{{route('notifications.chat', ['id' => $notification->taller->id]) }}">
                        <p>{{ $notification->follower->name }} te ha enviado un mensaje en el taller {{ $notification->taller->nombre_de_taller }}.</p>
                    </a>
                    @else
                        <p>{{ $notification->message }}</p>
                    @endif
                    <small class="text-muted">{{ $notification->created_at }}</small>
                    @if (!$notification->read)
                        <form action="{{ route('notifications.read', $notification->id) }}" method="POST" class="mt-2">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-sm btn-primary">Marcar como leído</button>
                        </form>
                    @endif
                </li>
            @endforeach
        </ul>
    @endif
</div>
<div style="margin-top: 20%;">
<x-footer />
</div>

</body>
</html>
