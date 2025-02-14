<h2>Your generated recipes</h2>

@foreach($recipes as $recipe)
    <h3>{{ $recipe->name }}</h3>
    <h4>Ingredients:</h4>
    <ul>
        @foreach(json_decode($recipe->ingredients, true) as $ingredient)
            <li>{{ $ingredient }}</li>
        @endforeach
    </ul>
    <h4>Instructions:</h4>
    <p>{{ $recipe->instructions }}</p>
    <hr>
@endforeach
