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
    <div x-data="{ open: false }" class="p-4 max-w-6xl mx-auto">
        <?php include BASE_DIR . '/views/_partials/_header.php'; ?>

        <main class="flex">
            <?php include BASE_DIR . '/views/_partials/_navigation.php'; ?>
            <?= $content ?>
        </main>
    </div>

    <script src="//unpkg.com/alpinejs" defer></script>
    <script>
        const themeController = document.querySelector('.theme-controller');
        const savedTheme = localStorage.getItem('theme') || 'light';

        document.documentElement.setAttribute('data-theme', savedTheme);
        themeController.checked = savedTheme === 'dark';

        themeController.addEventListener('change', () => {
            const theme = themeController.checked ? 'dark' : 'light';
            document.documentElement.setAttribute('data-theme', theme);
            localStorage.setItem('theme', theme);
        });
    </script>   
</body>
</html>
