# JustGiving API SDK
A PHP SDK for communicating with the JustGiving API. Based on the [original SDK](https://github.com/JustGiving/JustGiving.Api.Sdk) by [JustGiving _et al_](https://github.com/JustGiving/JustGiving.Api.Sdk/graphs/contributors).

## Quick Start
```php
$guzzleClient = GuzzleClientFactory::build('https://api.justgiving.com/', 'abcde1f2g', 1, 'user@example.com', 'myPassword');
$client = new JustGivingClient($guzzleClient);

$result = $client->account->IsEmailRegistered('test@example.com'); // True or false

$result = $client->charity->GetCharityById(2050);
$result->name;          // 'The Demo Charity1'
$result->websiteUrl;    // 'http://www.democharity.co.uk'
$result->pageShortName; // 'jgdemo'
```

See the [JustGiving API documentation](https://api.justgiving.com/docs) for more information.

## Usage
### Setup
The `JustGivingClient` should be instantiated with a suitable HTTP client passed in as a parameter. This client must adhere to the [PSR-7 interfaces](http://www.php-fig.org/psr/psr-7/), and should return from requests an instance of `JustGivingApiSdk\Support\Response`.
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
The SDK defines a separate API class for each resource as define by the [API documentation](https://api.justgiving.com/docs), and each of those classes contain methods that correspond to API actions.
To get a resource class, call the name of the resource as a property on the `$client` we built up earlier, for example `$client->account` or `$client->charity`. The relevant method is then called on top of that.

#### Method aliases
The actual methods on the class are named in camelCase and are often shortened from the original API action for brevity.
However, there are aliases defined for every resource class so that the API action names may be used to interact with the SDK.

For example, both of these examples will work to get the status of a donation:
```php
$client->donation->getStatus($donationId);                  // The actual method

$client->donation->RetrieveDonationStatus($donationId);     // The alias method that's the same as the API action name
```

### Working with responses
The SDK returns an instance of `JustGivingApiSdk\Support\Response` from each request.
This implements the PSR-7 `ResponseInterface` and so allows access to the full HTTP response received by the client.

#### Response body
The raw response body can be accessed via 
```php 
$response->getBody()->getContents()     // Returns the raw JSON response
```
However, the API returns JSON and so this method can prove to be an inefficient way of working with data.
If `body` is accessed as a property on the response, the decoded JSON body is returned.
```php 
$response->body                         // Returns the decoded response
```
From here, the response data is represented by arrays or objects of type `StdClass` which contain the data we want to use.
```php
$result = $client->charity->GetCharityById(2050);
$result->body->name;            // 'The Demo Charity1'
$result->body->websiteUrl;      // 'http://www.democharity.co.uk'
$result->body->pageShortName;   // 'jgdemo'
```
The response class also allows body properties to be called directly on itself, i.e. the follow is also valid:
```php
$result = $client->charity->GetCharityById(2050);
$result->name;                  // 'The Demo Charity1'
$result->websiteUrl;            // 'http://www.democharity.co.uk'
$result->pageShortName;         // 'jgdemo'
```

#### Response helper methods
There are a couple of helper methods on the response to make some API calls and validation easier:
* `$response->wasSuccessful()` – returns true if the response has a status code of 2xx
* `$response->existenceCheck()` – returns true if the response had a status code of 200, false if status code 404, and throws an exception otherwise.
Useful for API calls that check for the existence of a resource.
