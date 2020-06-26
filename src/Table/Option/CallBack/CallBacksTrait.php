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

namespace DataTables\Table\Option\CallBack;

use DataTables\Tools\Functions;
use DataTables\Tools\Validator;

/**
 * Trait CallBacksTrait
 *
 * @method mixed|void _getConfig(?string $field = null, $default = null)
 * @method void _setConfig(string $field, $value, bool $mustPrint = true)
 * @property \DataTables\Table\ConfigBundle $_configBundle
 */
trait CallBacksTrait {

	/**
	 * Main callback method.
	 *
	 * @param array|string $bodyOrParams To use application template file, leave blank or pass an array with params
	 *                                   that will be used in file. To use the body mode, pass an js code that will
	 *                                   putted inside the js function.
	 * @param string $callbackName
	 * @param string $functionName
	 * @throws \Twig\Error\LoaderError
	 * @throws \Twig\Error\RuntimeError
	 * @throws \Twig\Error\SyntaxError
	 * @return void
	 */
	private function callback($bodyOrParams, string $callbackName, string $functionName) {
		Validator::getInstance()->validateBodyOrParams($bodyOrParams);
		$result = CallBackFactory::getInstance($callbackName, $this->_configBundle->getDataTables()->getAlias())->render($bodyOrParams);
		$callBackTag = Functions::getInstance()->getCallBackReplaceTag($functionName);
		$this->_callbackReplaces[$callBackTag] = $result;
		$this->_setConfig($callbackName, $callBackTag);
	}

	/**
	 * This callback is executed when a TR element is created (and all TD child elements have been inserted), or
	 * registered if using a DOM source, allowing manipulation of the TR element.
	 *
	 * This is particularly useful when using deferred rendering (deferRender) or server-side processing (serverSide)
	 * so you can add events, class name information or otherwise format the row when it is created.
	 *
	 * Accessible parameters inside js function:
	 *  - row (node) - TR row element that has just been created.
	 *  - data (array, object) - Raw data source (array or object) for this row.
	 *  - dataIndex (any) - The index of the row in DataTables' internal storage.
	 *  - cells (node[]) - Since 1.10.17: The cells for the column.
	 *
	 * @link https://datatables.net/reference/option/createdRow
	 * @param array|string $bodyOrParams To use application template file, leave blank or pass an array with params
	 *                                   that will be used in file. To use the body mode, pass an js code that will
	 *                                   putted inside the js function.
	 * @throws \Twig\Error\LoaderError
	 * @throws \Twig\Error\RuntimeError
	 * @throws \Twig\Error\SyntaxError
	 * @return $this
	 */
	public function callbackCreatedRow($bodyOrParams = []) {
		$this->callback($bodyOrParams, 'createdRow', __FUNCTION__);

		return $this;
	}

	/**
	 * It can be useful to take an action on every draw event of the table - for example you might want to update an
	 * external control with the newly displayed data, or with server-side processing is enabled you might want to
	 * assign events to the newly created elements. This callback is designed for exactly that purpose and will execute
	 * on every draw.
	 *
	 * Accessible parameters inside js function:
	 *  - settings (DataTables.Settings) - DataTables settings object.
	 *
	 * @link https://datatables.net/reference/option/drawCallback
	 * @param array|string $bodyOrParams To use application template file, leave blank or pass an array with params
	 *                                   that will be used in file. To use the body mode, pass an js code that will
	 *                                   putted inside the js function.
	 * @throws \Twig\Error\LoaderError
	 * @throws \Twig\Error\RuntimeError
	 * @throws \Twig\Error\SyntaxError
	 * @return $this
	 */
	public function callbackDrawCallback($bodyOrParams = []) {
		$this->callback($bodyOrParams, 'drawCallback', __FUNCTION__);

		return $this;
	}

