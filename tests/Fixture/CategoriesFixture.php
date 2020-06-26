<?php
/**
 * Copyright (c) Allan Carvalho 2020.
 * Under Mit License
 * php version 7.2
 *
 * link https://github.com/allanmcarvalho/cakephp-data-renderer
 * author Allan Carvalho <allan.m.carvalho@outlook.com>
 */
declare(strict_types = 1);

namespace DataTables\Test\Fixture;

use Cake\I18n\Time;
use Cake\TestSuite\Fixture\TestFixture;

/**
 * Class CategoriesFixture
 *
 * @author Allan Carvalho <allan.m.carvalho@outlook.com>
 * @license MIT License https://github.com/allanmcarvalho/cakephp-datatables/blob/master/LICENSE
 * @link https://github.com/allanmcarvalho/cakephp-datatables
 */
class CategoriesFixture extends TestFixture {

	/**
	 * Fields
	 *
	 * @var array
	 */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'name' => ['type' => 'string', 'length' => 45, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => false, 'default' => null, 'comment' => ''],
        'modified' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => false, 'default' => null, 'comment' => ''],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ],
    ];
    // phpcs:enable
	/**
	 * Init method
	 *
	 * @return void
	 */
	public function init(): void {
		$this->records = [
			[
				'id' => 1,
				'name' => 'Cars',
				'created' => $this->getRandTime(),
				'modified' => $this->getRandTime(),
			],
			[
				'id' => 2,
				'name' => 'Trucks',
				'created' => $this->getRandTime(),
				'modified' => $this->getRandTime(),
			],
			[
				'id' => 3,
				'name' => 'Bikes',
				'created' => $this->getRandTime(),
				'modified' => $this->getRandTime(),
			],
			[
				'id' => 4,
				'name' => 'Pickups',
				'created' => $this->getRandTime(),
				'modified' => $this->getRandTime(),
			],
		];
		parent::init();
	}

	/**
	 * @return string
	 */
	private function getRandTime(): string {
		$time = Time::now();
		$time->modify('-' . rand(1, 10000) . ' minutes');
		$time->modify('-' . rand(1, 10000) . ' hours');
		$time->modify('-' . rand(1, 700) . ' days');
		$time->modify('-' . rand(1, 4) . ' years');

		return $time->format('Y-m-d H:i:s');
	}

}
