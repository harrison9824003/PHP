<?php 
    namespace App\Models\DI;

    Class Category {
        function __construct() {
            echo "Category DI Class 引入了";
        }

        public function show() {
            echo '顯示 Category DI';
        }
    }
?>