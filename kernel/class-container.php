<?php 
    namespace App\Kernel;

    Class Container {
        
        public static function autoClassRelfection($className, $params = []) {
            $reflect = new \ReflectionClass($className);

            // 取得構造函數
            $construct = $reflect->getConstructor();

            //print_r($construct);exit;

            $args = [];
            if ( $construct ) {

                $construct_params = $construct->getParameters();
                //print_r($construct_params);exit;

                foreach( $construct_params as $param ) {
                    $class = $param->getClass();
                    //echo $class;exit;
                    if ( $class ) {
                        $args[] = self::autoClassRelfection($class->name);
                    }
                }
            }
            $args = array_merge($args, $params);
            // print_r($params);exit;
            // print_r($args);exit;

            $instance = $reflect->newInstanceArgs($args);

            return $instance;
        }
    }
?>