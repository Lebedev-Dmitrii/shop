<?php
//контроллер главной страницы
class SiteController
{
    // главная страница
    public function actionIndex()
    {
        $categories = array();
        $categories = Category::getCategoriesList();

        $latestProducts = array();
        $latestProducts = Product::getLatestProducts();
        
        // Список товаров для слайдера
        $sliderProducts = Product::getRecommendedProducts();
        
        require_once(ROOT . '/views/site/index.php');

        return true;
    }
    
    //страница связи с администратором
    public function actionContact() {
                
        $userEmail = '';
        $userText = '';
        $result = false;
        
        //если форма заполнена
        if (isset($_POST['submit'])) {
            
            $userEmail = $_POST['userEmail'];
            $userText = $_POST['userText'];
    
            $errors = false;
                        
            // проверка e-mail
            if (!User::checkEmail($userEmail)) {
                $errors[] = 'Неправильный email';
            }
            
            //ошибок нет - посылаем письмо администратору
            //НЕ РАБОТАЕТ НА ЛОКАЛЬНОМ СЕРВЕРЕ (не работает mail)
            if ($errors == false) {
                $adminEmail = 'mitya.lebed@gmail.ru';
                $message = "Текст: {$userText}. От‚ {$userEmail}";
                $subject = 'Тема письма';    
                $result = mail($adminEmail, $subject, $message);
                $result = true;
            }

        }
        
        require_once(ROOT . '/views/site/contact.php');
        
        return true;
    }

}
