<?php
/**
 * Copyright (c) 2018. Allan Carvalho
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express
 * or implied. See the License for the specific language governing
 * permissions and limitations under the License.
 */

namespace DataTables\View\Helper;

use Cake\Error\FatalErrorException;
use Cake\Routing\Router;
use Cake\View\Helper;

/**
 * CakePHP DataTablesHelper
 * @property Helper\HtmlHelper Html
 * @author allan
 */
class DataTablesHelper extends Helper
{

    public $helpers = ['Html'];
    public $wasRendered = [];
    public $json = [];

    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->json['data'] = [];
    }

    /**
     * Create base datatables html structure
     * @param string $name
     * @param array $options
     * @return string
     */
    public function render($name, array $options = [])
    {
        if (empty($this->getView()->get('DataTables')[$name])) {
            throw new FatalErrorException(__d('datatables', 'The requested DataTables {0} config was not configured or set to view in controller', $name));
        }
        $config = $this->getView()->get('DataTables')[$name];
        $this->wasRendered[] = $name;
        $options['id'] = $config['id'];
        $options += [
            'width' => '100%',
            'cellspacing' => 0,
            'class' => 'display'
        ];
        $cols = [];
        foreach ($config['columns'] as $item) {
            $cols[] = $item['label'];
        }

        return $this->Html->tag('table', $this->Html->tag('thead', $this->Html->tableHeaders($cols)), $options);
    }

    /**
     * @param array $data
     * @deprecated 1.4.0 deprecated by inconsistency in method name. Use appendRow() instead. This method will be removed in future version.
     */
    public function prepareData(array $data)
    {
        $this->appendRow($data);
    }

    /**
     * Append datatables row into json response
     * @param array $data
     */
    public function appendRow(array $data)
    {
        $this->json['data'][] = $data;
    }

    /**
     * echo all appended rows as json response
     */
    public function response()
    {
        $data = $this->json['data'];
        $this->json = $this->getView()->get('resultInfo');
        $this->json['data'] = $data;
        echo json_encode($this->json, JSON_PRETTY_PRINT);
    }

    /**
     * If exists config for current request generate datatables js code
     * @return null|string
     */
    public function setJs()
    {
        if (!empty($this->getView()->get('DataTables'))) {
            $readyFunctionContent = "";
            foreach ($this->wasRendered as $item) {
                $config = $this->getView()->get('DataTables')[$item];

                if (!empty($config['options'])) {
                    $options = $config['options'];
                } else {
                    $options = [];
                }

                $columnCount = 0;
                $order = [];
                $columnDefs = [];
                foreach ($config['columns'] as $column) {
                    if (!empty($column['order'])) {
                        if(is_array($column['order'])) {
                            $order[$column['order']['index']] = [$columnCount, $column['order']['dir']];
                        } else {
                            $order[] = [$columnCount, $column['order']];
                        }

                    }

                    $columnDefs[] = array_merge([
                        'targets' => $columnCount,
                    ], $column);

                    $columnCount++;
                }
                ksort($order);
                $oldOrder = $order;
                $order = [];
                if(!empty($oldOrder)) {
                    foreach ($oldOrder as $orderItem) {
                        $order[] = [$orderItem[0], $orderItem[1]];
                    }
                }

                $options['processing'] = true;
                $options['serverSide'] = true;
                if (empty($options['ajax']['url'])) {
                    if (empty($config['urls'][$config['trait']])) {
                        throw new FatalErrorException('Cannot find url configuration for ' . $config['trait'] . ' for DataTable ' . $item . '. Perhaps you have not called setTrait() in your DataTable configuration.');
                    }
                    $url = $config['urls'][$config['trait']] + [$item];
                    if ($config['trait'] === 'FocSearchRequestTrait') {
                        $url = array_merge($url, $this->getView()->getRequest()->getQuery());
                    }
                    $options['ajax']['url'] = Router::url($url);
                }
                if (!empty($options['ajax']['error'])) {
                    $functionCode = $this->minifyJs($options['ajax']['error']);
                    $options['ajax']['error'] = "%f%function(xhr, error, thrown){{$functionCode}}%f%";
                }
                $options['order'] = $order;
                $options['columnDefs'] = $columnDefs;

                $readyFunctionContent .= "$('#" . $config['id'] . "').DataTable(";
                $readyFunctionContent .= json_encode($options);
                $readyFunctionContent = preg_replace_callback('/("%f%)(.*?)(%f%"){1}?/', function ($matches) {
                    return str_replace(['\n'], "\n", $matches[2]);
                }, $readyFunctionContent);
                $readyFunctionContent .= ");";
            }
            return "<script>$(document).ready(function() {" . $readyFunctionContent . "} );</script>";
        }
        return null;
    }

    /**
     * Minify any js code to prevent php break line (/n) errors and optimize the code
     * @param string $input
     * @return null|string|string[]
     */
    private function minifyJs($input)
    {
        if (trim($input) === "") return $input;
        return preg_replace(
            [
                // Remove comment(s)
                '#\s*("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')\s*|\s*\/\*(?!\!|@cc_on)(?>[\s\S]*?\*\/)\s*|\s*(?<![\:\=])\/\/.*(?=[\n\r]|$)|^\s*|\s*$#',
                // Remove white-space(s) outside the string and regex
                '#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\'|\/\*(?>.*?\*\/)|\/(?!\/)[^\n\r]*?\/(?=[\s.,;]|[gimuy]|$))|\s*([!%&*\(\)\-=+\[\]\{\}|;:,.<>?\/])\s*#s',
                // Remove the last semicolon
                '#;+\}#',
                // Minify object attribute(s) except JSON attribute(s). From `{'foo':'bar'}` to `{foo:'bar'}`
                '#([\{,])([\'])(\d+|[a-z_][a-z0-9_]*)\2(?=\:)#i',
                // --ibid. From `foo['bar']` to `foo.bar`
                '#([a-z0-9_\)\]])\[([\'"])([a-z_][a-z0-9_]*)\2\]#i'
            ],
            [
                '$1',
                '$1$2',
                '}',
                '$1$3',
                '$1.$3'
            ],
            $input);
    }

}
