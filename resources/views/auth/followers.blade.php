<!-- resources/views/followers.blade.php -->
<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Seguidores del Taller</title>

<head>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2>Seguidores del Taller</h2>
        <ul class="list-group">
            @foreach ($followers as $follower)
                <li class="list-group-item">
                    {{ $follower->name }} ({{ $follower->email }})
                </li>
            @endforeach
        </ul>
    </div>
</body>

</html>
