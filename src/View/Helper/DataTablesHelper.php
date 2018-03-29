<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
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
        if (empty($this->_View->viewVars["DataTables"][$name])) {
            throw new FatalErrorException(__d('datatables', 'The requested DataTables config was not configured or set to view in controller'));
        }
        $config = $this->_View->viewVars["DataTables"][$name];
        $this->wasRendered[] = $name;
        $options['id'] = $config['id'];
        $options += [
            'width' => '100%',
            'cellspacing' => 0,
            'class' => 'display'
        ];

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
        $this->json = $this->_View->viewVars['resultInfo'];
        $this->json['data'] = $data;
        echo json_encode($this->json, JSON_PRETTY_PRINT);
    }

    /**
     * If exists config for current request generate datatables js code
     * @return null|string|string[]
     */
    public function setJs()
    {
        if (!empty($this->_View->viewVars["DataTables"])) {
            $readyFunctionContent = "";
            foreach ($this->wasRendered as $item) {
                $config = $this->_View->viewVars["DataTables"][$item];

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
                    $url = $config['urls'][$config['trait']] + [$item];
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
