<?php 
    namespace App\Models;

    Class Category {
        function __construct() {
            echo "Category Class 引入了";
        }

        public function show() {
            echo '顯示 Category';
        }
    }
?>