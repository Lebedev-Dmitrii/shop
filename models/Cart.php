<?php
//класс корзина
class Cart
{

    //добавление товара в корзину, аргумент - id товара
    public static function addProduct($id)
    {
        $id = intval($id);

        $productsInCart = array();

        //если в корзине есть товары
        if (isset($_SESSION['products'])) {
            $productsInCart = $_SESSION['products'];
        }

        //если товар с таким id уже есть, увеличиваем его кол-во на 1
        if (array_key_exists($id, $productsInCart)) {
            $productsInCart[$id] ++;
        } else {
            //ставим его кол-во = 1
            $productsInCart[$id] = 1;
        }
        
        //загружаем в сессию данные о продуктах в корзине
        $_SESSION['products'] = $productsInCart;

        return self::countItems();
    }
    
    //удаление товара из корзины, аргумент- id товара
    public static function deleteProduct($id)
    {
        $id = intval($id);
        
        $productsInCart = array();
        
        $productsInCart = $_SESSION['products'];
        
        //если товар с таким id один, то удаляем все товары с таким id
        if ($productsInCart[$id]==1)
        {
            unset($productsInCart[$id]);
        } 
        //уменьшаем кол-во товаров с таким id на 1
        else
        {
            $productsInCart[$id]--;
        }
        
        //загружаем в сессию данные о товарах в корзине
        $_SESSION['products'] = $productsInCart;
        
        return self::countItems();
    }

    //считает кол-во товаров в корзине, возвращает их число
    public static function countItems()
    {
        if (isset($_SESSION['products'])) {
            $count = 0;
            foreach ($_SESSION['products'] as $id => $quantity) {
                $count = $count + $quantity;
            }
            return $count;
        } else {
            return 0;
        }
    }

    //получает данные о товарах в корзине из сессии, возвращает их массив
    public static function getProducts()
    {
        if (isset($_SESSION['products'])) {
            return $_SESSION['products'];
        }
        return false;
    }

    //считает общую цену товаров в корзине, возвращает ее
    public static function getTotalPrice($products)
    {
        $productsInCart = self::getProducts();

        $total = 0;
        
        if ($productsInCart) {            
            foreach ($products as $item) {
                $total += $item['price'] * $productsInCart[$item['id']];
            }
        }

        return $total;
    }
    
    //очищает корзину
    public static function clear()
    {
        if(isset($_SESSION['products']))
        {
            unset($_SESSION['products']);
        }
    }

}
