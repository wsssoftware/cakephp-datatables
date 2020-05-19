<?php
/**
 * Copyright (c) Allan Carvalho 2020.
 * Under Mit License
 *
 * link:     https://github.com/wsssoftware/cakephp-data-renderer
 * author:   Allan Carvalho <allan.m.carvalho@outlook.com>
 * license:  MIT License https://github.com/wsssoftware/cakephp-datatables/blob/master/LICENSE
 */
declare(strict_types = 1);

namespace DataTables\Table\Option;

use Cake\Core\Configure;
use Cake\I18n\Number;
use Cake\ORM\Association\HasMany;
use Cake\Routing\Router;
use Cake\Utility\Hash;
use DataTables\Table\Columns;
use DataTables\Table\ConfigBundle;
use DataTables\Table\Option\CallBack\CallBackFactory;
use DataTables\Table\Option\CallBack\CallBacksTrait;
use DataTables\Table\Option\Section\AjaxOptionTrait;
use DataTables\Table\Option\Section\FeaturesOptionTrait;
use DataTables\Table\Option\Section\LanguageOptionTrait;
use DataTables\Table\Option\Section\OptionsOptionAOTrait;
use DataTables\Table\Option\Section\OptionsOptionPZTrait;
use DataTables\Table\Option\Section\PluginSelectTrait;
use DataTables\Tools\Functions;
use NumberFormatter;

/**
 * Class MainOption
 * Created by allancarvalho in abril 17, 2020
 */
final class MainOption extends OptionAbstract {

	use AjaxOptionTrait;
	use CallBacksTrait;
	use FeaturesOptionTrait;
	use LanguageOptionTrait;
	use OptionsOptionAOTrait;
	use OptionsOptionPZTrait;
	use PluginSelectTrait;

	const ALLOWED_PAGING_TYPES = [
		'numbers',
		'simple',
		'simple_numbers',
		'full',
		'full_numbers',
		'first_last_numbers',
	];

	const I18N_TRANSLATION = -1;

	/**
	 * @var \DataTables\Table\ConfigBundle
	 */
	protected $_configBundle;

	/**
	 * @var array
	 * @inheritDoc
	 */
	protected $_mustPrint = [
		'ajax.type' => true,
		'serverSide' => true,
	];

	/**
	 * @var array
	 * @inheritDoc
	 */
	protected $_config = [
		'ajax' => [
			'url' => null,
			'type' => 'GET',
		],
		'autoWidth' => true,
		'createdRow' => null,
		'columnDefs' => [],
		'columns' => [],
		'deferLoading' => null,
		'deferRender' => false,
		'destroy' => false,
		'displayStart' => 0,
		'dom' => 'lfrtip',
		'info' => true,
		'lengthChange' => true,
		'lengthMenu' => [10, 25, 50, 100],
		'order' => [[0, 'asc']],
		'orderCellsTop' => false,
		'orderClasses' => true,
		'orderFixed' => null,
		'ordering' => true,
		'orderMulti' => true,
		'pageLength' => 10,
		'paging' => true,
		'pagingType' => 'simple_numbers',
		'processing' => false,
		'renderer' => null,
		'retrieve' => false,
		'rowId' => 'DT_RowId',
		'scrollX' => false,
		'scrollY' => null,
		'search' => [
			'caseInsensitive' => true,
			'regex' => false,
			'search' => null,
			'smart' => true,
		],
		'searching' => true,
		'serverSide' => true,
		'stateSave' => false,
		'scrollCollapse' => false,
		'searchCols' => null,
		'searchDelay' => null,
		'stateDuration' => 7200,
		'stripeClasses' => null,
		'tabIndex' => 0,
	];

	/**
	 * Define if all options will be printed or not.
	 *
	 * @var bool
	 */
	protected $_printAllOptions = false;

	/**
	 * @var array
	 */
	protected $_callbackReplaces = [];

	/**
	 * MainOption constructor.
	 *
	 * @param \DataTables\Table\ConfigBundle $configBundle
	 * @param string $url
	 */
	public function __construct(ConfigBundle $configBundle, string $url) {
		parent::__construct();
		$this->_configBundle = $configBundle;
		$this->setConfig('ajax.url', $url);
		$this->setLanguageThousands(Number::formatter()->getSymbol(NumberFormatter::DECIMAL));
		$this->setLanguageDecimal(Number::formatter()->getSymbol(NumberFormatter::DECIMAL_SEPARATOR_SYMBOL));
	}

