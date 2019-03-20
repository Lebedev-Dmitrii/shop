<?php

//класс товар
class Product
{

    //количество показываемых товаров на странице категории
    const SHOW_BY_DEFAULT = 6;

    //получает последние товары
    //аргументы - кол-во товаров на странице, номер страницы
    //возвращает массив товаров
    public static function getLatestProducts($count = self::SHOW_BY_DEFAULT, $page = 1)
    {
        $count = intval($count);
        $page = intval($page);
        //смещение для бд
        $offset = ($page-1) * $count;
        
        $db = Db::getConnection();
        $productsList = array();

        $result = $db->query('SELECT id, name, price, image, is_new, availability FROM product '
                . 'WHERE status = "1"'
                . 'ORDER BY id DESC '                
                . 'LIMIT ' . $count
                . ' OFFSET '. $offset);

        $i = 0;
        while ($row = $result->fetch()) {
            $productsList[$i]['id'] = $row['id'];
            $productsList[$i]['name'] = $row['name'];
            $productsList[$i]['image'] = $row['image'];
            $productsList[$i]['price'] = $row['price'];
            $productsList[$i]['is_new'] = $row['is_new'];
            $productsList[$i]['availability'] = $row['availability'];
            $i++;
        }

        return $productsList;
    }
    
    //получает товары из категории
    //аргументы - id категории, номер страницы
    //возвращает массив товаров (списком)
    public static function getProductsListByCategory($categoryId = false, $page = 1)
    {
        if ($categoryId) {
            
            $page = intval($page);  
            //смещения для бд
            $offset = ($page - 1) * self::SHOW_BY_DEFAULT;
        
            $db = Db::getConnection();            
            $products = array();
            $result = $db->query("SELECT id, name, price, image, is_new, availability FROM product "
                    . "WHERE status = '1' AND category_id = '$categoryId' "
                    . "ORDER BY id ASC "                
                    . "LIMIT ".self::SHOW_BY_DEFAULT
                    . ' OFFSET '. $offset);

            $i = 0;
            while ($row = $result->fetch()) {
                $products[$i]['id'] = $row['id'];
                $products[$i]['name'] = $row['name'];
                $products[$i]['image'] = $row['image'];
                $products[$i]['price'] = $row['price'];
                $products[$i]['is_new'] = $row['is_new'];
                $products[$i]['availability'] = $row['availability'];
                $i++;
            }

            return $products;       
        }
    }
    
    
    //получает товар по id
    //аргумент - id товара
    //возвращает данные о товаре
    public static function getProductById($id)
    {
        $id = intval($id);

        if ($id) {                        
            $db = Db::getConnection();
            
            $result = $db->query('SELECT * FROM product WHERE id=' . $id);
            $result->setFetchMode(PDO::FETCH_ASSOC);
            
            return $result->fetch();
        }
    }
    
    //получает кол-во продуктов в категории
    //аргумент - id категории
    //возвращает кол-во продуктов 
    public static function getTotalProductsInCategory($categoryId)
    {
        $db = Db::getConnection();

        $result = $db->query('SELECT count(id) AS count FROM product '
                . 'WHERE status="1" AND category_id ="'.$categoryId.'"');
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $row = $result->fetch();

        return $row['count'];
    }

    //получает товары по их id
    //аргумент - массив id
    //возвращает массив продуктов
    public static function getProdustsByIds($idsArray)
    {
        $products = array();
        
        $db = Db::getConnection();
        
        $idsString = implode(',', $idsArray);

        $sql = "SELECT * FROM product WHERE status='1' AND id IN ($idsString)";

        $result = $db->query($sql);        
        $result->setFetchMode(PDO::FETCH_ASSOC);
        
        $i = 0;
        while ($row = $result->fetch()) {
            $products[$i]['id'] = $row['id'];
            $products[$i]['code'] = $row['code'];
            $products[$i]['name'] = $row['name'];
            $products[$i]['price'] = $row['price'];
            $products[$i]['availability'] = $row['availability'];
            $i++;
        }

        return $products;
    }
    

    
    //получает рекомендованные товары
    //возвращает массив товаров (списком)
    public static function getRecommendedProducts()
    {
        $db = Db::getConnection();

        $productsList = array();

        $result = $db->query('SELECT id, name, price, image, is_new, availability FROM product '
                . 'WHERE status = "1" AND is_recommended = "1"'
                . 'ORDER BY id DESC ');

        $i = 0;
        while ($row = $result->fetch()) {
            $productsList[$i]['id'] = $row['id'];
            $productsList[$i]['name'] = $row['name'];
            $productsList[$i]['image'] = $row['image'];
            $productsList[$i]['price'] = $row['price'];
            $productsList[$i]['is_new'] = $row['is_new'];
            $productsList[$i]['availability'] = $row['availability'];
            $i++;
        }

        return $productsList;
    }
    
     //получает путь к изображению
    //аргумент - id товара
    //возвращает путь к изображению (строка)
    public static function getImage($id)
    {
        $noImage = 'no-image.jpg';
        $path = '/template/images/home/product';
        //путь к изображению товара
        $pathToProductImage = $path . $id . '.jpg';
        if (file_exists($_SERVER['DOCUMENT_ROOT'].$pathToProductImage)) {
            return $pathToProductImage;
        }
        //возвращаем путь изображения-пустышки
        return '/template/images/home/' . $noImage;
    }

}