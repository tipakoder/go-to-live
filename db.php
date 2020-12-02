<?php

class Connection
{
    //Объект работы
    protected $pdo;
    //Текущий сет настроек
    protected $config;
    //Загружаем сет настроек
    public function __construct($config)
    {
        $this->config = ['host' => '127.0.0.1', 'dbname' => "live", 'charset' => 'utf8', 'user' => 'root', 'passwd' => 'root'];
    }
    //Инициализируем
    protected function init()
    {
        //Если объект ещё не назначен
        if(empty($this->pdo))
        {
            //Инициализируем работу объекта
            $dsn = "mysql:host={$this->config['host']};dbname={$this->config['dbname']};charset={$this->config['charset']}";
            $opt = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];
            $this->pdo = new PDO($dsn, $this->config['user'], $this->config['passwd'], $opt);
            //Очищаем сет настроек
            unset($this->config);
        }
    }
    //Запрос с получением ответа
    public function query($query, $args = []){
        //Инициализируем
        $this->init();

        $query_object = $this->pdo->prepare($query);
        $query_object->execute($args);

        return $query_object->fetchAll(PDO::FETCH_NAMED);
    }
    //Запрос записи
    public function execute($query, $args = []){
        //Инициализируем
        $this->init();

        $query_object = $this->pdo->prepare($query);
        $query_object->execute($args);
        //Если запрос к базе выполнен
        if($query_object->rowCount() > 0) {
            return true;
        }
        //Если нет
        return false;
    }
    //Получаем последний ID вставления
    public function lastID(){
        //Инициализируем
        $this->init();

        return $this->pdo->lastInsertId();
    }
}