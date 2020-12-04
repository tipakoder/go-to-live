<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$title?></title>
    <link href="/res/img/logo.ico" rel="shortcut icon">
    <link href="/res/css/fonts.css" rel="stylesheet">
    <link href="/res/css/style.css" rel="stylesheet">
    <link href="/res/css/elements.css" rel="stylesheet">
    <script src="/res/js/jquery-3.5.1.min.js"></script>
</head>
<body>
    <header>
        <div class="container header-content">
            <div class="header-logo link" href="/admin/">
                <img src="/res/img/logotype.png" alt="" class="header-logo-image">
                <h2 class="header-logo-text">Панель управления</h2>
            </div>

            <nav class="header-nav">
                <div class="header-nav-item link" href="/doctor/new/">Добавить врача</div>
                <div class="header-nav-item link" href="/logout/">Выйти</div>
            </nav>
        </div>
    </header>
    <main>
        <div class="container">
            <? require_once ROOTDR . '/pages/'.$tamplate.'.php'; ?>
        </div>
    </main>

    <script src="/res/js/main.js"></script>
</body>
</html>