<?php 
    namespace App\Models\DI;

    Class Product {
        public $category;
        function __construct(Category $category) {

            echo 'Class Product DI 引入了';
            $this->category = $category;
            
        }

        public function show() {
            
            echo '顯示 Product DI';
            echo ' 同時' ;
            $this->category->show();

        }
    }
?>