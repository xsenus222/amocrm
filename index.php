<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form to amoCRM</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <script src="script.js"></script>
</head>
<body>
<div class="form-container">
    <h2>Форма заявки</h2>
    <form id="contact-form">
        <input id="name" name="name" placeholder="Ваше имя" required>
        <input id="phone" name="phone" placeholder="+7 (XXX) XXX-XX-XX" required>
        <input id="email" name="email" placeholder="example@domain.com" required>
        <input id="price" name="price" placeholder="Цена" type="number" required>
        <input type="hidden" id="time_spent" name="time_spent" value="0">
        <button type="submit">Отправить</button>
    </form>
    <div id="success-message">Форма успешно отправлена!</div>
</div>
</body>
</html>
