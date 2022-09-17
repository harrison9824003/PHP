<?php 
	/**
	* 判斷 namespace 第一個位置找尋對應的資料
	* e.g. App\Models\Product/{Class name} -> /app/Models/Product/{Class name}
	*/	
	
	/**
	 * auto loader function
	 * @param string $resource 要引入檔案的 namespace
	 */
	function autoloader( $resource = '' ) {
		
		// 最後組成的路徑
		$resource_path = false; 

		// 根目錄
		$namespace_root = 'App\\';
		
		// 移除首尾 \, 檢查傳進的路徑是否正確
		$resource = trim( $resource, '\\' );
		if ( empty($resource) || strpos( $resource, '\\' ) === false || strpos( $resource, $namespace_root ) !== 0 ) {
			// 不引入檔案
			return;
		}

		// 移除路徑根目錄
		$resource = str_replace( $namespace_root, '', $resource);

		// 將路徑大寫轉成小寫
		// 修改路徑中 _ 轉成 -
		$paths = explode( '\\', str_replace( '_', '-', strtolower( $resource ) ) );

		// 判斷路徑是否為空直
		if ( empty( $paths[0] ) || empty( $paths[1] ) ) {
			return;
		}
		
		$cnt_paths = count($paths);
		global $include_paths;
		
		// 檢查是否包含不是預設路徑的內容
		for ( $i = 0 ; $i < $cnt_paths - 1 ; $i++ ) {
			if ( !in_array($paths[$i], $include_paths) ) {
				return;
			}
		}
		
		// 處理檔案名稱並組合
		// 規則: 以 class-{名稱} 命名 Class
		$file = array_pop($paths);
		$file = 'class-'.$file;

		$implode_path = implode('/', $paths);
		$resource_path = sprintf('%s/%s.php', $implode_path, $file);
				
		// 參考 wordpress validate_file() 檢查路徑
		if ( '../' === $resource_path ) return;
		
		if ( preg_match_all('#\.\./#', $resource_path, $matches, PREG_SET_ORDER ) && ( count($matches) > 1 ) ) {
			return;
		}
		
		if( false !== strpos( $resource_path, '../') && '../' !== mb_substr( $resource_path, -3, 3) ) {
			return;
		}
		
		if ( false !== strpos( $resource_path, ':' ) ) return;
		
		if ( !empty($resource_path) && file_exists($resource_path) ) {	
			
			require_once( $resource_path );
		} else {
			return;
		}
		
	}

	spl_autoload_register('autoloader');
?>