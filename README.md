# JustGiving API SDK
A PHP SDK for communicating with the JustGiving API. Based on the [original SDK](https://github.com/JustGiving/JustGiving.Api.Sdk) by [JustGiving _et al_](https://github.com/JustGiving/JustGiving.Api.Sdk/graphs/contributors).

## Quick Start
```php
$guzzleClient = GuzzleClientFactory::build('https://api.justgiving.com/', 'abcde1f2g', 1, 'user@example.com', 'myPassword');
$client = new JustGivingClient($guzzleClient);

$result = $client->account->IsEmailRegistered('test@example.com'); // True or false

$result = $client->charity->Retrieve(2050);
$result->name;          // 'The Demo Charity1'
$result->websiteUrl;    // 'http://www.democharity.co.uk'
$result->pageShortName; // 'jgdemo'
```

See the [JustGiving API documentation](https://api.justgiving.com/docs) for more usage.

## Usage
### Setup
The `JustGivingClient` should be instantiated with a suitable HTTP client passed in as a parameter. This client must adhere to the [PSR-7 interfaces](http://www.php-fig.org/psr/psr-7/), as well as the methods defined in the `JustGivingApiSdk\Support\Response` class.
This class implements the PSR-7 `ResponseInterface` and adds support for dealing with JSON responses, as well as making it easy to access response data. 

There is a helper class `GuzzleClientFactory`, that will create a correctly configured [Guzzle](http://docs.guzzlephp.org/en/latest/) client ready to be passed in. The usage of this is:

```php
$guzzleClient = GuzzleClientFactory::build($rootDomain, $apiKey, $apiVersion, $username = '', $password = '', $options = []);
```
For example:
```php
$guzzleClient = GuzzleClientFactory::build('https://api.justgiving.com/', 'abcde1f2g', 1, 'user@example.com', 'myPassword', ['debug' => true]);

$client = new JustGivingClient($guzzleClient);
```
The `options` array is optional, and is merged with the existing configuration to allow for customisation of the Guzzle client configuration (e.g. turning on debug mode as above).

### Querying the API
The SDK follows the structure of the [API documentation](https://api.justgiving.com/docs): the name of the resource is called as a property on the `JustGivingClient`, and the API method is called as a method on top of that.
For example, to check if an email has been registered:
```php
$client->account->IsEmailRegistered($email);
```
