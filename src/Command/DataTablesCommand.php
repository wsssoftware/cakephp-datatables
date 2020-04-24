<?php
/**
 * Copyright (c) Allan Carvalho 2020.
 * Under Mit License
 *
 * link:     https://github.com/wsssoftware/cakephp-data-renderer
 * author:   Allan Carvalho <allan.m.carvalho@outlook.com>
 * license:  MIT License https://github.com/wsssoftware/cakephp-datatables/blob/master/LICENSE
 */

namespace DataTables\Command;

use Bake\Command\SimpleBakeCommand;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use Cake\ORM\Table;
use Cake\Utility\Inflector;

class DataTablesCommand extends SimpleBakeCommand {

	/**
	 * @var string
	 */
	protected $pathFragment = 'DataTables' . DS;

	/**
	 * @var \Cake\ORM\Table
	 */
	private $_table;

	/**
	 * @inheritDoc
	 */
	public function name(): string {
		return 'DataTables class';
	}

	/**
	 * @inheritDoc
	 */
	public function fileName(string $name): string {
		return $name . 'DataTables.php';
	}

	/**
	 * @inheritDoc
	 */
	public function template(): string {
		return 'DataTables.DataTables/DataTables';
	}

	/**
	 * @inheritDoc
	 */
	public function templateData(Arguments $arguments): array {
		$data = parent::templateData($arguments);
		$data += [
			'tableName' => $this->_table->getAlias(),
			'entityName' => Inflector::singularize($this->_table->getAlias()),
		];

		return $data;
	}

	/**
	 * @inheritDoc
	 */
	public function execute(Arguments $args, ConsoleIo $io): ?int {
		$table = $args->getOption('table');
		if (empty($table)) {
			$table = $args->getArgument('name');
		}
		$table = Inflector::camelize($table);
		$tableObject = $this->getTableLocator()->get($table);
		if (get_class($tableObject) === Table::class) {
			if (empty($args->getOption('table'))) {
				$io->warning("The name '$table' used for the DataTables class does not belong to any database table.");
				$io->info('If this name is correct, use the option \'--table=Foo\' to enter the name of the database table that you want to use in this class.');
			} else {
				$io->warning('You tried to use a database table that doesn\'t exist in the database or just hasn\'t yet been baked in your app.');
				$io->info('Create the database table if not exists and/or bake the model before try bake the DataTables class again.');
			}
			return static::CODE_SUCCESS;
		}
		$this->_table = $tableObject;
		return parent::execute($args, $io);
	}

	/**
	 * @inheritDoc
	 */
	public function buildOptionParser(ConsoleOptionParser $parser): ConsoleOptionParser {
		$parser = parent::buildOptionParser($parser);
		$parser->addOption('table', [
			'short' => 't',
			'help' => 'Database to use in DataTables class.',
		]);
		$parser->removeOption('plugin');
		$parser->removeOption('theme');
		$parser->removeOption('no-test');
		return $parser;
	}

}
