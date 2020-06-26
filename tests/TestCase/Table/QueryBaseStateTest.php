<?php
/**
 * Copyright (c) Allan Carvalho 2020.
 * Under Mit License
 *
 * link: https://github.com/wsssoftware/cakephp-data-renderer
 * author: Allan Carvalho <allan.m.carvalho@outlook.com>
 * license: MIT License https://github.com/wsssoftware/cakephp-datatables/blob/master/LICENSE
 *
 * @noinspection SqlNoDataSourceInspection
 * @noinspection SqlDialectInspection
 */

namespace DataTables\Test\TestCase\Table;

use Cake\Http\ServerRequest;
use Cake\ORM\Query;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\TestSuite\TestCase;
use DataTables\Plugin;
use DataTables\Table\Builder;
use TestApp\Application;

/**
 * Class QueryBaseStateTest
 * Created by allancarvalho in abril 27, 2020
 */
class QueryBaseStateTest extends TestCase {

	/**
	 * @var string[]
	 */
	protected $fixtures = [
		'plugin.DataTables.Articles',
		'plugin.DataTables.Users',
	];

	/**
	 * @var \DataTables\Table\QueryBaseState
	 */
	private $QueryBaseState;

	/**
	 * @var \Cake\ORM\Query
	 */
	private $Query;

	/**
	 * setUp method
	 *
	 * @throws \ReflectionException
	 * @return void
	 */
	public function setUp(): void {
		parent::setUp();
		$plugin = new Plugin();
		$plugin->bootstrap(new Application(''));
		$plugin->routes(Router::createRouteBuilder(''));
		Router::setRequest(new ServerRequest());
		$Articles = TableRegistry::getTableLocator()->get('Articles');
		$Articles->addAssociations([
			'belongsTo' => [
				'Users',
			],
		]);
		$this->Query = $Articles->find();
		$this->QueryBaseState = Builder::getInstance()->getConfigBundle('Articles')->Query;
		$this->loadFixtures();
	}

	/**
	 * @param \Cake\ORM\Query $query
	 * @param string $sql
	 * @return void
	 */
	private function compareSql(Query $query, string $sql): void {
		$toReplace = ['"', '\'', ' '];
		$sql = str_replace($toReplace, '', $sql);
		$querySql = str_replace($toReplace, '', $query->sql($query->getValueBinder()));
		$this->assertEquals($sql, $querySql);
	}

	/**
	 * @return void
	 */
	public function testContain() {
		$this->QueryBaseState->select(['id'], true);
		$this->QueryBaseState->contain('Users', function ($q) {
			     return $q->where(['id' => 1]);
		});
		$this->QueryBaseState->contain('Users', true);
		$this->QueryBaseState->mergeWithQuery($this->Query);
		$this->compareSql(
			$this->Query,
			'SELECT Articles.id AS Articles__id FROM articles Articles LEFT JOIN users Users ON Users.id = (Articles.user_id)'
		);
	}

	/**
	 * @return void
	 */
	public function testSelect() {
		$this->QueryBaseState->select(['id'], true);
		$this->QueryBaseState->select(['created'], false);
		$this->QueryBaseState->mergeWithQuery($this->Query);
		$this->compareSql(
			$this->Query,
			'SELECT Articles.id AS Articles__id, Articles.created AS Articles__created FROM articles Articles'
		);
	}

	/**
	 * @return void
	 */
	public function testSelectAllExcept() {
		$table = TableRegistry::getTableLocator()->get('Articles');
		$this->QueryBaseState->selectAllExcept($table, ['id', 'user_id', 'title', 'message'], true);
		$this->QueryBaseState->mergeWithQuery($this->Query);
		$this->compareSql(
			$this->Query,
			'SELECT Articles.created AS Articles__created, Articles.modified AS Articles__modified FROM articles Articles'
		);
	}

	/**
	 * @return void
	 */
	public function testLeftJoinWith() {
		$this->QueryBaseState->select(['id', 'Users.id']);
		$this->QueryBaseState->leftJoinWith('Users');
		$this->QueryBaseState->mergeWithQuery($this->Query);
		$this->compareSql(
			$this->Query,
			'SELECT Articles.id AS Articles__id, Users.id AS Users__id FROM articles Articles LEFT JOIN users Users ON Users.id = (Articles.user_id)'
		);
	}

	/**
	 * @return void
	 */
	public function testInnerJoinWith() {
		$this->QueryBaseState->select(['id', 'Users.id']);
		$this->QueryBaseState->innerJoinWith('Users');
		$this->QueryBaseState->mergeWithQuery($this->Query);
		$this->compareSql(
			$this->Query,
			'SELECT Articles.id AS Articles__id, Users.id AS Users__id FROM articles Articles INNER JOIN users Users ON Users.id = (Articles.user_id)'
		);
	}

