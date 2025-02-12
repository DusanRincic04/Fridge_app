<h2>Vaši generisani recepti</h2>

@foreach($recipes as $recipe)
    <h3>{{ $recipe->name }}</h3>
    <h4>Sastojci:</h4>
    <ul>
        @foreach(json_decode($recipe->ingredients, true) as $ingredient)
            <li>{{ $ingredient }}</li>
        @endforeach
    </ul>
    <h4>Priprema:</h4>
    <p>{{ $recipe->instructions }}</p>
    <hr>
@endforeach
