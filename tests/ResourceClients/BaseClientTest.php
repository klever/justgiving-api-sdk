<?php

namespace Konsulting\JustGivingApiSdk\Tests\ResourceClients;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Konsulting\JustGivingApiSdk\ResourceClients\BaseClient;
use Mockery;
use ReflectionClass;

class BaseClientTest extends ResourceClientTestCase
{
    protected static $childApi;

    protected $childClients = [
        'Account',
        'Campaign',
        'Charity',
        'Countries',
        'Currency',
        'Donation',
        'Event',
        'Fundraising',
        'Leaderboard',
        'OneSearch',
        'Project',
        'Search',
        'Sms',
        'Team',
    ];

    public function setUp()
    {
        parent::setUp();
        static::$childApi = static::$childApi ?: new BaseClientChild($this->guzzleClient);
    }

    public function tearDown()
    {
        Mockery::close();
    }

    /** @test */
    public function all_method_aliases_refer_to_actual_methods()
    {
        // Cycle through all API client classes
        foreach ($this->childClients as $childClient) {
            $className = '\\Konsulting\\JustGivingApiSdk\\ResourceClients\\' . $childClient . 'Client';
            $object = new $className($this->client);

            // Get the protected alias properties via reflection
            $aliases = $this->exposeProperty($object, 'aliases');

            foreach ($aliases as $method => $alias) {
                $this->assertTrue(method_exists($object, $method),
                    "The method `{$method}` does not exist on " . get_class($object));
            }
        }
    }

    /**
     * Use Reflection to obtain the value of a property on an object.
     *
     * @param object $object
     * @param string $propertyName
     * @return mixed
     */
    protected function exposeProperty($object, $propertyName)
    {
        $property = (new ReflectionClass($object))->getProperty($propertyName);
        $property->setAccessible(true);

        return $property->getValue($object);
    }

    /** @test */
    public function a_client_method_can_have_one_alias()
    {
        $result = static::$childApi->MethodOneAlias();

        $this->assertEquals('Method One', $result);
    }

    /** @test */
    public function a_client_method_can_have_multiple_aliases()
    {
        $nullResult = static::$childApi->notAnAlias();
        $result = static::$childApi->MethodTwoAliasOne();
        $resultTwo = static::$childApi->MethodTwoAliasTwo();

        $this->assertNull($nullResult);
        $this->assertEquals('Method Two', $result);
        $this->assertEquals('Method Two', $resultTwo);
    }

    /** @test */
    public function a_client_method_can_be_called_in_any_case()
    {
        $resultOne = static::$childApi->METHOD_ONE();
        $resultTwo = static::$childApi->MethodOne();
        $resultThree = static::$childApi->method_two();

        $this->assertEquals('Method One', $resultOne);
        $this->assertEquals('Method One', $resultTwo);
        $this->assertEquals('Method Two', $resultThree);
    }

    /** @test */
    public function a_method_alias_can_be_called_in_any_case()
    {
        $resultOne = static::$childApi->method_one_Alias();
        $resultTwo = static::$childApi->methodTwoAliasOne();

        $this->assertEquals('Method One', $resultOne);
        $this->assertEquals('Method Two', $resultTwo);
    }

    /** @test */
    public function the_content_type_can_be_manually_set_when_posting_a_file()
    {
        $handler = HandlerStack::create(new MockHandler([
            new Response(200),
        ]));
        $httpClient = new MockHttpClient(['handler' => $handler]);
        $baseClient = new BaseClientChild($httpClient);

        $baseClient->postFile('test', __DIR__ . '/../img/jpg.jpg', 'some content type');

        $this->assertEquals(['Content-Type' => 'some content type'], $httpClient->options['headers']);
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

    public function postFile($uri, $filename, $contentType = null)
    {
        return parent::postFile($uri, $filename, $contentType);
    }
}

class MockHttpClient extends Client
{
    public $options;

    public function post($uri, array $options = [])
    {
        $this->options = $options;

        return parent::request('post', $uri, $options);
    }
}
