<?php
//контроллер корзины
class CartController
{

    //получает в аргумент id товара, добавляет его в корзину 
    public function actionAddAjax($id)
    {
        echo Cart::addProduct($id);
        return true;
    }

    //получает в аргумент id товара, удаляет его из корзины 
    public function actionDelete($id)
    {
        Cart::deleteProduct($id);
        header("Location: /cart/");
    }
    
    //страница корзины
    public function actionIndex()
    {
        $categories = array();
        $categories = Category::getCategoriesList();

        $productsInCart = false;

        $productsInCart = Cart::getProducts();

        if ($productsInCart) {
            $productsIds = array_keys($productsInCart);
            $products = Product::getProdustsByIds($productsIds);

            $totalPrice = Cart::getTotalPrice($products);
        }

        require_once(ROOT . '/views/cart/index.php');

        return true;
    }
    
    //страница оформление заказа
    public function actionCheckout()
    {

        //категории
        $categories = array();
        $categories = Category::getCategoriesList();


        // статус успешного оформления заказа
        $result = false;


        // если форма заполнена
        if (isset($_POST['submit'])) {
            //получаем данные из формы
            $userName = $_POST['userName'];
            $userPhone = $_POST['userPhone'];
            $userComment = $_POST['userComment'];

            //проверка на ошибки заполнения формы
            $errors = false;
            if (!User::checkName($userName))
                $errors[] = 'Неправильно введено имя';
            if (!User::checkPhone($userPhone))
                $errors[] = 'Неправильно введен номер телефона';

            //если ошибок нет
            if ($errors == false) {
                //получаем продукты из корзины
                $productsInCart = Cart::getProducts();
                if (User::isGuest()) {
                    $userId = false;
                } else {
                    $userId = User::checkLogged();
                }

                //записываем в бд заказ (имя пользователя, телефон, комментарий
                //id пользователя, заказанные товары
                $result = Order::save($userName, $userPhone, $userComment, $userId, $productsInCart);

                if ($result) {
                    //отправляет уведомление о заказе на почту администратора магазина
                    //НЕ РАБОТАЕТ НА ЛОКАЛЬНОМ СЕРВЕРЕ (mail не работает)
                    $adminEmail = 'mitya.lebed@gmail.ru';
                    $message = 'http://site.com/admin/orders';
                    $subject = 'Заказ';
                    mail($adminEmail, $subject, $message);

                    //очищаем корзину
                    Cart::clear();
                }
            } else {
                // Р¤РѕСЂРјР° Р·Р°РїРѕР»РЅРµРЅР° РєРѕСЂСЂРµРєС‚РЅРѕ? - РќРµС‚
                // Р�С‚РѕРіРё: РѕР±С‰Р°СЏ СЃС‚РѕРёРјРѕСЃС‚СЊ, РєРѕР»РёС‡РµСЃС‚РІРѕ С‚РѕРІР°СЂРѕРІ
                $productsInCart = Cart::getProducts();
                $productsIds = array_keys($productsInCart);
                $products = Product::getProdustsByIds($productsIds);
                $totalPrice = Cart::getTotalPrice($products);
                $totalQuantity = Cart::countItems();
            }
        } else {
            //если форма не отправлена    
            $productsInCart = Cart::getProducts();

            // если товаров в корзине нет
            if ($productsInCart == false) {
                // перенаправляем на главную‹
                header("Location: /");
            } else {
                // получаем данные о товарах в корзине
                $productsIds = array_keys($productsInCart);
                $products = Product::getProdustsByIds($productsIds);
                $totalPrice = Cart::getTotalPrice($products);
                $totalQuantity = Cart::countItems();


                $userName = false;
                $userPhone = false;
                $userComment = false;

                // если пользователь не гость
                if (!User::isGuest()) {
                    // получаем данные о нем
                    $userId = User::checkLogged();
                    $user = User::getUserById($userId);
                    // передаем в $userName имя пользователя, чтобы передать его
                    //в форму
                    $userName = $user['name'];
                }
            }
        }

        require_once(ROOT . '/views/cart/checkout.php');

        return true;
    }
}