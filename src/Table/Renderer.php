<?php
/**
 * Copyright (c) Allan Carvalho 2020.
 * Under Mit License
 * link:     https://github.com/wsssoftware/cakephp-data-renderer
 * author:   Allan Carvalho <allan.m.carvalho@outlook.com>
 * license:  MIT License https://github.com/wsssoftware/cakephp-datatables/blob/master/LICENSE
 */
declare(strict_types = 1);

namespace DataTables\Table;

use Cake\I18n\Number;
use Cake\ORM\Association\BelongsTo;
use Cake\ORM\Association\HasMany;
use Cake\ORM\Entity;
use Cake\Utility\Inflector;
use Cake\Utility\Text;
use DataTables\Tools\Functions;

/**
 * Class Renderer
 * Created by allancarvalho in abril 22, 2020
 */
class Renderer {

	/**
	 * @var array
	 */
	private $_cache = [];

	/**
	 * @var \DataTables\Table\Columns
	 */
	private $_columns;

	/**
	 * Renderer constructor.
	 *
	 * @param \DataTables\Table\Columns $columns
	 */
	public function __construct(Columns $columns) {
		$this->_columns = $columns;
	}

	/**
	 * @param string $columnName
	 * @param mixed $value
	 * @return $this
	 */
	public function add(string $columnName, $value): self {
		if (!empty($this->_columns->getColumns()[$columnName])) {
			$this->_cache[$columnName] = (string)$value;
		} else {
			$column = $this->_columns->normalizeDataTableField($columnName);
			$this->_cache["{$column['table']}.{$column['column']}"] = (string)$value;
		}
		return $this;
	}

	/**
	 * @param \Cake\ORM\Entity $entity
	 * @return array
	 */
	public function renderRow(Entity $entity): array {
		$result = [];
		foreach ($this->_columns->getColumns() as $columnName => $column) {
			if (!empty($this->_cache[$columnName])) {
				$value = $this->_cache[$columnName];
			} else {
				$exploded = explode('.', $columnName);
				if (count($exploded) === 2) {
					$value = $this->getPropertyUsingPath($column->getAssociationPath(), $entity, $exploded[1]);
					switch ($column->getColumnSchema('type')) {
						case 'tinyinteger':
						case 'smallinteger':
						case 'integer':
						case 'biginteger':
						case 'decimal':
						case 'float':
							$value = Number::format($value);
							break;
						case 'text':
							$value = Text::truncate($value, 60);
							break;
						default:
							$value = h($value);
							break;
					}

					$column->getColumnSchema('type');
				} else {
					$value = __d('datatables', 'NOT CONFIGURED YET');

				}
				$value = "<span style='color: red;'>" . $value . '</span>';
			}
			$result[] = $value;
		}
		return $result;
	}

	/**
	 * @param string $path
	 * @param \Cake\ORM\Entity $entity
	 * @param string $property
	 * @return mixed
	 */
	public function getPropertyUsingPath(string $path, Entity $entity, string $property) {
		$table = $this->_columns->getTables()->getOrmTable();
		if ($path === $table->getAlias()) {
			return $entity->{$property};
		}
		$path = substr_replace($path, '', 0, strlen($table->getAlias()) + 1);
		$associationNames = explode('.', $path);
		$propertyPath = [];
		$association = $table;
		foreach ($associationNames as $associationName) {
			$association = $association->getAssociation($associationName);
			if ($association instanceof BelongsTo) {
				if (method_exists($association, 'getAlias')) {
					$propertyPath[] = Inflector::underscore(Inflector::singularize($association->getAlias()));
				} else {
					return '';
				}
			} elseif ($association instanceof HasMany) {
				if (method_exists($association, 'getAlias')) {
					$propertyPath[] = Inflector::underscore(Inflector::pluralize($association->getAlias()));
				} else {
					return '';
				}
			}
		}
		$result = $entity;
		foreach ($propertyPath as $item) {
			if (empty($result->{$item})) {
				return '';
			}
			$result = $result->{$item};
		}
		$lastProperty = $propertyPath[Functions::getInstance()->arrayKeyLast($propertyPath)];
		if (is_array($result)) {
			$count = count($result);
			if ($count === 1) {
				return $count . ' ' . Inflector::humanize(Inflector::singularize($lastProperty));
			}
			return $count . ' ' . Inflector::humanize($lastProperty);
		}
		if (empty($result->{$property})) {
			return '';
		}
		return $result->{$property};
	}

}
