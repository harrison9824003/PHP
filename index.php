<?php    
    include_once('config.php');
    include_once('autoload.php'); 
    use App\Models\Product;    
    //use App\Models\Category;
    //use App\Models\DI\Product;
    //use App\Models\DI\Category;
    use App\Kernel\Container;

    // 一般使用方式    
    /*$category = new Category();

    $p = new Product($category);
    $p->show(); */

    // 注入方式
    /*$category = new Category();
    
    $p2 = new Product($category);
    $p2->show();*/

    // 容器 ReflectionClass
    $instance_product = Container::autoClassRelfection(Product::class);
    $instance_product->show();
    
?>