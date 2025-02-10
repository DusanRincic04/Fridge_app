<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dietary Advice</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center mb-4">Get Dietary Advice</h1>

    <!-- Forma za unos cilja korisnika -->
    <form action="{{ route('dietary.advice') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="goal" class="form-label">Select Your Goal</label>
            <select name="goal" id="goal" class="form-select">
                <option value="weight loss">Weight Loss</option>
                <option value="muscle gain">Muscle Gain</option>
                <option value="healthy eating">Healthy Eating</option>
            </select>

            <label for="allergies">Allergies (comma separated):</label>
            <input type="text" name="allergies">

            <label for="preferences">Food Preferences (comma separated):</label>
            <input type="text" name="preferences">
        </div>
        <button type="submit" class="btn btn-primary">Get Advice</button>
    </form>

    <!-- Prikazivanje saveta koji su generisani od strane OpenAI -->
    @if(isset($dietaryAdvice))
        <div class="alert alert-info mt-4">
            <h4>Dietary Advice:</h4>
            <p>{{ $dietaryAdvice }}</p>
        </div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
