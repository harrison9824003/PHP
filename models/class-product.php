<?php 
    namespace App\Models;
    use App\Models\Category;

    Class Product {
        public $category;
        function __construct() {
            echo 'Class Product 引入了';
            $this->category = new Category();
        }

        public function show() {
            
            echo '顯示 Product';
            echo ' 同時' ;
            $this->category->show();
        }
    }
?>