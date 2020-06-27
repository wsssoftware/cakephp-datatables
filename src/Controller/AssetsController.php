<?php
declare(strict_types = 1);

namespace DataTables\Controller;

use Cake\Http\Exception\NotFoundException;

/**
 * Class AssetsController
 * Created by allancarvalho in june 26, 2020
 *
 * @property \DataTables\Controller\Component\CssComponent $Css
 * @property \DataTables\Controller\Component\JsComponent $Js
 */
class AssetsController extends AppController {

	/**
	 * @return void
	 */
	public function initialize(): void {
		parent::initialize();
		$this->loadComponent('DataTables.Css');
		$this->loadComponent('DataTables.Js');
	}

	/**
	 * Get the css file.
	 *
	 * @return \Cake\Http\Response
	 */
	public function css() {
		$query = $this->getRequest()->getQuery();
		$body = $this->Css->getFilesBody($query, 'css');

		return $this->getResponse()
					->withCache('-1 minute', '+30 days')
					->withType('text/css;charset=UTF-8')
					->withStringBody($body);
	}

	/**
	 * Get the script file.
	 *
	 * @return \Cake\Http\Response
	 */
	public function script() {
		$query = $this->getRequest()->getQuery();
		$body = $this->Js->getFilesBody($query, 'js');

		return $this->getResponse()
			->withCache('-1 minute', '+30 days')
			->withType('application/javascript')
			->withStringBody($body);
	}

	/**
	 * Get the assets images
	 *
	 * @param string $filename Name of file.
	 * @return \Cake\Http\Response
	 */
	public function images($filename) {
	    $fullFilePath = DATA_TABLES_WWW_ROOT . 'images' . DS . $filename;
		if (!file_exists($fullFilePath)) {
			throw new NotFoundException(sprintf('Image "%s" not found!', $filename));
		}

		return $this->getResponse()
			->withCache('-1 minute', '+30 days')
			->withType(mime_content_type($fullFilePath))
			->withStringBody(file_get_contents($fullFilePath));
	}

}
