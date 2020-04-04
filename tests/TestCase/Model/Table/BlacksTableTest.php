<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BlacksTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BlacksTable Test Case
 */
class BlacksTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\BlacksTable
     */
    public $Blacks;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Blacks',
        'app.Owners',
        'app.Users',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Blacks') ? [] : ['className' => BlacksTable::class];
        $this->Blacks = TableRegistry::getTableLocator()->get('Blacks', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Blacks);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
