<?php
//контроллер страниц конкретного товара
class ProductController
{
    //страница товара
    public function actionView($productId)
    {

        $categories = array();
        $categories = Category::getCategoriesList();
        
        $product = Product::getProductById($productId);

        require_once(ROOT . '/views/product/view.php');

        return true;
    }

}
