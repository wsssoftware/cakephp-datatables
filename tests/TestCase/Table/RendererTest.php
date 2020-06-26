<?php
/**
 * Copyright (c) Allan Carvalho 2020.
 * Under Mit License
 *
 * link: https://github.com/wsssoftware/cakephp-data-renderer
 * author: Allan Carvalho <allan.m.carvalho@outlook.com>
 * license: MIT License https://github.com/wsssoftware/cakephp-datatables/blob/master/LICENSE
 */

namespace DataTables\Test\TestCase\Table;

use Cake\Http\ServerRequest;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\TestSuite\TestCase;
use DataTables\Plugin;
use DataTables\Table\Builder;
use DataTables\Table\Renderer;
use DataTables\View\DataTablesView;
use TestApp\Application;

/**
 * Class RendererTest
 * Created by allancarvalho in abril 27, 2020
 */
class RendererTest extends TestCase {

	/**
	 * @var string[]
	 */
	protected $fixtures = [
		'plugin.DataTables.Articles',
		'plugin.DataTables.Users',
	];

	/**
	 * Test subject
	 *
	 * @var \DataTables\Table\Renderer
	 */
	protected $ArticlesRenderer;

	/**
	 * Test subject
	 *
	 * @var \DataTables\Table\DataTables
	 */
	protected $ArticlesDataTables;

	/**
	 * Test subject
	 *
	 * @var \DataTables\Table\Renderer
	 */
	protected $UsersRenderer;

	/**
	 * Test subject
	 *
	 * @var \DataTables\Table\DataTables
	 */
	protected $UsersDataTables;

	/**
	 * Test subject
	 *
	 * @var \Cake\ORM\Table
	 */
	protected $Articles;

	/**
	 * Test subject
	 *
	 * @var \Cake\ORM\Table
	 */
	protected $Users;

	/**
	 * setUp method
	 *
	 * @throws \ReflectionException
	 * @return void
	 */
	public function setUp(): void {
		parent::setUp();
		$this->Articles = TableRegistry::getTableLocator()->get('Articles');
		$this->Users = TableRegistry::getTableLocator()->get('Users');
		$this->Articles->addAssociations([
			'belongsTo' => [
				'Users',
			],
		]);
		$this->Users->addAssociations([
			'hasMany' => [
				'Articles',
			],
		]);
		$plugin = new Plugin();
		$plugin->bootstrap(new Application(''));
		$plugin->routes(Router::createRouteBuilder(''));
		Router::setRequest(new ServerRequest());
		$configBundle = Builder::getInstance()->getConfigBundle('Articles');
		$this->ArticlesRenderer = new Renderer($configBundle);
		$this->ArticlesDataTables = $configBundle->getDataTables();
		$configBundle = Builder::getInstance()->getConfigBundle('Users');
		$this->UsersRenderer = new Renderer($configBundle);
		$this->UsersDataTables = $configBundle->getDataTables();
	}

	/**
	 * @return void
	 */
	public function testArticles() {
		$article = $this->Articles->find()->contain(['Users'])->first();
		$this->ArticlesDataTables->rowRenderer(new DataTablesView(), $article, $this->ArticlesRenderer);
		$result = $this->ArticlesRenderer->renderRow($article);
		$this->assertEquals($article->id, $result[0]);
		$this->assertEquals($article->user->name, $result[3]);
		$this->assertEquals("<span class='data-tables-plugin auto-loaded' title='this column data was auto generated.'>NOT CONFIGURED YET</span>", $result[6]);
	}

	/**
	 * @return void
	 */
	public function testUsers() {
		$user = $this->Users->find()->contain(['Articles'])->first();
		$this->UsersDataTables->rowRenderer(new DataTablesView(), $user, $this->UsersRenderer);
		$result = $this->UsersRenderer->renderRow($user);
		$this->assertEquals(count($user->articles), $result[2]);
		$this->assertTrue((bool)strpos($result[3], '4 Articles'));
		$this->assertEquals($user->id, $result[0]);
	}

}
