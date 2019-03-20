<?php
//контроллер пользователя - регистрация, авторизация, выход из аккаунта 
class UserController
{
    //страница регистрации пользователя
    public function actionRegister()
    {
        $name = '';
        $email = '';
        $password = '';
        $result = false;
        
        //если форма заполнена
        if (isset($_POST['submit'])) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            
            $errors = false;
            
            //проверка имени пользователя
            if (!User::checkName($name)) {
                $errors[] = 'Имя не должно быть короче 2-х символов';
            }
            
            //проверка emaila пользователя
            if (!User::checkEmail($email)) {
                $errors[] = 'Неправильный email';
            }
            
            //проверка пароля пользователя
            if (!User::checkPassword($password)) {
                $errors[] = 'Пароль не должен быть короче 6-ти символов';
            }
            
            //проверка emaila пользователя (уже используется)
            if (User::checkEmailExists($email)) {
                $errors[] = 'Такой email уже используется';
            }
            
            //ошибок нет - регистрируем
            if ($errors == false) {
                $result = User::register($name, $email, $password);
                User::auth($result);
                $result=1;
            }

        }

        require_once(ROOT . '/views/user/register.php');

        return true;
    }

    //страница авторизации пользователя
    public function actionLogin()
    {
        $email = '';
        $password = '';
        
        //если форма заполнена
        if (isset($_POST['submit'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];
            
            $errors = false;
                        
            // 
            if (!User::checkEmail($email)) {
                $errors[] = 'Неправильный email';
            }            
            if (!User::checkPassword($password)) {
                $errors[] = 'Пароль не должен быть короче 6-ти символов';
            }
            
            //проверяем существует ли пользователь
            $userId = User::checkUserData($email, $password);
            
            if ($userId == false) {
                // Если данные неправильные - показываем ошибку
                $errors[] = 'Неправильные данные для входа на сайт';
            } else {
                //если данные правильные, запоминаем пользователя (сессия)
                User::auth($userId);
                
                //перенаправляем пользователя в закрытую часть - кабинет 
                header("Location: /cabinet/");
            }

        }

        require_once(ROOT . '/views/user/login.php');

        return true;
    }
    
    //удаляет данные о пользователе из сессии
    public function actionLogout()
    {
        session_destroy();
        header("Location: /");
    }
}
