<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generisani recepti</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">
<h2>Generisani recepti</h2>

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

@if(!empty($recipes))
    @foreach($recipes as $recipe)
        <div class="card mb-3">
            <div class="card-body">
                <h4 class="card-title">{{ $recipe->title }}</h4>
                <h5>Sastojci:</h5>
                <ul>
                    @foreach(json_decode($recipe->ingredients, true) as $ingredient)
                        <li>{{ $ingredient }}</li>
                    @endforeach
                </ul>
                <h5>Priprema:</h5>
                <p>{{ $recipe->instructions }}</p>
            </div>
        </div>
    @endforeach
@else
    <p>Nema generisanih recepata.</p>
@endif
</body>
</html>
