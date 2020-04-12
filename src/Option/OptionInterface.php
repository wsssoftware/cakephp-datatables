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

namespace DataTables\Option;

/**
 * Interface OptionInterface
 *
 * @package DataTables\Option
 */
interface OptionInterface {

	/**
	 * OptionInterface constructor.
	 *
	 * @param \DataTables\Option\MainOption|null $parentOption
	 */
	public function __construct(?MainOption $parentOption = null);

	/**
	 * Get if all options will be printed or not.
	 *
	 * @return bool
	 */
	public function isPrintAllOptions(): bool;

	/**
	 * Define if all options will be printed or not.
	 *
	 * @param bool $printAllOptions
	 * @return $this
	 */
	public function setPrintAllOptions(bool $printAllOptions): self;

	/**
	 * Tell if a field or a many fields will be printed or not.
	 *
	 * @param string|null $field The field that you intent to see or null for all.
	 * @return string|array|null A value if exists or null.
	 */
	public function getMustPrint(?string $field = null);

	/**
	 * Set if a field must be printed or not.
	 *
	 * @param string $field The field that will be changed.
	 * @param bool $must True or false to set if it will printed or not.
	 * @return void
	 */
	public function setMustPrint(string $field, bool $must = true): void;

	/**
	 * Tell if a field or a many fields will be printed or not.
	 *
	 * @param string|null $field The field that you intent to see or null for all.
	 * @param string|array|null $default A default value for called config.
	 * @return mixed A value if exists or null.
	 */
	public function getConfig(?string $field = null, $default = null);

	/**
	 * Set if a field must be printed or not.
	 *
	 * @param string $field The field that will be changed.
	 * @param mixed $value A value intended to save at config.
	 * @param bool $mustPrint Set or not the field as 'mustPrint'.
	 * @return void
	 */
	public function setConfig(string $field, $value, bool $mustPrint = true): void;

	/**
	 * @return \DataTables\Option\MainOption|null Return the parent Option class;
	 */
	public function getParentOption(): ?MainOption;

	/**
	 * Get the config as json.
	 *
	 * @param bool|null $printAllOptions
	 * @return string
	 */
	public function getConfigAsJson(?bool $printAllOptions = null): string;

	/**
	 * Get the config as array.
	 *
	 * @param bool|null $printAllOptions
	 * @return array
	 */
	public function getConfigAsArray(?bool $printAllOptions = null): array;

}
