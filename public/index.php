<?php
require('../vendor/autoload.php');

use Rakit\Validation\Validator;

$old = $err = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $validator = new Validator([
        'required' => 'Обязательное поле: :attribute',
        'numeric' => 'Должно быть числовым: :attribute',
        'min' => 'Не короче :min знаков',
        'max' => 'Не длиннее :max знаков',
    ]);

    $validation = $validator->make($_POST, [
        'name' => 'required|min:3|max:40|regex:/^[А-Яа-яЁё\-\s\']+$/u',
        'age' => 'required|numeric|min:1',
        'phone' => 'required|min:6|max:12',
        'ss' => 'required|regex:/^\d{11}$/',
    ], [
        'name:regex' => 'Некорректные знаки в поле: :attribute',
        'ss:regex' => 'СНИЛС - 11 цифр без разделителей',
    ]);

    $validation->setAliases([
        'name' => 'Имя',
        'age' => 'Возраст',
        'phone' => 'Телефон',
        'ss' => 'СНИЛС',
    ]);

    $validation->validate();

    if ($validation->fails()) {
        $err = $validation->errors()->firstOfAll(':message', true);
        $old = $validation->getValidatedData();
    } else {
        echo "Success!";
    }
}

?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
<div class="container mt-4">
    <form method="post" enctype="application/x-www-form-urlencoded">
        <div class="mb-3">
            <label for="name" class="form-label">Имя:</label>
            <input type="text" id="name" name="name"
                   class="form-control <?= !empty($err['name']) ? 'is-invalid' : '' ?>"
                   value="<?= $old['name'] ?? '' ?>"/>
            <div class="invalid-feedback"><?= $err['name'] ?? '' ?></div>
        </div>

        <div class="mb-3">
            <label for="age" class="form-label">Возраст:</label>
            <input type="number" id="age" name="age"
                   class="form-control <?= !empty($err['age']) ? 'is-invalid' : '' ?>"
                   value="<?= $old['age'] ?? '' ?>"/>
            <div class="invalid-feedback"><?= $err['age'] ?? '' ?></div>
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Телефон:</label>
            <input type="tel" id="phone" name="phone"
                   class="form-control <?= !empty($err['phone']) ? 'is-invalid' : '' ?>"
                   value="<?= $old['phone'] ?? '' ?>"/>
            <div class="invalid-feedback"><?= $err['phone'] ?? '' ?></div>
        </div>

        <div class="mb-3">
            <label for="ss" class="form-label">СНИЛС:</label>
            <input type="text" id="ss" name="ss"
                   class="form-control <?= !empty($err['ss']) ? 'is-invalid' : '' ?>"
                   value="<?= $old['ss'] ?? '' ?>"/>
            <div class="invalid-feedback"><?= $err['ss'] ?? '' ?></div>
        </div>

        <button type="submit" class="btn btn-primary">OK</button>
    </form>
</div>

<script>
    const lst = document.querySelectorAll('.is-invalid');
    for (let i = 0; i < lst.length; i++) {
        lst[i].addEventListener('input', function (e) {
            e.target.classList.remove('is-invalid');
        });
    }
</script>
</body>
</html>