	/**
	 * Identical to headerCallback but for the table footer this function allows you to modify the table footer on
	 * every 'draw' event.
	 *
	 * Note that if the table does not have a tfoot element, it this callback will not be fired.
	 *
	 * Accessible parameters inside js function:
	 *  - tfoot (node) - tfoot element of the table's footer.
	 *  - data (array) - Full data array of the table. Note that this is in data index order. Use the display
	 *    parameter for the current display order..
	 *  - start (integer) - Index for the current display starting point in the display array.
	 *  - end (integer) - Index for the current display ending point in the display array.
	 *  - display (array) - Index array to translate the visual position to the full data array.
	 *
	 * @link https://datatables.net/reference/option/footerCallback
	 * @param array|string $bodyOrParams To use application template file, leave blank or pass an array with params
	 *                                   that will be used in file. To use the body mode, pass an js code that will
	 *                                   putted inside the js function.
	 * @throws \Twig\Error\LoaderError
	 * @throws \Twig\Error\RuntimeError
	 * @throws \Twig\Error\SyntaxError
	 * @return $this
	 */
	public function callbackFooterCallback($bodyOrParams = []) {
		$this->callback($bodyOrParams, 'footerCallback', __FUNCTION__);

		return $this;
	}

	/**
	 * DataTables will display numbers in a few different locations when drawing information about a table, for example
	 * in the table's information element and the pagination controls. When working with large numbers it is often
	 * useful to format it for readability by separating the thousand units - for example 1 million is rendered as
	 * "1,000,000", allowing the user to see at a glance what order of magnitude the number shows.
	 *
	 * This function allows complete control over how that formatting is performed. By default DataTables will use the
	 * character specified in language.thousands (in turn, that, by default, is a comma) as the thousands separator.
	 *
	 * Accessible parameters inside js function:
	 *  - toFormat (integer) - Number to be formatted.
	 *
	 * @link https://datatables.net/reference/option/formatNumber
	 * @param array|string $bodyOrParams To use application template file, leave blank or pass an array with params
	 *                                   that will be used in file. To use the body mode, pass an js code that will
	 *                                   putted inside the js function.
	 * @throws \Twig\Error\LoaderError
	 * @throws \Twig\Error\RuntimeError
	 * @throws \Twig\Error\SyntaxError
	 * @return $this
	 */
	public function callbackFormatNumber($bodyOrParams = []) {
		$this->callback($bodyOrParams, 'formatNumber', __FUNCTION__);

		return $this;
	}

	/**
	 * This function is called on every 'draw' event (i.e. when a filter, sort or page event is initiated by the end
	 * user or the API), and allows you to dynamically modify the header row. This can be used to calculate and display
	 * useful information about the table.
	 *
	 * Accessible parameters inside js function:
	 *  - thead (node) - thead element of the table's footer.
	 *  - data (array) - Full data array of the table. Note that this is in data index order. Use the display
	 *    parameter for the current display order..
	 *  - start (integer) - Index for the current display starting point in the display array.
	 *  - end (integer) - Index for the current display ending point in the display array.
	 *  - display (array) - Index array to translate the visual position to the full data array.
	 *
	 * @link https://datatables.net/reference/option/headerCallback
	 * @param array|string $bodyOrParams To use application template file, leave blank or pass an array with params
	 *                                   that will be used in file. To use the body mode, pass an js code that will
	 *                                   putted inside the js function.
	 * @throws \Twig\Error\LoaderError
	 * @throws \Twig\Error\RuntimeError
	 * @throws \Twig\Error\SyntaxError
	 * @return $this
	 */
	public function callbackHeaderCallback($bodyOrParams = []) {
		$this->callback($bodyOrParams, 'headerCallback', __FUNCTION__);

		return $this;
	}

