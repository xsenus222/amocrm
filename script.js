// scripts.js
$(document).ready(function () {
    $('#phone').mask('+7 (000) 000-00-00');

    let startTime = Date.now();
    $('#contact-form').on('submit', function (e) {
        e.preventDefault();

        let timeSpent = Math.floor((Date.now() - startTime) / 1000);
        $('#time_spent').val(timeSpent);

        $.ajax({
            url: 'form.php',
            method: 'POST',
            data: $(this).serialize(),
            success: function (response) {
                if (response.form_submitted) {
                    $('#contact-form').hide();
                    $('#success-message').show();
                } else {
                    alert('Ошибка при отправке формы.');
                }
            },
            error: function () {
                alert('Произошла ошибка. Попробуйте еще раз.');
            }
        });
    });
});
