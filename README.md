# JustGiving API SDK
A PHP SDK for communicating with the JustGiving API. Based on the [original SDK](https://github.com/JustGiving/JustGiving.Api.Sdk) by [JustGiving _et al_](https://github.com/JustGiving/JustGiving.Api.Sdk/graphs/contributors).

## Usage
The `JustGivingClient` should be instantiated with a suitable HTTP client passed in as a parameter. This client must adhere to the PSR-7 interfaces, as well as the methods defined in the `JustGivingApiSdk\Support\Response` class, which implements the PSR-7 `ResponseInterface` and adds support for dealing with JSON responses, as well as making it easy to access response data. 

There is a helper class `GuzzleClientFactory`, that will create a correctly configured client ready to be passed in. The usage of this is:

```php
$guzzleClient = GuzzleClientFactory::build($rootDomain, $apiKey, $apiVersion, $username = '', $password = '', $options = []);
```
For example:
```php
$guzzleClient = GuzzleClientFactory::build('https://api.justgiving.com/', 'abcde1f2g', 1, 'user@example.com', 'myPassword', ['debug' => true]);

$client = new JustGivingClient($guzzleClient);
```
The `options` array is optional, and is merged with the existing configuration to allow for customisation of the Guzzle client configuration (e.g. turning on debug mode as above).
