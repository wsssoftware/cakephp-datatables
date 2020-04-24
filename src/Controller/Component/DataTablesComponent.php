<?php
declare(strict_types = 1);

namespace DataTables\Controller\Component;

use Cake\Controller\Component;
use Cake\Core\Configure;
use Cake\Event\EventManager;
use Cake\Routing\Router;
use Cake\Utility\Inflector;
use DataTables\Table\Builder;
use DataTables\Table\ConfigBundle;
use DataTables\Table\Option\MainOption;
use DataTables\Table\QueryBaseState;
use DataTables\Tools\Functions;
use InvalidArgumentException;

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
	 * @param string $dataTables
	 * @return \DataTables\Table\Option\MainOption
	 * @throws \ReflectionException
	 */
	public function getOptions(string $dataTables): MainOption {
		return $this->setEventAndGetObject($dataTables, 'Options');
	}

	/**
	 * @param string $dataTables
	 * @return \DataTables\Table\QueryBaseState
	 * @throws \ReflectionException
	 */
	public function getQuery(string $dataTables): QueryBaseState {
		return $this->setEventAndGetObject($dataTables, 'Query');
	}

	/**
	 * @param string $dataTables
	 * @param string $objectName
	 * @return \DataTables\Table\QueryBaseState|\DataTables\Table\Option\MainOption
	 * @throws \ReflectionException
	 */
	private function setEventAndGetObject(string $dataTables, string $objectName) {
		$configBundle = $this->getConfigBundle($dataTables);
		if (!in_array($objectName, ['Query', 'Options'])) {
			throw new InvalidArgumentException("\$objectName must be 'Query' or 'Options'. Found: $objectName.");
		}
		$object = $configBundle->{$objectName};
		$classMd5 = $this->getClassMd5($object);
		$md5 = Functions::getInstance()->getConfigBundleAndUrlUniqueMd5($configBundle);

		EventManager::instance()->on('Controller.beforeRender', function () use ($objectName, $md5, $classMd5, $object)
		{
			if ($classMd5 !== $this->getClassMd5($object)) {
				$session = $this->getController()->getRequest()->getSession();
				$objectNameLower = Inflector::underscore($objectName);
				$session->write("DataTables.configs.$objectNameLower.$md5", $object);
			}
		});

		return $object;
	}

	/**
	 * @param string $dataTables
	 * @return \DataTables\Table\ConfigBundle
	 * @throws \ReflectionException
	 */
	private function getConfigBundle(string $dataTables): ConfigBundle {
		if (empty($this->_configBundles[$dataTables])) {
			$this->_configBundles[$dataTables] = Builder::getInstance()->getConfigBundle($dataTables, $this->_cache);
		}

		return $this->_configBundles[$dataTables];
	}

	/**
	 * @param object $class
	 * @return string
	 */
	private function getClassMd5(object $class): string {
		return md5(serialize($class));
	}

}
