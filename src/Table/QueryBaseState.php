<?php
/**
 * Copyright (c) Allan Carvalho 2020.
 * Under Mit License
 * php version 7.2
 *
 * link     https://github.com/allanmcarvalho/cakephp-data-renderer
 * author   Allan Carvalho <allan.m.carvalho@outlook.com>
 */
declare(strict_types = 1);

namespace DataTables\Table;

/**
 * Class QueryBaseState
 *
 * @author   Allan Carvalho <allan.m.carvalho@outlook.com>
 * @license  MIT License https://github.com/allanmcarvalho/cakephp-datatables/blob/master/LICENSE
 * @link     https://github.com/allanmcarvalho/cakephp-datatables
 */
class QueryBaseState {

	/**
	 * @var array
	 */
	private $_containItems = [];

	/**
	 * @var array
	 */
	private $_selectItems = [];

	/**
	 * @var array
	 */
	private $_selectAllExceptItems = [];

	/**
	 * @var array
	 */
	private $_leftJoinWithItems = [];

	/**
	 * @var array
	 */
	private $_innerJoinWithItems = [];

	/**
	 * @var array
	 */
	private $_notMatchingItems = [];

	/**
	 * @var array
	 */
	private $_orderAscItems = [];

	/**
	 * @var array
	 */
	private $_orderDescItems = [];

	/**
	 * @var array
	 */
	private $_whereItems = [];

	/**
	 * @var array
	 */
	private $_whereInListItems = [];

	/**
	 * @var array
	 */
	private $_whereNotNullItems = [];

	/**
	 * @var array
	 */
	private $_whereNotInListItems = [];

	/**
	 * @var array
	 */
	private $_whereNullItems = [];

	/**
	 * @var array
	 */
	private $_andWhereItems = [];

	/**
	 * @var array
	 */
	private $_urlWhereItems = [];

	/**
	 * Return
	 *
	 * @return array
	 */
	public function getArray(): array {
		return [
			'contain' => $this->_containItems,
			'select' => $this->_selectItems,
			'selectAllExcept' => $this->_selectAllExceptItems,
			'leftJoinWith' => $this->_leftJoinWithItems,
			'innerJoinWith' => $this->_innerJoinWithItems,
			'notMatching' => $this->_notMatchingItems,
			'orderAsc' => $this->_orderAscItems,
			'orderDesc' => $this->_orderDescItems,
			'where' => $this->_whereItems,
			'whereInList' => $this->_whereInListItems,
			'whereNotNull' => $this->_whereNotNullItems,
			'whereNotInList' => $this->_whereNotInListItems,
			'whereNull' => $this->_whereNullItems,
			'andWhere' => $this->_andWhereItems,
			'urlWhere' => $this->_urlWhereItems,
		];
	}

	/**
	 * @param array|string $associations List of table aliases to be queried.
	 * @param callable|bool $override The query builder for the association, or
	 *   if associations is an array, a bool on whether to override previous list
	 *   with the one passed
	 * defaults to merging previous list with the new one.
	 * @return $this
	 * @see \Cake\ORM\Query::contain()
	 */
	public function contain($associations, $override = false): self {
		$queryBuilder = null;
		if ($override === true) {
			$this->_containItems = [];
		}
		$queryBuilder = null;
		if (is_callable($override)) {
			$queryBuilder = $override;
		}
		if ($associations) {
			$this->_containItems[] = [
				'associations' => $associations,
				'queryBuilder' => $queryBuilder,
			];
		}
		return $this;
	}

	/**
	 * @param array|\Cake\Database\ExpressionInterface|callable|string|\Cake\ORM\Table|\Cake\ORM\Association $fields Fields
	 * to be added to the list.
	 * @param bool $overwrite whether to reset fields with passed list or not
	 * @return $this
	 * @see \Cake\ORM\Query::select()
	 */
	public function select($fields, bool $overwrite = false): self {
		if ($overwrite === true) {
			$this->_selectItems = [];
		}
		$this->_selectItems[] = [
			'fields' => $fields,
		];
		return $this;
	}

	/**
	 * @param \Cake\ORM\Table|\Cake\ORM\Association $table The table to use to get an array of columns
	 * @param string[] $excludedFields The un-aliased column names you do not want selected from $table
	 * @param bool $overwrite Whether to reset/remove previous selected fields
	 * @return $this
	 * @throws \InvalidArgumentException If Association|Table is not passed in first argument
	 * @see \Cake\ORM\Query::selectAllExcept()
	 */
	public function selectAllExcept($table, array $excludedFields, bool $overwrite = false): self {
		if ($overwrite === true) {
			$this->_selectAllExceptItems = [];
		}
		$this->_selectAllExceptItems[] = [
			'table' => $table,
			'excludedFields' => $excludedFields,
		];
		return $this;
	}

	/**
	 * @param string $assoc The association to join with
	 * @param callable|null $builder a function that will receive a pre-made query object
	 * that can be used to add custom conditions or selecting some fields
	 * @return $this
	 * @see \Cake\ORM\Query::leftJoinWith()
	 */
	public function leftJoinWith(string $assoc, ?callable $builder = null): self {
		$this->_leftJoinWithItems[] = [
			'assoc' => $assoc,
			'builder' => $builder,
		];
		return $this;
	}

