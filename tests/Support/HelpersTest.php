<?php

namespace Klever\JustGivingApiSdk\Tests\Support;

use Carbon\Carbon;
use DateTime;
use Klever\JustGivingApiSdk\Support\Helpers;
use Klever\JustGivingApiSdk\Tests\TestCase;

class HelpersTest extends TestCase
{
    /** @test */
    public function it_converts_an_epoch_date_to_carbon()
    {
        $date = Helpers::dateToCarbon('/Date(1365004652303-0500)/');

        $this->assertInstanceOf(Carbon::class, $date);
        $this->assertEquals('2013-04-03 15:57:32', $date->__toString());
    }

    /** @test */
    public function it_converts_a_string_date_to_carbon()
    {
        $date = Helpers::dateToCarbon('2013-04-03 15:57:32');

        $this->assertInstanceOf(Carbon::class, $date);
        $this->assertEquals('2013-04-03 15:57:32', $date->__toString());
    }

    /** @test */
    public function it_converts_a_datetime_instance_to_carbon()
    {
        $date = Helpers::dateToCarbon(new DateTime('2013-04-03 15:57:32'));

        $this->assertInstanceOf(Carbon::class, $date);
        $this->assertEquals('2013-04-03 15:57:32', $date->__toString());
    }

    /** @test */
    public function it_allows_a_carbon_instance_to_be_passed_into_the_date_to_carbon_function()
    {
        $date = Helpers::dateToCarbon(Carbon::parse('2013-04-03 15:57:32'));

        $this->assertEquals(Carbon::parse('2013-04-03 15:57:32'), $date);
    }

    /** @test */
    public function it_returns_null_if_a_non_string_or_datetime_instance_is_passed_in()
    {
        $result = Helpers::dateToCarbon(1);

        $this->assertNull($result);
    }
}