	/**
	 * The information element can be used to convey information about the current state of the table. Although the
	 * internationalisation options presented by DataTables are quite capable of dealing with most customisations,
	 * there may be times where you wish to customise the string further. This callback allows you to do exactly that.
	 *
	 * Please note that if the info option is disabled in the initialisation, this callback function is not fired.
	 *
	 * Accessible parameters inside js function:
	 *  - settings (DataTables.Settings) - DataTables settings object.
	 *  - start (integer) - Starting position in data for the draw.
	 *  - end (integer) - End position in data for the draw.
	 *  - max (integer) - Total number of rows in the table (regardless of filtering).
	 *  - total (integer) - Total number of rows in the data set, after filtering.
	 *  - pre (string) - The string that DataTables has formatted using its own rules.
	 *
	 * @link https://datatables.net/reference/option/infoCallback
	 * @param array|string $bodyOrParams To use application template file, leave blank or pass an array with params
	 *                                   that will be used in file. To use the body mode, pass an js code that will
	 *                                   putted inside the js function.
	 * @throws \Twig\Error\LoaderError
	 * @throws \Twig\Error\RuntimeError
	 * @throws \Twig\Error\SyntaxError
	 * @return $this
	 */
	public function callbackInfoCallback($bodyOrParams = []) {
		$this->callback($bodyOrParams, 'infoCallback', __FUNCTION__);

		return $this;
	}

	/**
	 * It can often be useful to know when your table has fully been initialised, data loaded and drawn, particularly
	 * when using an ajax data source. In such a case, the table will complete its initial run before the data has been
	 * loaded (Ajax is asynchronous after all!) so this callback is provided to let you know when the data is fully
	 * loaded.
	 *
	 * Additionally the callback is passed in the JSON data received from the server when Ajax loading data, which can
	 * be useful for configuring components connected to your table, for example Editor fields.
	 *
	 * Accessible parameters inside js function:
	 *  - settings (DataTables.Settings) - DataTables settings object.
	 *  - json (object) - JSON data retrieved from the server if the ajax option was set. Otherwise undefined.
	 *
	 * @link https://datatables.net/reference/option/initComplete
	 * @param array|string $bodyOrParams To use application template file, leave blank or pass an array with params
	 *                                   that will be used in file. To use the body mode, pass an js code that will
	 *                                   putted inside the js function.
	 * @throws \Twig\Error\LoaderError
	 * @throws \Twig\Error\RuntimeError
	 * @throws \Twig\Error\SyntaxError
	 * @return $this
	 */
	public function callbackInitComplete($bodyOrParams = []) {
		$this->callback($bodyOrParams, 'initComplete', __FUNCTION__);

		return $this;
	}

	/**
	 * The partner of the drawCallback callback, this function is called at the very start of each table draw. It can
	 * therefore be used to update or clean the display before each draw (for example removing events), and
	 * additionally can be used to cancel the draw by returning false. Any other return (including undefined) results
	 * in the full draw occurring.
	 *
	 * Accessible parameters inside js function:
	 *  - settings (DataTables.Settings) - DataTables settings object.
	 *
	 * @link https://datatables.net/reference/option/initComplete
	 * @param array|string $bodyOrParams To use application template file, leave blank or pass an array with params
	 *                                   that will be used in file. To use the body mode, pass an js code that will
	 *                                   putted inside the js function.
	 * @throws \Twig\Error\LoaderError
	 * @throws \Twig\Error\RuntimeError
	 * @throws \Twig\Error\SyntaxError
	 * @return $this
	 */
	public function callbackPreDrawCallback($bodyOrParams = []) {
		$this->callback($bodyOrParams, 'preDrawCallback', __FUNCTION__);

		return $this;
	}

