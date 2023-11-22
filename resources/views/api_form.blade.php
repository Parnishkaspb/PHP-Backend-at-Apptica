<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
</head>
<body>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="POST" action="/submit-api-form">
        @csrf
        <label for="applicationId">applicationId:</label>
        <input type="text" id="applicationId" name="applicationId" required><br>

        <label for="countryId">countryId:</label>
        <input type="text" id="countryId" name="countryId" required><br>

        <label for="dateFrom">dateFrom:</label>
        <input type="date" id="dateFrom" name="dateFrom" required><br>

        <label for="dateTo">dateTo:</label>
        <input type="date" id="dateTo" name="dateTo" required><br>

        <button type="submit">Отправить</button>
    </form>
</body>
</html>
