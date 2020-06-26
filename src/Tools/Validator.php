<?php
/**
 * Copyright (c) Allan Carvalho 2020.
 * Under Mit License
 *
 * link: https://github.com/wsssoftware/cakephp-data-renderer
 * author: Allan Carvalho <allan.m.carvalho@outlook.com>
 * license: MIT License https://github.com/wsssoftware/cakephp-datatables/blob/master/LICENSE
 */
declare(strict_types = 1);

namespace DataTables\Tools;

use Cake\Error\FatalErrorException;
use Cake\Utility\Text;
use InvalidArgumentException;

/**
 * Class Validator
 *
 * Created by allancarvalho in abril 17, 2020
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
	public static function getInstance() {
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
	public function checkKeysValueTypesOrFail(?array $array, $allowedKeyTypes = [], $allowedValueTypes = [], ?string $inString = null): void {
		if (empty($array)) {
		    return;
		}
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

	/**
	 * Check if item is in array or fail.
	 *
	 * @param mixed $needle
	 * @param array $haystack
	 * @param bool $allowEmpty
	 * @param bool $strict
	 * @return void
	 */
	public function inArrayOrFail($needle, array $haystack, bool $allowEmpty = true, bool $strict = false): void {
		$haystackValidString = $this->arrayToStringMessage($haystack);
		if (!in_array($needle, $haystack, $strict) && empty($needle) !== $allowEmpty) {
			throw new InvalidArgumentException("You can use only $haystackValidString. Found: '$needle'.");
		}
	}

	/**
	 * Convert an array to string message.
	 *
	 * @param array $array
	 * @param string|null $and
	 * @return string
	 */
	public function arrayToStringMessage(array $array, ?string $and = 'or'): string {
		foreach ($array as $index => $item) {
			$array[$index] = "'$item'";
		}

		return Text::toList($array, $and);
	}

	/**
	 * Check if bodyOrParams has a valid content.
	 *
	 * @param string|array|null $bodyOrParams
	 * @return void
	 */
	public function validateBodyOrParams($bodyOrParams) {
		$bodyOrParamsType = gettype($bodyOrParams);
		$validTypes = ['string', 'array'];
		static::getInstance()->inArrayOrFail($bodyOrParamsType, $validTypes);
	}

}
