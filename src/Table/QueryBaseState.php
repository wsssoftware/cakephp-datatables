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

namespace DataTables\Table;

use Cake\ORM\Query;

/**
 * Class QueryBaseState
 * Created by allancarvalho in abril 17, 2020
 */
final class QueryBaseState {

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
	private $_orderItems = [];

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
	 * Return
	 *
	 * @param \Cake\ORM\Query $query
	 * @return \Cake\ORM\Query
	 */
	public function mergeWithQuery(Query $query): Query {
		$this->mergeContain($query);
		$this->mergeSelect($query);
		$this->mergeSelectAllExcept($query);
		$this->mergeLeftJoinWith($query);
		$this->mergeInnerJoinWith($query);
		$this->mergeNotMatching($query);
		$this->mergeOrder($query);
		$this->mergeOrderAsc($query);
		$this->mergeOrderDesc($query);
		$this->mergeWhere($query);
		$this->mergeWhereInList($query);
		$this->mergeWhereNotNull($query);
		$this->mergeWhereNotInList($query);
		$this->mergeWhereNull($query);
		$this->mergeAndWhere($query);
		return $query;
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
	 * @param \Cake\ORM\Query $query
	 * @return void
	 */
	private function mergeContain(Query $query): void {
		foreach ($this->_containItems as $containItem) {
			$query->contain($containItem['associations'], $containItem['queryBuilder']);
		}
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
	 * @param \Cake\ORM\Query $query
	 * @return void
	 */
	private function mergeSelect(Query $query): void {
		foreach ($this->_selectItems as $selectItem) {
			$query->select($selectItem['fields']);
		}
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
	 * @param \Cake\ORM\Query $query
	 * @return void
	 */
	private function mergeSelectAllExcept(Query $query): void {
		foreach ($this->_selectAllExceptItems as $selectAllExceptItem) {
			$query->selectAllExcept($selectAllExceptItem['table'], $selectAllExceptItem['excludedFields']);
		}
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
	 * @param \Cake\ORM\Query $query
	 * @return void
	 */
	private function mergeLeftJoinWith(Query $query): void {
		foreach ($this->_leftJoinWithItems as $leftJoinWithItem) {
			$query->leftJoinWith($leftJoinWithItem['assoc'], $leftJoinWithItem['builder']);
		}
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
	 * @param \Cake\ORM\Query $query
	 * @return void
	 */
	private function mergeInnerJoinWith(Query $query): void{
		foreach ($this->_innerJoinWithItems as $innerJoinWithItem) {
			$query->innerJoinWith($innerJoinWithItem['assoc'], $innerJoinWithItem['builder']);
		}
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
	 * @param \Cake\ORM\Query $query
	 * @return void
	 */
	private function mergeNotMatching(Query $query): void {
		foreach ($this->_notMatchingItems as $notMatchingItem) {
			$query->notMatching($notMatchingItem['assoc'], $notMatchingItem['builder']);
		}
	}

	/**
	 * @param array|\Cake\Database\ExpressionInterface|\Closure|string $fields fields to be added to the list
	 * @param bool $overwrite whether to reset order with field list or not
	 * @return $this
	 * @see \Cake\ORM\Query::order()
	 */
	public function order($fields, $overwrite = false): self {
		if ($overwrite === true) {
			$this->_orderAscItems = [];
		}
		if (!$fields) {
			return $this;
		}
		$this->_orderItems[] = [
			'fields' => $fields,
		];
		return $this;
	}

	/**
	 * @param \Cake\ORM\Query $query
	 * @return void
	 */
	private function mergeOrder(Query $query): void {
		foreach ($this->_orderItems as $orderItem) {
			$query->order($orderItem['fields']);
		}
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
	 * @param \Cake\ORM\Query $query
	 * @return void
	 */
	private function mergeOrderAsc(Query $query): void {
		foreach ($this->_orderAscItems as $orderAscItem) {
			$query->orderAsc($orderAscItem['field']);
		}
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
	 * @param \Cake\ORM\Query $query
	 * @return void
	 */
	private function mergeOrderDesc(Query $query): void {
		foreach ($this->_orderDescItems as $orderDescItem) {
			$query->orderDesc($orderDescItem['field']);
		}
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
	 * @param \Cake\ORM\Query $query
	 * @return void
	 */
	private function mergeWhere(Query $query): void {
		foreach ($this->_whereItems as $whereItem) {
			$query->where($whereItem['conditions'], $whereItem['types']);
		}
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
	 * @param \Cake\ORM\Query $query
	 * @return void
	 */
	private function mergeWhereInList(Query $query): void {
		foreach ($this->_whereInListItems as $whereInListItem) {
			$query->whereInList($whereInListItem['field'], $whereInListItem['values'], $whereInListItem['options']);
		}
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
	 * @param \Cake\ORM\Query $query
	 * @return void
	 */
	private function mergeWhereNotNull(Query $query): void {
		foreach ($this->_whereNotNullItems as $whereNotNullItem) {
			$query->whereNotNull($whereNotNullItem['fields']);
		}
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
	 * @param \Cake\ORM\Query $query
	 * @return void
	 */
	private function mergeWhereNotInList(Query $query): void {
		foreach ($this->_whereNotInListItems as $whereNotInListItem) {
			$query->whereNotInList($whereNotInListItem['field'], $whereNotInListItem['values'], $whereNotInListItem['options']);
		}
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
	 * @param \Cake\ORM\Query $query
	 * @return void
	 */
	private function mergeWhereNull(Query $query): void {
		foreach ($this->_whereNullItems as $whereNullItem) {
			$query->whereNull($whereNullItem['fields']);
		}
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
	 * @param \Cake\ORM\Query $query
	 * @return void
	 */
	private function mergeAndWhere(Query $query): void {
		foreach ($this->_andWhereItems as $andWhereItem) {
			$query->andWhere($andWhereItem['conditions'], $andWhereItem['types']);
		}
	}

}
