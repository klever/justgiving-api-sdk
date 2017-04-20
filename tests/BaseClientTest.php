<?php

namespace Klever\JustGivingApiSdk\Tests;

use Klever\JustGivingApiSdk\Clients\BaseClient;

class BaseClientTest extends Base
{
    protected $childApi;

    public function setUp()
    {
        $this->childApi = new BaseClientChild($this->guzzleClient);
    }
    
    /** @test */
    public function a_client_method_can_have_one_alias()
    {
        $result = $this->childApi->methodOneAlias();

        $this->assertEquals('Method One', $result);
    }

    /** @test */
    public function a_client_method_can_have_multiple_aliases()
    {
        $result = $this->childApi->methodTwoAliasOne();
        $resultTwo = $this->childApi->methodTwoAliasTwo();

        $this->assertEquals('Method Two', $result);
        $this->assertEquals('Method Two', $resultTwo);
    }

    /** @test */
    public function a_client_method_can_be_called_in_any_case()
    {
        $resultOne = $this->childApi->METHOD_ONE();
        $resultTwo = $this->childApi->MethodOne();
        $resultThree = $this->childApi->method_two();

        $this->assertEquals('Method One', $resultOne);
        $this->assertEquals('Method One', $resultTwo);
        $this->assertEquals('Method Two', $resultThree);
    }
}

class BaseClientChild extends BaseClient
{
    protected $aliases = [
        'methodOne' => 'methodOneAlias',
        'methodTwo' => ['methodTwoAliasOne', 'methodTwoAliasTwo'],
    ];

    public function methodOne()
    {
        return 'Method One';
    }

    public function methodTwo()
    {
        return 'Method Two';
    }
}