	/**
	 * The partner of the drawCallback callback, this function is called at the very start of each table draw. It can
	 * therefore be used to update or clean the display before each draw (for example removing events), and
	 * additionally can be used to cancel the draw by returning false. Any other return (including undefined) results
	 * in the full draw occurring.
	 *
	 * Accessible parameters inside js function:
	 *  - row (node) - TR element being inserted into the document.
	 *  - data (array|object) - Data source for the row. Important: This parameter is the original data source object
	 *    that is used for the row. If you are using objects, then data is an object - if you are using arrays, then
	 *    data is an array. Thus how you obtain the data from this parameter will depend on how the DataTable is
	 *    configured.
	 *  - displayNum (integer) - Row number in the current page of displayed rows.
	 *  - displayIndex (integer) - Row number in the current search set of data (i.e. over all available pages).
	 *  - dataIndex (integer) - DataTables' internal index for the row - see row().index().
	 *
	 * @link https://datatables.net/reference/option/rowCallback
	 * @param array|string $bodyOrParams To use application template file, leave blank or pass an array with params
	 *                                   that will be used in file. To use the body mode, pass an js code that will
	 *                                   putted inside the js function.
	 * @throws \Twig\Error\LoaderError
	 * @throws \Twig\Error\RuntimeError
	 * @throws \Twig\Error\SyntaxError
	 * @return $this
	 */
	public function callbackRowCallback($bodyOrParams = []) {
		$this->callback($bodyOrParams, 'rowCallback', __FUNCTION__);

		return $this;
	}

	/**
	 * With this callback you can define where, and how, the state of a table is loaded from. By default DataTables
	 * will load from localStorage or sessionStrorage, but for more permanent storage, you can store state in a
	 * server-side database.
	 *
	 * Prior to DataTables 1.10.13 this method had to act synchronously, i.e. the state would be returned by the
	 * function. As of 1.10.13 it is possible to load state asynchronously via Ajax or any other async method and
	 * execute the callback function, passing in the loaded state.
	 *
	 * To maintain backwards compatibility the state can still be returned synchronously. To use the callback method,
	 * simply don't return a value from your stateLoadCallback function. See below for examples of both use cases.
	 *
	 * Note that this callback works hand-in-hand with stateSaveCallback. This callback loads the state from storage
	 * when the table is reloaded while stateSaveCallback saves it.
	 *
	 * Accessible parameters inside js function:
	 *  - settings (DataTables.Settings) - DataTables settings object.
	 *  - callback (function) - Since 1.10.13: Callback function that should be executed when the state data is ready
	 *    if loaded by Ajax or some other asynchronous method. If this option is to be used the stateLoadCallback
	 *    method must return undefined (i.e. just don't return anything)!.
	 *
	 * @link https://datatables.net/reference/option/stateLoadCallback
	 * @param array|string $bodyOrParams To use application template file, leave blank or pass an array with params
	 *                                   that will be used in file. To use the body mode, pass an js code that will
	 *                                   putted inside the js function.
	 * @throws \Twig\Error\LoaderError
	 * @throws \Twig\Error\RuntimeError
	 * @throws \Twig\Error\SyntaxError
	 * @return $this
	 */
	public function callbackStateLoadCallback($bodyOrParams = []) {
		$this->callback($bodyOrParams, 'stateLoadCallback', __FUNCTION__);

		return $this;
	}

	/**
	 * Callback which allows modification of the saved state prior to loading that state. This callback is called when
	 * the table is loading state from the stored data, but prior to the settings object being modified by the saved
	 * state.
	 *
	 * Note that the stateLoadCallback option is used to define where and how to load the state, while this function is
	 * used to manipulate the data once it has been retrieved from storage.
	 *
	 * Further note that for plug-in authors, you should use the stateLoadParams event to load parameters for a
	 * plug-in.
	 *
	 * Accessible parameters inside js function:
	 *  - settings (DataTables.Settings) - DataTables settings object.
	 *  - data (object) - Data to save. The data comes from stateSaveParams.
	 *
	 * @link https://datatables.net/reference/option/stateLoadParams
	 * @param array|string $bodyOrParams To use application template file, leave blank or pass an array with params
	 *                                   that will be used in file. To use the body mode, pass an js code that will
	 *                                   putted inside the js function.
	 * @throws \Twig\Error\LoaderError
	 * @throws \Twig\Error\RuntimeError
	 * @throws \Twig\Error\SyntaxError
	 * @return $this
	 */
	public function callbackStateLoadParams($bodyOrParams = []) {
		$this->callback($bodyOrParams, 'stateLoadParams', __FUNCTION__);

		return $this;
	}

