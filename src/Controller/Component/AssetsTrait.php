<?php
/**
 * Copyright (c) Allan Carvalho 2020.
 * Under Mit License
 * link: https://github.com/wsssoftware/cakephp-data-renderer
 * author: Allan Carvalho <allan.m.carvalho@outlook.com>
 * license: MIT License https://github.com/wsssoftware/cakephp-datatables/blob/master/LICENSE
 */
declare(strict_types = 1);

namespace DataTables\Controller\Component;

use Cake\Cache\Cache;
use Cake\Utility\Hash;
use DataTables\Table\Assets;

/**
 * Class AssetsComponent
 * Created by allancarvalho in june 26, 2020
 */
trait AssetsTrait {

	/**
	 * Get files to load.
	 *
	 * @param array $query Request query.
	 * @param string $type If is css or script.
	 * @return string
	 */
	public function getFilesBody(array $query, string $type): string {
		$files = [];
		$md5 = $type . '_' . md5(json_encode($query));
		$body = Cache::read($md5, '_data_tables_assets_');
		if ($body === null) {
			$version = Hash::get($query, 'version', Assets::DEFAULT_VERSION);
			$theme = Hash::get($query, 'theme', Assets::DEFAULT_THEME);
			$this->addFiles($files, $this->_themes[$theme]);
			if (Hash::get($query, 'library', false)) {
				$this->addFiles($files, $this->_libraries[Hash::get($query, 'theme')]);
			}
			if (Hash::get($query, 'jquery', false)) {
				$this->addFiles($files, $this->_libraries[Hash::get($query, 'jquery')]);
			}
			foreach (Hash::get($query, 'plugins', []) as $plugin => $isEnabled) {
				if ($isEnabled) {
					$pluginAssets = $this->_plugins[$plugin];
					foreach ($pluginAssets as $index => $pluginAsset) {
						if (is_numeric($index)) {
							$this->addFiles($files, [$index => $pluginAsset]);
						}
						$this->addFiles($files, $pluginAssets[$theme]);
					}
				}
			}
			$body = $this->getBodies($files, $type, $version);
			Cache::write($md5, $body, '_data_tables_assets_');
		}

		return $body;
	}

	/**
	 * Add files to Array
	 *
	 * @param array $files Files array.
	 * @param array $toAdd Files to add.
	 * @return void
	 */
	protected function addFiles(array &$files, array $toAdd): void {
		$files += $toAdd;
		ksort($files);
	}

	/**
	 * Generate the file body.
	 *
	 * @param array $files Files to put in body.
	 * @param string $type Type of files.
	 * @param string $version Version o DataTables library.
	 * @return string
	 */
	protected function getBodies(array $files, string $type, string $version): string {
		$body = '';
		$basePath = DATA_TABLES_WWW_ROOT . $type . DS . $version . DS;
		foreach ($files as $file) {
			$body .= file_get_contents($basePath . $file);
			if ($type === 'js') {
			    $body .= ';';
			}
			$body .= "\n";
		}

		return $body;
	}

}
