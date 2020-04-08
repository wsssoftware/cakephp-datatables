<?php
declare(strict_types=1);

namespace DataTables\Test\TestCase\View\Helper;

use Cake\TestSuite\TestCase;
use Cake\View\View;
use DataTables\View\Helper\DataTablesHelper;

/**
 * DataTables\View\Helper\DataTablesHelper Test Case
 */
class DataTablesHelperTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \DataTables\View\Helper\DataTablesHelper
     */
    protected $DataTables;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $view = new View();
        $this->DataTables = new DataTablesHelper($view);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->DataTables);

        parent::tearDown();
    }
}
