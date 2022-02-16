<?php
require('../vendor/autoload.php');

use Rakit\Validation\Validator;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $validator = new Validator();
    $validation = $validator->make($_POST, [
        'name' => 'required|min:3|max:40|regex:/^[А-Яа-яЁё\-\s\']+$/u',
        'age' => 'required|numeric|min:1',
        'phone' => 'required|min:6|max:12',
        'ss' => 'required|digits:11',
    ]);

    $validation->setAliases([
        'name' => 'Имя',
        'age' => 'Возраст',
        'phone' => 'Телефон',
        'ss' => 'СНИЛС',
    ]);

    $validation->setMessages([
        'required' => 'Обязательное поле: :attribute',
        'numeric' => 'Должно быть числовым: :attribute',
        'min' => 'Не короче :min знаков',
        'max' => 'Не длиннее :max знаков',
        'name:regex' => 'Некорректные знаки в поле: :attribute',
        'ss:digits' => 'СНИЛС - 11 цифр без разделителей',
    ]);

    $validation->validate();

    if ($validation->fails()) {
        $messages = $validation->errors()->firstOfAll(':message', true);
        print_r($messages);
    } else {
        echo "Success!";
    }
}

?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
<div class="container mt-4">
    <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="name" class="form-label">Имя:</label>
            <input type="text" class="form-control" name="name" id="name" value=""/>
        </div>

        <div class="mb-3">
            <label for="age" class="form-label">Возраст:</label>
            <input type="number" class="form-control" name="age" id="age" value=""/>
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Телефон:</label>
            <input type="tel" class="form-control" name="phone" id="phone" value=""/>
        </div>

        <div class="mb-3">
            <label for="ss" class="form-label">СНИЛС:</label>
            <input type="text" class="form-control" name="ss" id="ss" value=""/>
        </div>

        <button type="submit" class="btn btn-primary">OK</button>
    </form>
</div>
</body>
</html>
