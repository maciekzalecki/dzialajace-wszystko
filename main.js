// Obsługa logowania
$("#loginForm").submit(function(e) {
    e.preventDefault();  // Zapobiega przeładowaniu strony

    let email = $("#login-email").val();
    let password = $("#login-password").val();

    $.ajax({
        url: 'login.php',  // Plik obsługujący logowanie
        method: 'POST',
        data: {
            email: email,
            password: password
        },
        success: function(response) {
            $("#login-message").html(response);  // Wyświetlanie odpowiedzi z serwera
            $("#loginForm")[0].reset();  // Czyszczenie formularza po wysłaniu
        },
        error: function() {
            $("#login-message").html("Błąd podczas logowania.");
        }
    });
});

// Obsługa rejestracji
$("#registerForm").submit(function(e) {
    e.preventDefault();  // Zapobiega przeładowaniu strony

    let email = $("#register-email").val();
    let password = $("#register-password").val();
    let confirmPassword = $("#register-confirm-password").val();

    $.ajax({
        url: 'register.php',  // Plik obsługujący rejestrację
        method: 'POST',
        data: {
            email: email,
            password: password,
            confirmPassword: confirmPassword
        },
        success: function(response) {
            $("#register-message").html(response);  // Wyświetlanie odpowiedzi z serwera
            $("#registerForm")[0].reset();  // Czyszczenie formularza po wysłaniu
        },
        error: function() {
            $("#register-message").html("Błąd podczas rejestracji.");
        }
    });
});

// Obsługa przypomnienia hasła
$("#forgotPasswordForm").submit(function(e) {
    e.preventDefault();  // Zapobiega przeładowaniu strony

    let email = $("#forgot-email").val();

    $.ajax({
        url: 'forgot_password_handler.php',  // Plik obsługujący przypomnienie hasła
        method: 'POST',
        data: {
            email: email
        },
        success: function(response) {
            $("#forgot-message").html(response);  // Wyświetlanie odpowiedzi z serwera
            $("#forgotPasswordForm")[0].reset();  // Czyszczenie formularza po wysłaniu
        },
        error: function() {
            $("#forgot-message").html("Błąd podczas przypominania hasła.");
        }
    });
});
