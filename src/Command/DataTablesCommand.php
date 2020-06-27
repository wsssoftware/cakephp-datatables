<?php
/**
 * Copyright (c) Allan Carvalho 2020.
 * Under Mit License
 *
 * link: https://github.com/wsssoftware/cakephp-data-renderer
 * author: Allan Carvalho <allan.m.carvalho@outlook.com>
 * license: MIT License https://github.com/wsssoftware/cakephp-datatables/blob/master/LICENSE
 */

namespace DataTables\Command;

use Bake\Command\SimpleBakeCommand;
use Bake\Command\TestCommand;
use Bake\Utility\TableScanner;
use Bake\Utility\TemplateRenderer;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;
use Cake\Utility\Inflector;

class DataTablesCommand extends SimpleBakeCommand {

	/**
	 * @var string
	 */
	protected $pathFragment = 'DataTables' . DS;

	/**
	 * @var string
	 */
	private $_bakeType;

	/**
	 * @var string
	 */
	private $_configName;

	/**
	 * @var string
	 */
	private $_callback;

	/**
	 * @var \Cake\ORM\Table
	 */
	private $_table;

	/**
	 * @var string
	 */
	private $_template;

	/**
	 * @inheritDoc
	 */
	public function name(): string {
		return 'DataTables';
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
		return $this->_template;
	}

	/**
	 * @inheritDoc
	 */
	public function execute(Arguments $args, ConsoleIo $io): ?int {
		$this->_bakeType = $args->getArgument('type');
		$this->_configName = Inflector::camelize($args->getArgument('configName'));
		$this->_callback = $args->getArgument('callback');
		$this->connection = $args->getOption('connection');
		if ($this->_bakeType === 'config') {
			/** @var \Cake\Database\Connection $connection */
			$connection = ConnectionManager::get($this->connection);
			$scanner = new TableScanner($connection);
			$table = $args->getOption('table');
			if (empty($table)) {
				$table = $this->_configName;
			}
			$this->_table = TableRegistry::getTableLocator()->get(Inflector::camelize($table));
			if (!in_array($this->_table->getTable(), $scanner->listUnskipped())) {
				$io->warning(sprintf("You tried to use a database table '%s' that doesn't exist in the database (connection: %s).", $this->_table->getTable(), $this->connection));
				$io->info('Create the database table if not exists or use one of options bellow:');
				foreach ($scanner->listUnskipped() as $item) {
					$io->out('- ' . Inflector::camelize($item));
				}

				return static::CODE_SUCCESS;
			}
			if (!empty($this->_callback)) {
				$io->warning(sprintf("You don't must use callback argument on bake configs."));

				return static::CODE_SUCCESS;
			}
			$this->bakeAppConfig($args, $io);
			$this->bakeConfig($args, $io);
			$this->bakeConfigTest($args, $io);
		} else {
			$validConfigs = $this->getValidConfigs();
			if (!in_array($this->_configName, $validConfigs)) {
				$io->warning(sprintf("You tried to use a DataTables config '%s' that doesn't exist in your app.", $this->_configName));
				$io->info('Use one of options bellow:');
				foreach ($validConfigs as $item) {
					$io->out('- ' . Inflector::camelize($item));
				}

				return static::CODE_SUCCESS;
			}
			if (empty($this->_callback) || !in_array($this->_callback, $this->getValidCallbacks())) {
				$io->warning(sprintf('You must choose a valid callback name like:'));
				foreach ($this->getValidCallbacks() as $validCallback) {
					$io->out(" - $validCallback");
				}

				return static::CODE_SUCCESS;
			}
			$this->bakeCallbackBody($args, $io);
		}

		return static::CODE_SUCCESS;
	}

	/**
	 * Bake a config class.
	 *
	 * @param \Cake\Console\Arguments $args
	 * @param \Cake\Console\ConsoleIo $io
	 * @return void
	 */
	public function bakeConfig(Arguments $args, ConsoleIo $io) {
		$this->_template = 'DataTables.config';
		$renderer = new TemplateRenderer();
		$renderer->set('name', $this->_configName);
		$templateData = $this->templateData($args) + ['tableName' => $this->_table->getAlias(), 'entityName' => Inflector::singularize($this->_table->getAlias())];
		$renderer->set($templateData);
		$contents = $renderer->generate($this->template());
		$filename = $this->getPath($args) . $this->fileName($this->_configName);
		$io->createFile($filename, $contents, (bool)$args->getOption('force'));

		$emptyFile = $this->getPath($args) . '.gitkeep';
		$this->deleteEmptyFile($emptyFile, $io);
	}