	/**
	 * @return void
	 */
	public function testNotMatching() {
		$this->QueryBaseState->select(['id', 'Users.id']);
		$this->QueryBaseState->notMatching('Users', function ($q)
		{
			return $q->where(['name' => 'cake']);
		});
		$this->QueryBaseState->mergeWithQuery($this->Query);
		$this->compareSql(
			$this->Query,
			'SELECT Articles.id AS Articles__id, Users.id AS Users__id FROM articles Articles LEFT JOIN users Users ON (name = :c0 AND Users.id = (Articles.user_id)) WHERE (Users.id) IS NULL'
		);
	}

	/**
	 * @return void
	 */
	public function testOrder() {
		$this->QueryBaseState->select(['id']);
		$this->QueryBaseState->order(false, true);
		$this->QueryBaseState->order(['id' => 'desc']);
		$this->QueryBaseState->mergeWithQuery($this->Query);
		$this->compareSql(
			$this->Query,
			'SELECT Articles.id AS Articles__id FROM articles Articles ORDER BY id desc'
		);
	}

	/**
	 * @return void
	 */
	public function testOrderAsc() {
		$this->QueryBaseState->select(['id']);
		$this->QueryBaseState->orderAsc('created');
		$this->QueryBaseState->orderAsc('id', true);
		$this->QueryBaseState->mergeWithQuery($this->Query);
		$this->compareSql(
			$this->Query,
			'SELECT Articles.id AS Articles__id FROM articles Articles ORDER BY id ASC'
		);
	}

	/**
	 * @return void
	 */
	public function testOrderDesc() {
		$this->QueryBaseState->select(['id']);
		$this->QueryBaseState->orderDesc('created');
		$this->QueryBaseState->orderDesc('id', true);
		$this->QueryBaseState->mergeWithQuery($this->Query);
		$this->compareSql(
			$this->Query,
			'SELECT Articles.id AS Articles__id FROM articles Articles ORDER BY id DESC'
		);
	}

	/**
	 * @return void
	 */
	public function testWhere() {
		$this->QueryBaseState->select(['id']);
		$this->QueryBaseState->where(['created' => 1]);
		$this->QueryBaseState->where(['id' => 2], [], true);
		$this->QueryBaseState->where(['title' => 'abc']);
		$this->QueryBaseState->mergeWithQuery($this->Query);
		$this->compareSql(
			$this->Query,
			'SELECT Articles.id AS Articles__id FROM articles Articles WHERE (id = :c0 AND title = :c1)'
		);
	}

	/**
	 * @return void
	 */
	public function testWhereInList() {
		$this->QueryBaseState->select(['id']);
		$this->QueryBaseState->whereInList('id', [1, 2, 3]);
		$this->QueryBaseState->mergeWithQuery($this->Query);
		$this->compareSql(
			$this->Query,
			'SELECT Articles.id AS Articles__id FROM articles Articles WHERE id in (:c0,:c1,:c2)'
		);
	}

	/**
	 * @return void
	 */
	public function testWhereNotNull() {
		$this->QueryBaseState->select(['id']);
		$this->QueryBaseState->whereNotNull(['id', 'title']);
		$this->QueryBaseState->mergeWithQuery($this->Query);
		$this->compareSql(
			$this->Query,
			'SELECT Articles.id AS Articles__id FROM articles Articles WHERE ((id) IS NOT NULL AND (title) IS NOT NULL)'
		);
	}

	/**
	 * @return void
	 */
	public function testWhereNotInList() {
		$this->QueryBaseState->select(['id']);
		$this->QueryBaseState->whereNotInList('id', [1, 2, 3]);
		$this->QueryBaseState->mergeWithQuery($this->Query);
		$this->compareSql(
			$this->Query,
			'SELECT Articles.id AS Articles__id FROM articles Articles WHERE id not in (:c0,:c1,:c2)'
		);
	}

	/**
	 * @return void
	 */
	public function testWhereNull() {
		$this->QueryBaseState->select(['id']);
		$this->QueryBaseState->whereNull(['id']);
		$this->QueryBaseState->mergeWithQuery($this->Query);
		$this->compareSql(
			$this->Query,
			'SELECT Articles.id AS Articles__id FROM articles Articles WHERE (id) IS NULL'
		);
	}

	/**
	 * @return void
	 */
	public function testAndWhere() {
		$this->QueryBaseState->select(['id']);
		$this->QueryBaseState->andWhere(['id' => 1, 'created' => 2]);
		$this->QueryBaseState->mergeWithQuery($this->Query);
		$this->compareSql(
			$this->Query,
			'SELECT Articles.id AS Articles__id FROM articles Articles WHERE (id = :c0 AND created = :c1)'
		);
	}

}
