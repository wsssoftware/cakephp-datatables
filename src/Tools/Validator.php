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

namespace DataTables\Tools;

use Cake\Error\FatalErrorException;
use Cake\Utility\Text;
use InvalidArgumentException;

/**
 * Class Validator
 *
 * @author   Allan Carvalho <allan.m.carvalho@outlook.com>
 * @license  MIT License https://github.com/allanmcarvalho/cakephp-datatables/blob/master/LICENSE
 * @link     https://github.com/allanmcarvalho/cakephp-datatables
 */
class Validator {

	/**
	 * Storage a instance of object.
	 *
	 * @var self
	 */
	public static $instance;

	/**
	 * Return a instance of builder object.
	 *
	 * @return \DataTables\Tools\Validator
	 */
	public static function getInstance(): Validator {
		if (static::$instance === null) {
			static::$instance = new self();
		}
		return static::$instance;
	}

	/**
	 * Check if the array keys and values are correct.
	 *
	 * @param array $array
	 * @param string|array $allowedKeyTypes A allowed types for array key.
	 * @param string|array $allowedValueTypes A allowed types for array value.
	 * @param string|null $inString A string to make the error more friendly.
	 * @return void
	 */
	public function checkKeysValueTypesOrFail(array $array, $allowedKeyTypes = [], $allowedValueTypes = [], string $inString = null): void {
		$allowedKeyTypesType = getType($allowedKeyTypes);
		if (!in_array($allowedKeyTypesType, ['array', 'string'])) {
			throw new FatalErrorException(sprintf('The $keyType type must be an array or string. Found : %s', $allowedKeyTypesType));
		} elseif ($allowedKeyTypesType === 'string') {
			$allowedKeyTypes = [$allowedKeyTypes];
		}
		$allowedValueTypesType = getType($allowedValueTypes);
		if (!in_array($allowedValueTypesType, ['array', 'string'])) {
			throw new FatalErrorException(sprintf('The $valueType type must be an array or string. Found : %s', $allowedValueTypesType));
		} elseif ($allowedValueTypesType === 'string') {
			$allowedValueTypes = [$allowedValueTypes];
		}
		foreach ($array as $key => $value) {
			$keyType = getType($key);
			$valueType = getType($value);
			if (!in_array($keyType, $allowedKeyTypes) && $allowedKeyTypes !== ['*']) {
				$needleString = str_replace(' and ', ' or ', Text::toList($allowedKeyTypes));
				throw new InvalidArgumentException("In $inString array, the keys always must be $needleString. key: $key.");
			}
			if (!in_array($valueType, $allowedValueTypes) && $allowedValueTypes !== ['*']) {
				$needleString = str_replace(' and ', ' or ', Text::toList($allowedValueTypes));
				throw new InvalidArgumentException("In $inString array, the record $key isn't $needleString. Found: '$valueType'.");
			}
		}
	}

	/**
	 * Check if array size is right.
	 *
	 * @param array $array The array that will be checked.
	 * @param int $expected The expected size.
	 * @param string|null $message A custom exception message.
	 * @return void
	 */
	public function checkArraySizeOrFail(array $array, int $expected, ?string $message = null): void {
		$size = count($array);
		if ($size !== $expected) {
			if (empty($message)) {
				$message = "Wrong array size. Expected: '$expected'. Found: '$size'.";
			}
			throw new InvalidArgumentException($message);
		}
	}

}
