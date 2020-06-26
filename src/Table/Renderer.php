<?php
/**
 * Copyright (c) Allan Carvalho 2020.
 * Under Mit License
 * link: https://github.com/wsssoftware/cakephp-data-renderer
 * author: Allan Carvalho <allan.m.carvalho@outlook.com>
 * license: MIT License https://github.com/wsssoftware/cakephp-datatables/blob/master/LICENSE
 */
declare(strict_types = 1);

namespace DataTables\Table;

use Cake\Core\Configure;
use Cake\Datasource\EntityInterface;
use Cake\I18n\Number;
use Cake\ORM\Association\BelongsTo;
use Cake\ORM\Association\HasMany;
use Cake\ORM\Table;
use Cake\Utility\Inflector;
use Cake\Utility\Text;
use DataTables\Tools\Functions;

/**
 * Class Renderer
 * Created by allancarvalho in abril 22, 2020
 */
final class Renderer {

	/**
	 * @var array
	 */
	private $_cache = [];

	/**
	 * @var \DataTables\Table\ConfigBundle
	 */
	private $_configBundle;

	/**
	 * @param \DataTables\Table\ConfigBundle $configBundle
	 */
	public function __construct(ConfigBundle $configBundle) {
		$this->_configBundle = $configBundle;
	}

	/**
	 * Add a custom print for a column.
	 *
	 * @param string $columnName
	 * @param mixed $value
	 * @return $this
	 */
	public function add(string $columnName, $value) {
		if (!empty($this->_configBundle->Columns->getColumns()[$columnName])) {
			$this->_cache[$columnName] = (string)$value;
		} else {
			$column = $this->_configBundle->Columns->normalizeDataTableField($columnName);
			$this->_cache["{$column['table']}.{$column['column']}"] = (string)$value;
		}

		return $this;
	}

	/**
	 * Render the table row. This method is called for each row.
	 *
	 * @param \Cake\Datasource\EntityInterface $entity
	 * @return array
	 */
	public function renderRow(EntityInterface $entity): array {
		$result = [];
		foreach ($this->_configBundle->Columns->getColumns() as $columnName => $column) {
			if (!empty($this->_cache[$columnName])) {
				$value = $this->_cache[$columnName];
			} else {
				$value = $this->getFormattedColumn($columnName, $column, $entity);
			}
			$result[] = $value;
		}

		return $result;
	}

	/**
	 * Choose the right formatter for the entity property type.
	 *
	 * @param string $columnName
	 * @param \DataTables\Table\Column $column
	 * @param \Cake\Datasource\EntityInterface $entity
	 * @return string
	 */
	private function getFormattedColumn(string $columnName, Column $column, EntityInterface $entity): string {
		$exploded = explode('.', $columnName);
		if (count($exploded) === 2) {
			$value = $this->getPropertyUsingPath($column->getAssociationPath(), $entity, $exploded[1]);
			$integersTypes = ['tinyinteger', 'smallinteger', 'integer', 'biginteger', 'decimal', 'float'];
			if (in_array($column->getColumnSchema('type'), $integersTypes)) {
				if (is_numeric($value)) {
					$value = Number::format($value);
				}
			} elseif ($column->getColumnSchema('type') === 'text') {
				$value = Text::truncate($value, 60);
			} else {
				$value = h($value);
			}
		} else {
			if (!empty($column->getFunctionExpression()) && !empty($entity->{$column->getName()})) {
				$value = $entity->{$column->getName()};
			} else {
				$value = __d('data_tables', 'NOT CONFIGURED YET');
			}
		}
		$pattern = '%s';
		if (Configure::read('DataTables.columnAutoGeneratedWarning', true)) {
			$title = __d('data_tables', 'this column data was auto generated.');
			$pattern = "<span class='data-tables-plugin auto-loaded' title='$title'>%s</span>";
		}

		return sprintf($pattern, $value);
	}

	/**
	 * Get a property using it path.
	 *
	 * @param string $path
	 * @param \Cake\Datasource\EntityInterface $entity
	 * @param string $property
	 * @return mixed
	 */
	public function getPropertyUsingPath(string $path, EntityInterface $entity, string $property) {
		$table = $this->_configBundle->getDataTables()->getOrmTable();
		if ($path === $table->getAlias()) {
			return $entity->{$property};
		}
		$path = substr_replace($path, '', 0, strlen($table->getAlias()) + 1);
		$propertyPath = $this->getPropertyPath($path, $table);
		$result = $entity;
		foreach ($propertyPath as $item) {
			if (!empty($result->{$item})) {
				$result = $result->{$item};
			}
		}
		if (is_array($result)) {
			$lastProperty = $propertyPath[Functions::getInstance()->arrayKeyLast($propertyPath)];

			return $this->returnArrayCountWithLabel($result, $lastProperty);
		}
		if (!empty($result->{$property})) {
			return $result->{$property};
		}

		return '';
	}

	/**
	 * Get the path of properties that are need to call until get the final value.
	 *
	 * @param string $path
	 * @param \Cake\ORM\Table $table
	 * @return array
	 */
	private function getPropertyPath(string $path, Table $table): array {
		$associationNames = explode('.', $path);
		$propertyPath = [];
		$association = $table;
		foreach ($associationNames as $associationName) {
			$association = $association->getAssociation($associationName);
			if ($association instanceof BelongsTo) {
				$propertyPath[] = Inflector::underscore(Inflector::singularize($association->getAlias()));
			} elseif ($association instanceof HasMany) {
				$propertyPath[] = Inflector::underscore(Inflector::pluralize($association->getAlias()));
			}
		}

		return $propertyPath;
	}

	/**
	 * Return a pretty output for an array result.
	 *
	 * @param array $array
	 * @param string $name
	 * @return string
	 */
	private function returnArrayCountWithLabel(array $array, string $name): string {
		$count = count($array);
		if ($count === 1) {
			return $count . ' ' . Inflector::humanize(Inflector::singularize($name));
		}

		return $count . ' ' . Inflector::humanize($name);
	}

}