	/**
	 * @param string $assoc The association to join with
	 * @param callable|null $builder a function that will receive a pre-made query object
	 * that can be used to add custom conditions or selecting some fields
	 * @return $this
	 * @see \Cake\ORM\Query::innerJoinWith()
	 */
	public function innerJoinWith(string $assoc, ?callable $builder = null): self {
		$this->_innerJoinWithItems[] = [
			'assoc' => $assoc,
			'builder' => $builder,
		];
		return $this;
	}

	/**
	 * @param string $assoc The association to filter by
	 * @param callable|null $builder a function that will receive a pre-made query object
	 * that can be used to add custom conditions or selecting some fields
	 * @return $this
	 * @see \Cake\ORM\Query::notMatching()
	 */
	public function notMatching(string $assoc, ?callable $builder = null): self {
		$this->_notMatchingItems[] = [
			'assoc' => $assoc,
			'builder' => $builder,
		];
		return $this;
	}

	/**
	 * @param string|\Cake\Database\Expression\QueryExpression $field The field to order on.
	 * @param bool $overwrite Whether or not to reset the order clauses.
	 * @return $this
	 * @see \Cake\ORM\Query::orderAsc()
	 */
	public function orderAsc($field, bool $overwrite = false): self {
		if ($overwrite === true) {
			$this->_orderAscItems = [];
		}
		$this->_orderAscItems[] = [
			'field' => $field,
		];
		return $this;
	}

	/**
	 * @param string|\Cake\Database\Expression\QueryExpression $field The field to order on.
	 * @param bool $overwrite Whether or not to reset the order clauses.
	 * @return $this
	 * @see \Cake\ORM\Query::orderDesc()
	 */
	public function orderDesc($field, bool $overwrite = false): self {
		if ($overwrite === true) {
			$this->_orderDescItems = [];
		}
		$this->_orderDescItems[] = [
			'field' => $field,
		];
		return $this;
	}

	/**
	 * @param string|array|\Cake\Database\ExpressionInterface|\Closure|null $conditions The conditions to filter on.
	 * @param array $types associative array of type names used to bind values to query
	 * @param bool $overwrite whether to reset conditions with passed list or not
	 * @return $this
	 * @see \Cake\ORM\Query::where()
	 */
	public function where($conditions = null, array $types = [], bool $overwrite = false): self {
		if ($overwrite === true) {
			$this->_whereItems = [];
		}
		$this->_whereItems[] = [
			'conditions' => $conditions,
			'types' => $types,
		];
		return $this;
	}

	/**
	 * @param string $field Field
	 * @param array $values Array of values
	 * @param array $options Options
	 * @return $this
	 * @see \Cake\ORM\Query::whereInList()
	 */
	public function whereInList(string $field, array $values, array $options = []): self {
		$this->_whereInListItems[] = [
			'field' => $field,
			'values' => $values,
			'options' => $options,
		];
		return $this;
	}

	/**
	 * @param array|string|\Cake\Database\ExpressionInterface $fields A single field or expressions or a list of them
	 *  that should be not null.
	 * @return $this
	 * @see \Cake\ORM\Query::whereNotNull()
	 */
	public function whereNotNull($fields): self {
		$this->_whereNotNullItems[] = [
			'fields' => $fields,
		];
		return $this;
	}

	/**
	 * @param string $field Field
	 * @param array $values Array of values
	 * @param array $options Options
	 * @return $this
	 * @see \Cake\ORM\Query::whereNotInList()
	 */
	public function whereNotInList(string $field, array $values, array $options = []): self {
		$this->_whereNotInListItems[] = [
			'field' => $field,
			'values' => $values,
			'options' => $options,
		];
		return $this;
	}

	/**
	 * @param array|string|\Cake\Database\ExpressionInterface $fields A single field or expressions or a list of them
	 *   that should be null.
	 * @return $this
	 * @see \Cake\ORM\Query::whereNull()
	 */
	public function whereNull($fields): self {
		$this->_whereNullItems[] = [
			'fields' => $fields,
		];
		return $this;
	}

	/**
	 * @param string|array|\Cake\Database\ExpressionInterface|\Closure $conditions The conditions to add with AND.
	 * @param array $types associative array of type names used to bind values to query
	 * @return $this
	 * @see \Cake\ORM\Query::andWhere()
	 */
	public function andWhere($conditions, array $types = []): self {
		$this->_andWhereItems[] = [
			'conditions' => $conditions,
			'types' => $types,
		];
		return $this;
	}

	/**
	 * Add a condition for a specific URL
	 *
	 * @param string|array|\Cake\Database\ExpressionInterface|\Closure|null $conditions The conditions to filter on.
	 * @param string|array|\Psr\Http\Message\UriInterface|null $url An array specifying any of the following:
	 * @return $this
	 */
	public function urlWhere($conditions, $url): self {
		$this->_urlWhereItems[] = [
			'conditions' => $conditions,
			'url' => $url,
		];
		return $this;
	}

}
