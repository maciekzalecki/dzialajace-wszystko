<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>Przypomnienie hasła</title>
</head>
<body>
    <div class="container">
        <br>
        <h1 class="text-center">Przypomnienie hasła</h1>
        <br>

        <div class="d-flex justify-content-center">
            <form id="forgotPasswordForm" class="p-4 bg-dark text-white rounded">
                <h3>Wprowadź email</h3>
                <div class="mb-3">
                    <label for="forgot-email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="forgot-email" required>
                </div>
                <button type="submit" class="btn btn-primary">Przypomnij hasło</button>
                <div id="forgot-message" class="mt-3"></div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="main.js"></script>
</body>
</html>
