<?php

use zabachok\pluto\doc\generator\form\Generator;

/**
 * @var $generator Generator
 */
?>
# [<?= $generator->title ?>](<?= $generator->getFileName() ?>.md)

Отправляем **<?= $generator->method ?>** на **<?= $generator->url ?>**

### Параметры:

<?= $generator->gridRenderer->render() ?>
<?= $generator->enumsRenderer->render() ?>

### Положительный ответ:

```json
{
    "code": 1,
    "data": {

    }
}
```
<?php if ($generator->method == 'GET'): ?>

### Системная ошибка:

```json
{
    "code": 0,
    "message": "System error"
}
```

<?php else: ?>

### Ошибка валидации:

```json
{
    "code": 2,
    "fields": {
        <?php
        $fields = $generator->gridRenderer->getAttributes();
        $fields = array_map(function ($attribute) {
            return '"' . $attribute . '" : "Ошибка валидации поля"';
        }, $fields);
        echo implode(",\r\n        ", $fields);
        ?>

    }
}
```

<?php endif; ?>
