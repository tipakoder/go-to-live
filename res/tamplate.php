<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$title?></title>
    <link href="/res/css/fonts.css" rel="stylesheet">
    <link href="/res/css/style.css" rel="stylesheet">
    <link href="/res/css/elements.css" rel="stylesheet">
    <script src="/res/js/jquery-3.5.1.min.js"></script>
</head>
<body>
    <header>
        <div class="container header-content">
            <?if(!$auth){?>
                <h2 class="header-logo link" href="/">Будь здоров!</h2>
            <?}else{?>
                <h2 class="header-logo link" href="/profile/">Будь здоров!</h2>
            <?}?>
            
            <nav class="header-nav">
                <?if(!$auth){?>
                    <div class="header-nav-item link" href="/login/">Войти</div>
                    <div class="header-nav-item link" href="/reg/">Создать аккаунт</div>
                <?}else{?>
                    <div class="header-nav-item link" href="/write/">Запись на приём</div>
                    <div class="header-nav-item link" href="/profile/">Личный кабинет</div>
                    <div class="header-nav-item link" href="/logout/">Выйти</div>
                <?}?>
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