$(document).ready(function () {
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
                if (response.success) {
                    window.location.href = 'admin_panel.php'; // Przekierowanie po zalogowaniu
                }
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

    // Obsługa dodawania produktu
    $('#addProductForm').on('submit', function (e) {
        e.preventDefault(); // Zapobiegaj domyślnej akcji formularza

        // Zbieranie danych z formularza
        var name = $('#product-name').val();
        var price = $('#product-price').val();
        var description = $('#product-description').val();
        var category = $('#product-category').val();

        $.ajax({
            type: 'POST',
            url: 'add_product.php', // Adres URL do skryptu dodawania produktu
            data: {
                'product-name': name,
                'product-price': price,
                'product-description': description,
                'product-category': category
            },
            success: function (response) {
                response = JSON.parse(response); // Parsowanie odpowiedzi z serwera
                $('#add-product-message').text(response.message); // Wyświetlenie komunikatu
                if (response.success) {
                    // Wyczyść formularz, jeśli dodawanie było udane
                    $('#addProductForm')[0].reset();
                }
            },
            error: function () {
                $('#add-product-message').text('Wystąpił błąd przy dodawaniu produktu.');
            }
        });
    });
});
