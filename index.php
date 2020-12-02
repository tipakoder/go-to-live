<?
define('ROOTDR', __DIR__);
require_once 'db.php';
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
            loadPage("login", "Будь здоров — регистрация!");
            break;
        case "reg":
            reg_acc();
            break;
    }
}

function loadPage($name, $title)
{
    $params = [
        'tamplate' => $name,
        'title' => $title
    ];
    extract($params);
    require_once 'res/tamplate.php';
}

function reg_acc()
{
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $middlename = $_POST['middlename'];
    $email = $_POST['email'];
    $password = $_POST['password'];
}