	/**
	 * Callback that is fired once the state has been loaded (stateLoadCallback) and the saved data manipulated (if
	 * required - stateLoadParams).
	 *
	 * This callback is useful if you simply wish to know information from the saved state, without getting into the
	 * inner workings of where and how the state information has been saved. For example it can be useful for
	 * populating custom filter inputs.
	 *
	 * Accessible parameters inside js function:
	 *  - settings (DataTables.Settings) - DataTables settings object.
	 *  - data (object) - Data to save. The data comes from stateSaveParams.
	 *
	 * @link https://datatables.net/reference/option/stateLoaded
	 * @param array|string $bodyOrParams To use application template file, leave blank or pass an array with params
	 *                                   that will be used in file. To use the body mode, pass an js code that will
	 *                                   putted inside the js function.
	 * @throws \Twig\Error\LoaderError
	 * @throws \Twig\Error\RuntimeError
	 * @throws \Twig\Error\SyntaxError
	 * @return $this
	 */
	public function callbackStateLoaded($bodyOrParams = []) {
		$this->callback($bodyOrParams, 'stateLoaded', __FUNCTION__);

		return $this;
	}

	/**
	 * DataTables can save the state of the table (paging, filtering etc) when the stateSave option is enabled, and by
	 * default it will use HTML5's localStorage to save the state into. This callback method allows you to change where
	 * the state is saved (for example you might wish to use a server-side database or cookies).
	 *
	 * Accessible parameters inside js function:
	 *  - settings (DataTables.Settings) - DataTables settings object.
	 *  - data (object) - Data to save. The data comes from stateSaveParams.
	 *
	 * @link https://datatables.net/reference/option/stateSaveCallback
	 * @param array|string $bodyOrParams To use application template file, leave blank or pass an array with params
	 *                                   that will be used in file. To use the body mode, pass an js code that will
	 *                                   putted inside the js function.
	 * @throws \Twig\Error\LoaderError
	 * @throws \Twig\Error\RuntimeError
	 * @throws \Twig\Error\SyntaxError
	 * @return $this
	 */
	public function callbackStateSaveCallback($bodyOrParams = []) {
		$this->callback($bodyOrParams, 'stateSaveCallback', __FUNCTION__);

		return $this;
	}

	/**
	 * Callback which allows modification of the parameters to be saved for the DataTables state saving (stateSave),
	 * prior to the data actually being saved. This callback is called every time DataTables requests that the state be
	 * saved. For the format of the data that is stored, please refer to the stateSaveCallback documentation.
	 *
	 * Note that the stateSaveCallback option is used to define where and how to store the state, while this function is
	 * used to manipulate the data before it is entered into storage.
	 *
	 * Further note that for plug-in authors, you should use the stateSaveParams event to add extra parameters to the
	 * state storage object if required.
	 *
	 * Accessible parameters inside js function:
	 *  - settings (DataTables.Settings) - DataTables settings object.
	 *  - data (object) - Data to save. The data comes from stateSaveParams.
	 *
	 * @link https://datatables.net/reference/option/stateSaveParams
	 * @param array|string $bodyOrParams To use application template file, leave blank or pass an array with params
	 *                                   that will be used in file. To use the body mode, pass an js code that will
	 *                                   putted inside the js function.
	 * @throws \Twig\Error\LoaderError
	 * @throws \Twig\Error\RuntimeError
	 * @throws \Twig\Error\SyntaxError
	 * @return $this
	 */
	public function callbackStateSaveParams($bodyOrParams = []) {
		$this->callback($bodyOrParams, 'stateSaveParams', __FUNCTION__);

		return $this;
	}

}
