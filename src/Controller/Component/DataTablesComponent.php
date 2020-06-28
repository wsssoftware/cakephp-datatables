<?php
declare(strict_types = 1);

namespace DataTables\Controller\Component;

use Cake\Controller\Component;
use Cake\Core\Configure;
use Cake\Event\EventManager;
use Cake\Routing\Router;
use Cake\Utility\Inflector;
use DataTables\Table\Builder;
use DataTables\Table\Columns;
use DataTables\Table\ConfigBundle;
use DataTables\Table\Configure as TableConfigure;
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
		$forceCache = TableConfigure::getInstance()->isForceCache();
		if (Configure::read('debug') === true && $forceCache === false) {
			$this->_cache = false;
		}
		$md5 = md5(Router::url());
		$this->getController()->getRequest()->getSession()->delete("DataTables.configs.columns.$md5");
		$this->getController()->getRequest()->getSession()->delete("DataTables.configs.options.$md5");
		$this->getController()->getRequest()->getSession()->delete("DataTables.configs.query.$md5");
	}

	/**
	 * Get Columns object, and set a event to save it on session if have changes. This will overwrite the
	 * original ConfigBundle Columns configuration on table render.
	 *
	 * @param string $dataTablesName
	 * @throws \ReflectionException
	 * @return \DataTables\Table\Columns
	 */
	public function getColumns(string $dataTablesName): Columns {
		return $this->setEventAndGetObject($dataTablesName, 'Columns');
	}

	/**
	 * Get MainOption object, and set a event to save it on session if have changes. This will overwrite the
	 * original ConfigBundle MainOption configuration on table render.
	 *
	 * @param string $dataTablesName
	 * @throws \ReflectionException
	 * @return \DataTables\Table\Option\MainOption
	 */
	public function getOptions(string $dataTablesName): MainOption {
		return $this->setEventAndGetObject($dataTablesName, 'Options');
	}

	/**
	 * Get QueryBaseState object, and set a event to save it on session if have changes. This will overwrite the
	 * original ConfigBundle QueryBaseState configuration on table render.
	 *
	 * @param string $dataTablesName
	 * @throws \ReflectionException
	 * @return \DataTables\Table\QueryBaseState
	 */
	public function getQuery(string $dataTablesName): QueryBaseState {
		return $this->setEventAndGetObject($dataTablesName, 'Query');
	}

	/**
	 * Get Columns, Options or Query, and set a event to save it on session if have changes.
	 *
	 * @param string $dataTablesName
	 * @param string $objectName
	 * @throws \ReflectionException
	 * @return \DataTables\Table\QueryBaseState|\DataTables\Table\Option\MainOption|\DataTables\Table\Columns
	 */
	private function setEventAndGetObject(string $dataTablesName, string $objectName) {
		$configBundle = $this->getConfigBundle($dataTablesName);
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
	 * Get a ConfigBundle instance using its name or FQN.
	 *
	 * @param string $dataTables
	 * @throws \ReflectionException
	 * @return \DataTables\Table\ConfigBundle
	 */
	private function getConfigBundle(string $dataTables): ConfigBundle {
		if (empty($this->_configBundles[$dataTables])) {
			$this->_configBundles[$dataTables] = Builder::getInstance()->getConfigBundle($dataTables, $this->_cache);
		}

		return $this->_configBundles[$dataTables];
	}

	/**
	 * Get the md5 from a class instance to compare changes.
	 *
	 * @param object $class
	 * @return string
	 */
	private function getClassMd5(object $class): string {
		return md5(serialize($class));
	}

}