	/**
	 * Bake a config class.
	 *
	 * @param \Cake\Console\Arguments $args
	 * @param \Cake\Console\ConsoleIo $io
	 * @return void
	 */
	public function bakeAppConfig(Arguments $args, ConsoleIo $io) {
		$filename = $this->getPath($args) . $this->fileName('App');
	    if (!file_exists($filename)) {
			$this->_template = 'DataTables.app_config';
			$renderer = new TemplateRenderer();
			$renderer->set('name', 'App');
			$templateData = $this->templateData($args);
			$renderer->set($templateData);
			$contents = $renderer->generate($this->template());
			$io->createFile($filename, $contents, (bool)$args->getOption('force'));

			$emptyFile = $this->getPath($args) . '.gitkeep';
			$this->deleteEmptyFile($emptyFile, $io);
		} else {
	        $io->info(sprintf('"%s" will not baked because it already exists.', $this->fileName('App')));
		}
	}

	/**
	 * Bake a config class test.
	 *
	 * @param \Cake\Console\Arguments $args
	 * @param \Cake\Console\ConsoleIo $io
	 * @return void
	 */
	public function bakeConfigTest(Arguments $args, ConsoleIo $io) {
		if ($args->getOption('no-test')) {
			return;
		}
		$test = new TestCommand();
		$test->plugin = $this->plugin;
		$test->classSuffixes += [
			'DataTables' => 'DataTables',
		];
		$test->classTypes += [
			'DataTables' => 'DataTables',
		];
		$test->bake($this->name(), $this->_configName, $args, $io);
	}

	/**
	 * Back a callback body file.
	 *
	 * @param \Cake\Console\Arguments $args
	 * @param \Cake\Console\ConsoleIo $io
	 * @return void
	 */
	public function bakeCallbackBody(Arguments $args, ConsoleIo $io) {
		$this->_template = 'DataTables.callbacks/bodies/' . $this->_callback;
		$basePath = Configure::read('DataTables.resources.templates');
		if (substr($basePath, -1, 1) !== DS) {
			$basePath .= DS;
		}
		$basePath .= $this->_configName . DS . 'callbacks' . DS;
		$renderer = new TemplateRenderer();
		$renderer->set('name', $this->_configName);
		$templateData = $this->templateData($args) + [
				'callback' => Inflector::humanize($this->_callback),
				'callbackFunction' => $this->_callback,
			];
		$renderer->set($templateData);
		$contents = $renderer->generate($this->template());
		$filename = $basePath . $this->_callback . '.js';
		$io->createFile($filename, $contents, (bool)$args->getOption('force'));
		$emptyFile = $this->getPath($args) . '.gitkeep';
		$this->deleteEmptyFile($emptyFile, $io);
	}

	/**
	 * @return array
	 */
	private function getValidCallbacks(): array {
		$dir = DATA_TABLES_TEMPLATES . 'bake' . DS . 'callbacks' . DS . 'bodies' . DS;
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
	 * @return array
	 */
	private function getValidConfigs(): array {
		$dir = APP . 'DataTables' . DS;
		$configs = scandir($dir);
		foreach ($configs as $index => $callback) {
			if (in_array($callback, ['.', '..'])) {
				unset($configs[$index]);
			} else {
				$configs[$index] = str_replace(['DataTables.php'], '', $callback);
			}
		}

		return $configs;
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
		])->addArgument('configName', [
			'help' => sprintf(
				'Config name that will baked or selected.'
			),
			'required' => true,
		])->addArgument('callback', [
			'help' => sprintf(
				'The name of callback that will baked.'
			),
		]);

		$parser->addOption('table', [
			'short' => 't',
			'help' => 'Database to use in DataTables class.',
		]);
		$parser->removeOption('plugin');
		$parser->removeOption('theme');

		return $parser;
	}

}
