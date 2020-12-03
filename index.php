<?
//описываем директиву для дальнейших require
define('ROOTDR', __DIR__);
//подключения базы данных
require_once 'db.php';
//определение текущей страницы
$curReq = trim($_SERVER['REQUEST_URI'], '/');
$curReqMethod = $_SERVER['REQUEST_METHOD'];
if($curReqMethod == "GET")
{
    switch($curReq)
    {
        case "":
            loadPage("main", 'Будь здоров!');
            break;
        case "login":
            loadPage("login", "Будь здоров — авторизация!");
            break;
        case "reg":
            loadPage("reg", "Будь здоров — регистрация!");
            break;
    }
} 
else if($curReqMethod == "POST")
{
    switch($curReq)
    {
        case "login":
            login_acc();
            break;
        case "reg":
            reg_acc();
            break;
    }
}
//загрузка страницы
function loadPage($name, $title)
{
    $params = [
        'tamplate' => $name,
        'title' => $title
    ];
    extract($params);
    require_once 'res/tamplate.php';
}
//регистрация аккаунта
function reg_acc()
{
    if(get_cclient() != null)
    {
        exit('Вы уже авторизованы!');
    }

    //определяем переменные, прешедшие в POST
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $middlename = $_POST['middlename'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $photo = $_FILES['photo'];
    $errors = [];
    //создаём непрерывное подключение к базе
    $db = new Connection();
    //проверяем уникальность email
    if($db->query('SELECT id FROM accs WHERE email = ? LIMIT 1', [$email]) != null)
    {
        $errors[] = 'Пользователь с таким Email уже существует!';
    }  
    //размер фото до 1мб
    if(filesize($photo['tmp_name']) > 1024*1024)
    {
        $errors[] = 'Размер фото превышает 1 мб!';
    }
    //если ошибок нет
    if($errors == [])
    {
        //хэшируем пароль
        $password = password_hash($password, PASSWORD_DEFAULT);
        //записываем нового клиента в базу
        if($db->execute('INSERT INTO accs (firstname, lastname, middlename, email, password) VALUES (?, ?, ?, ?, ?)', [$firstname, $lastname, $middlename, $email, $password]))
        {
            //получаем ID нового клиента
            $nId = $db->lastID();
            //определяем расположение его аватарки
            $photo_filename = ROOTDR.'/content/ava_'.$nId.'.png';
            //загружаем аватарку
            if (move_uploaded_file($photo['tmp_name'], $photo_filename)) 
            {
                //создаём сессию
                if(gen_session($nId, $db))
                {
                    exit('success');
                }
            } 
            else 
            {
                $errors[] = "Возможная атака с помощью файловой загрузки!\n";
            }
        }
    }

    echo $errors[0];
    exit();
}
//войти в аккаунт
function login_acc()
{
    if(get_cclient() != null)
    {
        exit('ERROR: Вы уже авторизованы!');
    }
    //определяем переменные, прешедшие в POST
    $email = $_POST['email'];
    $password = $_POST['password'];
    $errors = [];
    //создаём непрерывное подключение к базе
    $db = new Connection();
    //ищем аккаунт с введённым email
    if( ($acc = $db->query('SELECT id, password FROM accs WHERE email = ? LIMIT 1', [$email])[0]) != null)
    {
        if(password_verify($password, $acc['password']))
        {
            //создаём сессию
            if(gen_session($acc['id'], $db))
            {
                exit('success');
            }
        }
        else
        {
            $errors[] = 'ERROR: Неверный пароль!';
        }
    }
    else
    {
        $errors[] = 'ERROR: Пользователь с таким Email уже существует!';
    }

    echo $errors[0];
    exit();
}
//создание сессии
function gen_session($id, $db)
{
    $key = hash('ripemd160', time() . $id . rand_str());
    $ip = $_SERVER['REMOTE_ADDR'];
    if($db->execute('INSERT INTO accs_sess (aid, key_sess, ip) VALUES (?, ?, ?)', [$id, $key, $ip]))
    {
        setcookie('session', $key, time() + 3600 * 24 * 7, '/');
        return true;
    }
    else
    {
        exit('ERROR: Неизвестная ошибка БД.');
    }
}
//отменить сессию
function rem_session()
{
    setcookie('session', null, time() - 3600, '/');
}
//получение текущего клиента
function get_cclient()
{
    $gu = null;
    if(isset($_COOKIE['session']))
    {
        $key_sess = $_COOKIE['session'];
        if(( $do_ = $db->query('SELECT 
        a.id as id,
        a.firstname as firstname,
        a.lastname as lastname,
        a.middlename as middlename,
        a.email as email
        FROM accs a, accs_sess s
        WHERE a.id = s.aid AND
        s.key_sess = ?
        LIMIT 1', [$key_sess])[0]) != null)
        {
            $gu = $do_;
        }
    }
    return $gu;
}
//вспомогательная функция генирации случайных строк
function rand_str($count = 8)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randstring = '';
    for ($i = 0; $i < $count; $i++) {
        $randstring = $characters[rand(0, strlen($characters))];
    }
    return $randstring;
}