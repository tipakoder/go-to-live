<?
//описываем директиву для дальнейших require
define('ROOTDR', __DIR__);
//подключаем класс для работы с базой по средствам PDO
require_once 'db.php';
//создаём непрерывное подключение к базе
$db = new Connection();
//определение текущей страницы
$curReq = trim($_SERVER['REQUEST_URI'], '/');
$curReqMethod = $_SERVER['REQUEST_METHOD'];
if($curReqMethod == "GET")
{
    $u_verify = get_cclient();
    if($u_verify == null)
    {
        switch($curReq)
        {
            case "":
                main_page();
                break;
            case "login":
                loadPage("login", "Будь здоров — авторизация!");
                break;
            case "reg":
                loadPage("reg", "Будь здоров — регистрация!");
                break;
        }
    }
    else if($u_verify != null)
    {
        if($u_verify['who'] == 'user')
        {
            switch($curReq)
            {
                case "write":
                    write_page();
                    break;
                case "profile":
                    loadProfile();
                    break;
                case "logout":
                    rem_session();
                    break;
            }
        }
        else
        {
            switch($curReq)
            {
                case "logout":
                    rem_session();
                    break;
                case "admin":
                    admin_main();
                    break;
                case "doctor/new":
                    doctor_add_page();
                    break;
            }
        }
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
        case "doctor/new":
            doctor_add();
            break;
        case "write/timeoption":
            write_timeoption();
            break;
        case "write":
            write_proccess();
            break;
        case "write/cancel":
            write_cancel();
            break;
    }
}
//загрузка страницы
function loadPage($name, $title, $data = [])
{
    $params = [
        'tamplate' => $name,
        'title' => $title,
        'auth' => get_cclient() != null
    ];
    if($data != [])
    {
        $params = array_merge($params, $data);
    }
    extract($params);
    require_once 'res/tamplate.php';
}
//регистрация аккаунта
function reg_acc()
{
    global $db;
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
                if(gen_session($nId))
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
    global $db;

    if(get_cclient() != null)
    {
        exit('ERROR: Вы уже авторизованы!');
    }
    //определяем переменные, прешедшие в POST
    $email = $_POST['email'];
    $password = $_POST['password'];
    $errors = [];
    //ищем аккаунт с введённым email
    if( ($acc = $db->query('SELECT id, password, who FROM accs WHERE email = ? LIMIT 1', [$email])[0]) != null)
    {
        if(password_verify($password, $acc['password']))
        {
            //создаём сессию
            if(gen_session($acc['id']))
            {
                if($acc['who'] == 'user')
                {
                    exit('success');
                }
                else
                {
                    exit('success1');
                }
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
function gen_session($id)
{
    global $db;

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
    header('Location: /');
    exit();
}
//получение текущего клиента
function get_cclient()
{
    global $db;

    $gu = null;
    if(isset($_COOKIE['session']))
    {
        $key_sess = $_COOKIE['session'];
        if(( $do_ = $db->query('SELECT 
        a.id as id,
        a.firstname as firstname,
        a.lastname as lastname,
        a.middlename as middlename,
        a.email as email,
        a.who as who
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
        $randstring.= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randstring;
}
//загрузка страницы профиля пользователя
function loadProfile()
{
    global $db;
    $user_data = get_cclient();
    if($user_data == null)
    {
        exit('Сессия недействительна');
    }
    $writes = array_reverse($db->query('SELECT w.id as id, w.date as date, w.option_time as option_time, d.fullname as doctor FROM writes w, doctor d WHERE w.aid = ? AND d.id = w.did AND w.remove = 0', [$user_data['id']]));
    loadPage('profile', 'Будь здоров — личный кабинет', ['user' => $user_data, 'writes' => $writes]);
}
//загрузка страниц админа
function loadAdminPage($name, $title, $data = [])
{
    if(get_cclient()['who'] != 'admin')
    {
        exit('У Вас недостаточно прав!');
    }
    $params = [
        'tamplate' => $name,
        'title' => $title
    ];
    if($data != [])
    {
        $params = array_merge($params, $data);
    }
    extract($params);
    require_once 'res/tamplate_admin.php';
}
//страница добавления нового специалиста
function doctor_add_page()
{
    global $db;
    $types = $db->query('SELECT * FROM doctor_types');
    $data = ['types' => $types];
    loadAdminPage('doctor_add_admin', 'Будь здоров — добавление врача!', $data);
}
//добавление нового специалиста
function doctor_add()
{
    global $db;

    if(get_cclient()['who'] != 'admin')
    {
        exit('У Вас недостаточно прав!');
    }

    $fullname = $_POST['fullname'];
    $type = $_POST['type'];

    switch($type)
    {
        case "1":
            $type = 1;
            break;
        case "2":
            $type = 2;
            break;
        case "3":
            $type = 3;
            break;
        case "4":
            $type = 4;
            break;
        default:
            $type = null;
            break;
    }

    if($type != null)
    {
        if($db->execute('INSERT INTO doctor (tid, fullname) VALUES (?, ?)', [$type, $fullname]))
        {
            exit('success');
        }   
        else
        {
            exit('Неизвестная ошибка!');
        }
    }
    else
    {
        exit('Выбранный тип недействителен!');
    }
}
//главная страница админа
function admin_main()
{
    global $db;

    if(get_cclient()['who'] != 'admin')
    {
        exit('У Вас недостаточно прав!');
    }

    $doctors = $db->query('SELECT d.id as id, d.fullname as fullname, dt.name as type FROM doctor d, doctor_types dt WHERE dt.id = d.tid');
    loadAdminPage('main_admin', 'Будь здоров — панель админа!', ['doctors' => $doctors]);
}
//страница записи на приём
function write_page()
{
    global $db;
    $types = $db->query('SELECT * FROM doctor_types');
    $doctors = $db->query('SELECT * FROM doctor');
    $data = ['types' => $types, 'doctors' => $doctors];
    loadPage('write', 'Будь здоров — запись на приём', $data);
}
//главная страница со списком специалистов
function main_page()
{
    global $db;
    $types = $db->query('SELECT * FROM doctor_types');
    loadPage("main", 'Будь здоров!', ['types' => $types]);
}
//определение свободных ячеек записи для каждого врача
function write_timeoption()
{
    global $db;
    $date = $_POST['date'];
    $did = $_POST['did'];
    $writes = $db->query('SELECT * FROM writes WHERE date = ? AND did = ?', [$date, $did]);
    $free = [1, 2, 3, 4, 5];
    foreach($writes as $write)
    {
        foreach($free as $key => $f)
        {
            if($write['option_time'] == $f)
            {
                unset($free[$key]);
            }
        }
        
    }
    echo json_encode($free);
}
//запись на приём
function write_proccess()
{
    global $db;
    if(($aid = get_cclient()['id']) == null)
    {
        exit('Вы не авторизованы!');
    }
    $date = $_POST['date'];
    $did = $_POST['doctor'];
    $option_time = $_POST['option_time'];

    if($db->execute('INSERT INTO writes (aid, date, option_time, did) VALUES (?, ?, ?, ?)', [$aid, $date, $option_time, $did]))
    {
        exit('success');
    }
    else
    {
        exit('Неизвестная ошибка!');
    }
}
//отмена записи
function write_cancel()
{
    global $db;
    $wid = $_POST['wid'];
    if($db->execute('UPDATE writes SET remove = 1 WHERE id = ? LIMIT 1', [$wid]))
    {
        exit('success');
    }
    else
    {
        exit('Неизвестная ошибка');
    }
}