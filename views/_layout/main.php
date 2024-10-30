<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= ($title ?? '') . ' ' . $_ENV['SITE_NAME'] ?></title>
    <link rel="stylesheet" href="/css/main.css?v=<?php if ($_ENV['DEV_MODE'] == "true") { echo time(); }; ?>">
</head>
<body class="flex w-full min-h-screen">

<?php include BASE_DIR . '/views/_partials/navigation.php'; ?>

<main class="flex flex-col relative w-full overflow-x-hidden">
    <?php include BASE_DIR . '/views/_partials/header.php'; ?>
    <div class="p-6">
        <?= $content; ?>
    </div>
</main>

</body>
</html>
