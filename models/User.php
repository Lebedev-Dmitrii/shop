<?php

//класс пользователь
class User
{

    //регистрация пользователя
    //аргументы - имя, email, пароль
    //возвращает результат выполнения (boolean)
    public static function register($name, $email, $password)
    {

        $db = Db::getConnection();

        $sql = 'INSERT INTO user (name, email, password) '
                . 'VALUES (:name, :email, :password)';

        $result = $db->prepare($sql);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->bindParam(':password', $password, PDO::PARAM_STR);

        $result->execute();
        return $result->fetch();
    }

    //редактирование данных пользователя
    //аргументы - id, имя, пароль
    //возвращает результат выполнения (boolean)
    public static function edit($id, $name, $password)
    {
        $db = Db::getConnection();
        
        $sql = "UPDATE user 
            SET name = :name, password = :password 
            WHERE id = :id";
        
        $result = $db->prepare($sql);                                  
        $result->bindParam(':id', $id, PDO::PARAM_INT);       
        $result->bindParam(':name', $name, PDO::PARAM_STR);    
        $result->bindParam(':password', $password, PDO::PARAM_STR); 
        return $result->execute();
    }

    //проверка, существует ли пользователь с данным email и паролем
    //аргументы - email, пароль
    //возвращает id пользователя или false в случае, если такого пользователя нет
    public static function checkUserData($email, $password)
    {
        $db = Db::getConnection();
 
        $result = $db->query('SELECT * FROM user WHERE email = "'
                . $email
                .'" AND password = "'
                . $password
                .'"');
        
        if ($result) {
            $user=$result->fetch();
            return $user['id'];
        }

        return false;
    }

    //аутентификация пользователя - записываем в сессию его id
    //аргумент- id пользователя
    public static function auth($userId)
    {
        $_SESSION['user'] = $userId;
    }

    //проверка, залогинен ли пользователь
    //возвращает id пользователя или перенаправляет на страницу
    //авторизации, если пользователь не залогинен
    public static function checkLogged()
    {
        if (isset($_SESSION['user'])) {
            return $_SESSION['user'];
        }

        header("Location: /user/login");
    }

    //проверка, гость ли пользователь
    //возвращает true, если гость, false иначе
    public static function isGuest()
    {
        if (isset($_SESSION['user'])) {
            return false;
        }
        return true;
    }

    //проверка имени
    public static function checkName($name)
    {
        if (strlen($name) >= 2) {
            return true;
        }
        return false;
    }

    //проверка пароля
    public static function checkPassword($password)
    {
        if (strlen($password) >= 6) {
            return true;
        }
        return false;
    }

    //проверка email
    public static function checkEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }

    //проверка, существует ли пользователь с данным email
    public static function checkEmailExists($email)
    {

        $db = Db::getConnection();

        $sql = 'SELECT COUNT(*) FROM user WHERE email = :email';

        $result = $db->prepare($sql);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->execute();

        if ($result->fetchColumn())
            return true;
        return false;
    }
    
    //проверка телефона
    public static function checkPhone($phone)
    {
        if (strlen($phone) >= 10) {
            return true;
        }
        return false;
    }

    //получает данные о пользователе по id
    //аргумент - id пользователя
    //возвращает массив с данными пользователя
    public static function getUserById($id)
    {
        if ($id) {
            $db = Db::getConnection();
            $sql = 'SELECT * FROM user WHERE id = :id';

            $result = $db->prepare($sql);
            $result->bindParam(':id', $id, PDO::PARAM_INT);

            // Указываем, что хотим получить данные в виде массива
            $result->setFetchMode(PDO::FETCH_ASSOC);
            $result->execute();


            return $result->fetch();
        }
    }

}
