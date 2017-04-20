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
        $result = $this->childApi->MethodOneAlias();

        $this->assertEquals('Method One', $result);
    }

    /** @test */
    public function a_client_method_can_have_multiple_aliases()
    {
        $result = $this->childApi->MethodTwoAliasOne();
        $resultTwo = $this->childApi->MethodTwoAliasTwo();

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

    /** @test */
    public function a_method_alias_can_be_called_in_any_case()
    {
        $resultOne = $this->childApi->method_one_Alias();
        $resultTwo = $this->childApi->methodTwoAliasOne();

        $this->assertEquals('Method One', $resultOne);
        $this->assertEquals('Method Two', $resultTwo);
    }
}

class BaseClientChild extends BaseClient
{
    protected $aliases = [
        'methodOne' => 'MethodOneAlias',
        'methodTwo' => ['MethodTwoAliasOne', 'MethodTwoAliasTwo'],
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
