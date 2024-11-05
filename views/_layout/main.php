<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= ($title ?? '') . ' ' . $_ENV['SITE_NAME'] ?></title>
    <link rel="stylesheet" href="/css/main.css?v=<?php if ($_ENV['DEV_MODE'] == "true") { echo time(); }; ?>">
</head>
<body>

<?php include BASE_DIR . '/views/_partials/_header.php'; ?>

<main class="flex h-auto">
    <?php include BASE_DIR . '/views/_partials/_navigation.php'; ?>
    <?= $content; ?>
</main>

</body>
</html>
