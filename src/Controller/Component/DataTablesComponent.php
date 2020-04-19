<?php
declare(strict_types = 1);

namespace DataTables\Controller\Component;

use Cake\Controller\Component;
use DataTables\Table\ConfigBundle;

/**
 * DataTables component
 */
class DataTablesComponent extends Component {

	/**
	 * Default configuration.
	 *
	 * @var array
	 */
	protected $_defaultConfig = [];

	/**
	 * @var \DataTables\Table\ConfigBundle
	 */
	protected $_configBundle;

	/**
	 * @param string|null $name
	 * @param mixed $default
	 * @return mixed
	 */
	public function getData(?string $name = null, $default = null) {
		if ($this->_configBundle->Options->Ajax->getRequestType() === 'POST') {
			$this->getController()->getRequest()->getData($name, $default);
	    }
	    return $this->getController()->getRequest()->getQuery($name, $default);
	}

	/**
	 * @return \DataTables\Table\ConfigBundle
	 */
	public function getConfigBundle(): ConfigBundle {
		return $this->_configBundle;
	}

	/**
	 * @param \DataTables\Table\ConfigBundle $configBundle
	 * @return void
	 */
	public function setConfigBundle(ConfigBundle $configBundle): void {
		$this->_configBundle = $configBundle;
	}

}
