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
use Bake\Utility\TableScanner;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use Cake\Datasource\ConnectionManager;
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
		if ($args->getArgument('type') === 'config') {
			$this->connection = $args->getOption('connection');
			/** @var \Cake\Database\Connection $connection */
			$connection = ConnectionManager::get($this->connection);
			$scanner = new TableScanner($connection);
			$table = $args->getOption('table');
			if (empty($table)) {
				$table = $args->getArgument('name');
			}
			$table = Inflector::tableize($table);
			if (!in_array($table, $scanner->listUnskipped())) {
				$io->warning(sprintf("You tried to use a database table '%s' that doesn't exist in the database.", Inflector::camelize($table)));
				$io->info('Create the database table if not exists or use one of options bellow:');
				foreach ($scanner->listUnskipped() as $item) {
					$io->out('- ' . Inflector::camelize($item));
				}
				return static::CODE_SUCCESS;
			}
		} else {
			$callback = $args->getArgument('name');
			$validCallbacks = $this->getValidCallbacks();
			if (!in_array($callback, $validCallbacks)) {
				$io->warning(sprintf("You tried to use a callback '%s' that doesn't exist in plugin.", $callback));
				$io->info('Use one of options bellow:');
				foreach ($validCallbacks as $item) {
					$io->out('- ' . Inflector::camelize($item));
				}
				return static::CODE_SUCCESS;
			}

		}

		$tableObject = $this->getTableLocator()->get($table);
		if (get_class($tableObject) === Table::class) {
			if (empty($args->getOption('table'))) {
				$io->warning("The name '$table' used for the DataTables class does not belong to any database table.");
				$io->info('If this name is correct, use the option \'--table=Foo\' to enter the name of the database table that you want to use in this class.');
			} else {

			}
		}
		$this->_table = $tableObject;
		return parent::execute($args, $io);
	}

	/**
	 * @return array
	 */
	private function getValidCallbacks(): array {
		$dir = DATA_TABLES_ROOT . DS . 'templates' . DS . 'twig' . DS . 'js' . DS . 'bake' . DS;
		$callbacks = scandir($dir);
		foreach ($callbacks as $index => $callback) {
			if (in_array($callback, ['.', '..'])) {
				unset($callbacks[$index]);
			} else {
				$callbacks[$index] = str_replace(['callback_', '.twig'], '', $callback);
			}
		}
		return $callbacks;
	}

	/**
	 * @inheritDoc
	 */
	public function buildOptionParser(ConsoleOptionParser $parser): ConsoleOptionParser {
		$parser = $this->_setCommonOptions($parser);
		$parser->setDescription(
			sprintf('Bake the plugin DataTables necessaries files.')
		)->addArgument('type', [
			'help' => sprintf(
				"A type of bake that you want to do. Must be 'table' or 'callback'"
			),
			'choices' => ['config', 'callback'],
			'required' => true,
		])->addArgument('name', [
			'help' => sprintf(
				'The name of config/callback that will baked.'
			),
			'required' => true,
		]);

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
