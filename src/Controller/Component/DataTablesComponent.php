<?php
declare(strict_types = 1);

namespace DataTables\Controller\Component;

use Cake\Controller\Component;
use Cake\Core\Configure;
use Cake\Event\EventManager;
use Cake\Routing\Router;
use DataTables\Table\Builder;
use DataTables\Table\ConfigBundle;
use DataTables\Table\Option\MainOption;
use DataTables\Table\QueryBaseState;
use DataTables\Tools\Functions;

/**
 * DataTables component
 */
class DataTablesComponent extends Component {

	/**
	 * @var bool
	 */
	private $_cache = true;

	/**
	 * @var \DataTables\Table\ConfigBundle[]
	 */
	private $_configBundles;

	/**
	 * @inheritDoc
	 */
	public function initialize(array $config): void {
		parent::initialize($config);
		$forceCache = (bool)Configure::read('DataTables.StorageEngine.forceCache');
		if (Configure::read('debug') === true && $forceCache === false) {
			$this->_cache = false;
		}
		$md5 = md5(Router::url());
		$this->getController()->getRequest()->getSession()->delete("DataTables.configs.options.$md5");
		$this->getController()->getRequest()->getSession()->delete("DataTables.configs.query.$md5");
	}

	/**
	 * @param string $tablesAndConfig
	 * @return \DataTables\Table\Option\MainOption
	 * @throws \ReflectionException
	 */
	public function getOptions(string $tablesAndConfig): MainOption {
		$configBundle = $this->getConfigBundle($tablesAndConfig);
		$options = $configBundle->Options;
		$optionsClassMd5 = $this->getClassMd5($options);
		$md5 = Functions::getInstance()->getConfigBundleAndUrlUniqueMd5($configBundle);
		EventManager::instance()->on('Controller.beforeRender', function () use ($md5, $optionsClassMd5, $options)
		{
			if ($optionsClassMd5 !== $this->getClassMd5($options)) {
				$session = $this->getController()->getRequest()->getSession();
				$session->write("DataTables.configs.options.$md5", $options);
			}
		});

		return $options;
	}

	/**
	 * @param string $tablesAndConfig
	 * @return \DataTables\Table\QueryBaseState
	 * @throws \ReflectionException
	 */
	public function getQuery(string $tablesAndConfig): QueryBaseState {
		$configBundle = $this->getConfigBundle($tablesAndConfig);
		$query = $configBundle->Query;
		$queryClassMd5 = $this->getClassMd5($query);
		$md5 = Functions::getInstance()->getConfigBundleAndUrlUniqueMd5($configBundle);

		EventManager::instance()->on('Controller.beforeRender', function () use ($md5, $queryClassMd5, $query)
		{
			if ($queryClassMd5 !== $this->getClassMd5($query)) {
				$session = $this->getController()->getRequest()->getSession();
				$session->write("DataTables.configs.query.$md5", $query);
			}
		});

		return $query;
	}

	/**
	 * @param string $tablesAndConfig
	 * @return \DataTables\Table\ConfigBundle
	 * @throws \ReflectionException
	 */
	private function getConfigBundle(string $tablesAndConfig): ConfigBundle {
		if (empty($this->_configBundles[$tablesAndConfig])) {
			$this->_configBundles[$tablesAndConfig] = Builder::getInstance()->getConfigBundle($tablesAndConfig, $this->_cache);
		}

		return $this->_configBundles[$tablesAndConfig];
	}

	/**
	 * @param object $class
	 * @return string
	 */
	private function getClassMd5(object $class): string {
		return md5(serialize($class));
	}

}
