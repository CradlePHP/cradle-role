<?php //-->
/**
 * This file is part of a package designed for the CradlePHP Project.
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

use PHPUnit\Framework\TestCase;

use Cradle\Http\Request;
use Cradle\Http\Response;

/**
 * Event test
 *
 * @vendor   Cradle
 * @package  Model
 * @author   John Doe <john@acme.com>
 */
class Cradle_Role_EventsTest extends TestCase
{
    /**
     * @var Request $request
     */
    protected $request;

    /**
     * @var Request $response
     */
    protected $response;

    /**
     * @var int $id
     */
    protected static $id;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->request = new Request();
        $this->response = new Response();

        $this->request->load();
        $this->response->load();
    }

    /**
     * role-create
     *
     * @covers Cradle\Module\System\Model\Validator::getCreateErrors
     * @covers Cradle\Module\System\Model\Validator::getOptionalErrors
     * @covers Cradle\Module\System\Model\Service\SqlService::create
     * @covers Cradle\Module\System\Utility\Service\AbstractElasticService::create
     * @covers Cradle\Module\System\Utility\Service\AbstractRedisService::createDetail
     */
    public function testRoleCreate()
    {
        $this->request->setStage([
            'schema' => 'role',
            'role_name' => 'Test',
            'role_permissions' => [
                'path' => '(?!/admin)/**', 
                'label' => 'Test Access', 
                'method' => 'all'
            ]
        ]);

        cradle()->trigger('role-create', $this->request, $this->response);

        $this->assertEquals('Test', $this->response->getResults('role_name'));
        self::$id = $this->response->getResults('role_id');
        $this->assertTrue(is_numeric(self::$id));
    }

    /**
     * role-create
     *
     * @covers Cradle\Module\System\Model\Validator::getCreateErrors
     * @covers Cradle\Module\System\Model\Validator::getOptionalErrors
     * @covers Cradle\Module\System\Model\Service\SqlService::create
     * @covers Cradle\Module\System\Utility\Service\AbstractElasticService::create
     * @covers Cradle\Module\System\Utility\Service\AbstractRedisService::createDetail
     */
    public function testRoleDetail()
    {
        $this->request->setStage([
            'schema' => 'role',
            'role_id' => 1
        ]);

        cradle()->trigger('role-detail', $this->request, $this->response);
        $this->assertEquals(1, $this->response->getResults('role_id'));
    }

    /**
     * role-remove
     *
     * @covers Cradle\Module\System\Model\Service\SqlService::get
     * @covers Cradle\Module\System\Model\Service\SqlService::update
     * @covers Cradle\Module\System\Utility\Service\AbstractElasticService::remove
     * @covers Cradle\Module\System\Utility\Service\AbstractRedisService::removeDetail
     */
    public function testRoleRemove()
    {
        $this->request->setStage([
            'schema' => 'role',
            'role_id' => self::$id
        ]);

        cradle()->trigger('role-remove', $this->request, $this->response);
        $this->assertEquals(self::$id, $this->response->getResults('role_id'));
    }

    /**
     * role-restore
     *
     * @covers Cradle\Module\System\Model\Service\SqlService::get
     * @covers Cradle\Module\System\Model\Service\SqlService::update
     * @covers Cradle\Module\System\Utility\Service\AbstractElasticService::remove
     * @covers Cradle\Module\System\Utility\Service\AbstractRedisService::removeDetail
     */
    public function testRoleRestore()
    {
        $this->request->setStage([
            'schema' => 'role',
            'role_id' => self::$id
        ]);

        cradle()->trigger('role-restore', $this->request, $this->response);
        $this->assertEquals(self::$id, $this->response->getResults('role_id'));
    }

    /**
     * role-search
     *
     * @covers Cradle\Module\System\Model\Service\SqlService::search
     * @covers Cradle\Module\System\Model\Service\ElasticService::search
     * @covers Cradle\Module\System\Utility\Service\AbstractRedisService::getSearch
     */
    public function testRoleSearch()
    {
        $this->request->setStage([
            'schema' => 'role'
        ]);

        cradle()->trigger('role-search', $this->request, $this->response);
        $this->assertEquals(1, $this->response->getResults('rows', 0, 'role_id'));
    }

    /**
     * role-update
     *
     * @covers Cradle\Module\System\Model\Service\SqlService::get
     * @covers Cradle\Module\System\Model\Service\SqlService::update
     * @covers Cradle\Module\System\Utility\Service\AbstractElasticService::remove
     * @covers Cradle\Module\System\Utility\Service\AbstractRedisService::removeDetail
     */
    public function testRoleUpdate()
    {
        $this->request->setStage([
            'schema' => 'role',
            'role_id' => self::$id,
            'role_name' => 'New Test Name'
        ]);

        cradle()->trigger('role-update', $this->request, $this->response);
        $this->assertEquals('New Test Name', $this->response->getResults('role_name'));
        $this->assertEquals(self::$id, $this->response->getResults('role_id'));
    }

    /**
     * access-search
     *
     * @covers Cradle\Module\System\Utility\Service\AbstractElasticService::remove
     * @covers Cradle\Module\System\Utility\Service\AbstractRedisService::removeDetail
     */
    public function testAccessSearch()
    {
        cradle()->trigger('access-search', $this->request, $this->response);
        $actual = $this->response->getResults();

        $this->assertArrayHasKey('rows', $this->response->getResults());
        $this->assertArrayHasKey('total', $this->response->getResults());
    }

    /**
     * access-link
     *
     * @covers Cradle\Module\System\Utility\Service\AbstractElasticService::remove
     * @covers Cradle\Module\System\Utility\Service\AbstractRedisService::removeDetail
     */
    public function testAccessLink()
    {
        $this->request->setStage([
            'role' => [
                'role_id' => self::$id,
                'auth_id' => 1
            ]
        ]);

        cradle()->trigger('access-link', $this->request, $this->response);
        $actual = $this->response->getResults();

        $this->assertTrue(!empty($actual));
    }

    /**
     * access-link
     *
     * @covers Cradle\Module\System\Utility\Service\AbstractElasticService::remove
     * @covers Cradle\Module\System\Utility\Service\AbstractRedisService::removeDetail
     */
    public function testRoleAuthDetail()
    {
        $this->request->setStage([
            'auth_id' => 1
        ]);

        cradle()->trigger('auth-detail', $this->request, $this->response);
        $actual = $this->response->getResults();

        $this->assertEquals(1, $actual['auth_id']);
        $this->assertEquals(self::$id, $actual['role_id']);
    }

    /**
     * access-link
     *
     * @covers Cradle\Module\System\Utility\Service\AbstractElasticService::remove
     * @covers Cradle\Module\System\Utility\Service\AbstractRedisService::removeDetail
     */
    public function testAccessUnlink()
    {
        $this->request->setStage([
            'role_id' => self::$id,
            'role_auth_id' => 1
        ]);

        cradle()->trigger('access-unlink', $this->request, $this->response);
        $actual = $this->response->getResults();

        $this->assertTrue(!empty($actual));
    }
}