	/**
	 * Setter method.
	 * Set all columns and defColumns options using a Columns class.
	 *
	 * @internal
	 * @param \DataTables\Table\Columns $columns
	 * @return $this
	 * @link https://datatables.net/reference/option/
	 */
	public function setColumns(Columns $columns): self {
		$columnsConfig = [];
		foreach ($columns->getColumns() as $column) {
			if ($column->isDatabase() === false) {
				$column->setSearchable(false);
				$column->setOrderable(false);
			} else {
				$association = Functions::getInstance()->getAssociationUsingPath($columns->getConfigBundle()->getDataTables()->getOrmTable(), $column->getAssociationPath());
				if ($association instanceof HasMany) {
					$column->setSearchable(false);
					$column->setOrderable(false);
				}
			}
			$columnConfig = $column->getConfig();
			if (!empty($columnConfig['createdCell'])) {
				$result = CallBackFactory::getInstance('createdCell', $this->_configBundle->getDataTables()->getAlias())->render($columnConfig['createdCell'], 3);
				$callBackTag = Functions::getInstance()->getCallBackReplaceTag(__FUNCTION__);
				$this->_callbackReplaces[$callBackTag] = $result;
				$columnConfig['createdCell'] = $callBackTag;
			}
			$columnsConfig[] = $columnConfig;
		}
		$this->_setConfig('columnDefs', [$columns->Default->getConfig(true, true)]);
		$this->_setConfig('columns', $columnsConfig);
		return $this;
	}

	/**
	 * Get if all options will be printed or not.
	 *
	 * @return bool
	 */
	public function isPrintAllOptions(): bool {
		return $this->_printAllOptions;
	}

	/**
	 * Define if all options will be printed or not.
	 *
	 * @param bool $printAllOptions
	 * @return $this
	 */
	public function setPrintAllOptions(bool $printAllOptions): self {
		$this->_printAllOptions = $printAllOptions;
		return $this;
	}

	/**
	 * Tell if a field or a many fields will be printed or not.
	 *
	 * @param string|null $field The field that you intent to see or null for all.
	 * @return string|array|null A value if exists or null.
	 */
	public function getMustPrint(?string $field = null) {
		if (!empty($field)) {
			return Hash::get($this->_mustPrint, $field, null);
		}
		return $this->_mustPrint;
	}

	/**
	 * Set if a field must be printed or not.
	 *
	 * @param string $field The field that will be changed.
	 * @param bool $must True or false to set if it will printed or not.
	 * @return \DataTables\Table\Option\MainOption
	 */
	public function setMustPrint(string $field, bool $must = true): MainOption {
		$this->_mustPrint = Hash::insert($this->_mustPrint, $field, $must);
		return $this;
	}

	/**
	 * Get a config.
	 *
	 * @param string|null $field The field that you intent to see or null for all.
	 * @param string|array|null $default A default value for called config.
	 * @return mixed A value if exists or null.
	 */
	public function getConfig(?string $field = null, $default = null) {
		return $this->_getConfig($field, $default);
	}

	/**
	 * Set manually a config.
	 *
	 * @param string $field The field that will be changed.
	 * @param mixed $value A value intended to save at config.
	 * @param bool $mustPrint Set or not the field as 'mustPrint'.
	 * @return $this
	 */
	public function setConfig(string $field, $value, bool $mustPrint = true): self {
		$this->_setConfig($field, $value, $mustPrint);

		return $this;
	}

	/**
	 * Get the config as json.
	 *
	 * @param bool|null $printAllOptions
	 * @return string
	 */
	public function getConfigAsJson(?bool $printAllOptions = null): string {
		$options = 0;
		if (Configure::read('debug') === true) {
			$options = JSON_PRETTY_PRINT;
		}

		$json = json_encode($this->getConfigAsArray($printAllOptions), $options);
		foreach ($this->_callbackReplaces as $key => $callbackReplace) {
			$start = strpos($json, $key);
			$length = strlen($key) + 2;
			if ($start !== false) {
				$start -= 1;
				$json = substr_replace($json, $callbackReplace, $start, $length);
			}
		}
		return $json;
	}

	/**
	 * Get the config as array.
	 *
	 * @param bool|null $printAllOptions
	 * @return array
	 */
	public function getConfigAsArray(?bool $printAllOptions = null): array {
		$localResourcesConfig = $this->_configBundle->LocalResourcesConfig;
	    if ($localResourcesConfig->isAutoload()) {
			if (!empty($this->getConfig('select')) && !$localResourcesConfig->isLoadPluginSelect()) {
				$localResourcesConfig->setLoadPluginSelect(true);
			}
		}

		$url = Hash::get($this->_config, 'ajax.url');
		$url = "$url/" . md5(Router::url());
		$this->_config = Hash::insert($this->_config, 'ajax.url', $url);
		if ($printAllOptions === true || (empty($printAllOptions) && $this->_printAllOptions === true)) {
			return $this->_config;
		}
		$result = [];
		foreach (Hash::flatten($this->_mustPrint) as $key => $config) {
			$result = Hash::insert($result, $key, Hash::get($this->_config, $key, null));
		}

		return $result;
	}

}
