# JustGiving API SDK
A PHP SDK for communicating with the JustGiving API. Based on the [original SDK](https://github.com/JustGiving/JustGiving.Api.Sdk) by [JustGiving _et al_](https://github.com/JustGiving/JustGiving.Api.Sdk/graphs/contributors).

## Quick Start
```php
$guzzleClient = GuzzleClientFactory::build('https://api.justgiving.com/', 'abcde1f2g', 1, 'user@example.com', 'myPassword');
$client = new JustGivingClient($guzzleClient);
```

```php
$response = $client->account->isEmailRegistered('test@example.com');

if ($response->existenceCheck()) {
    echo 'An account has been registered with that email.';
}
```

```php
$response = $client->charity->getById(2050);

if ( ! $response->wasSuccessful()) {
    throw new Exception(implode(', ', $response->errors));
}

$response->name;          // 'The Demo Charity1'
$response->websiteUrl;    // 'http://www.democharity.co.uk'
$response->pageShortName; // 'jgdemo'
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

#### Models
Some API actions (e.g. creating or updating resources) require a set of data grouped together in an object.
To achieve this, a model class has been defined for each separate occasion when this is necessary, for example `Team` or `JoinTeamRequest`.
These model classes all extend the parent `Model` class, which adds some useful functionality.

Data can be added to a model in several ways: it can be passed to the constructor as an array, passed to the `fill()` method as an array, or each property can be set individually.
The `fill()` method may be used multiple times to set different properties, and will only override existing properties if they are explicitly passed in as an array item.
```php
// Data set via constructor
$team = new Team([
    'name'      => 'My Team',
    'story'     => 'This is my story',
    'target'    => 1000,
]);

// Data set via fill() method
$team = new Team;
$team->fill([
    'name'      => 'My Team',
    'story'     => 'This is my story',
    'target'    => 1000,
]);

// Data set by setting public properties individually
$team = new Team;
$team->name = 'My Team';
$team->story = 'This is my story';
$team->target = 1000;
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
$response->body;                         // Returns the decoded response
```
From here, the response data is represented by arrays or objects of type `StdClass` which contain the data we want to use.
```php
$result = $client->charity->getById(2050);
$result->body->name;            // 'The Demo Charity1'
$result->body->websiteUrl;      // 'http://www.democharity.co.uk'
$result->body->pageShortName;   // 'jgdemo'
```
The response class also allows body properties to be called directly on itself, i.e. the following is also valid:
```php
$result = $client->charity->getById(2050);
$result->name;                  // 'The Demo Charity1'
$result->websiteUrl;            // 'http://www.democharity.co.uk'
$result->pageShortName;         // 'jgdemo'
```

#### Errors
The API provides two formats of error message(s): the first is a general error message relating to the whole request (e.g. `That email address is already in use`), 
and the second is a list of error messages that relate to problems with specific parts of the request or data, with an identifier and description (e.g. ID: `FirstNameNotSpecified`, description `The FirstName field is required.`).

In the API documentation, the former is referred to as being the `errorMessage` property, and the latter refers to errors contained in `Error` objects (with properties `Error.id` and `Error.desc`).

Errors can be accessed via the `errors` property of the response object, which presents any errors present in a unified array format of `$identifier => $description`.
If there is a general error, it is given the identifier `General` and added to the array like any other error.
The reason phrase given with the response (accessible via the `getReasonPhrase()` method) is added to the errors array and given the identifier `ReasonPhrase`.

For example:
```php
$response = $this->client->account->create(new CreateAccountRequest([
    'email'     => "john@example.com",
    'firstName' => "John",
    'lastName'  => "Smith",
    'password'  => 'password',
    'title'     => "Mr",
    'address' => new Address([
       'line1'             => "testLine1",
       'line2'             => "testLine2",
       'country'           => "United Kingdom",
       'countyOrState'     => "testCountyOrState",
       'townOrCity'        => "testTownOrCity",
       'postcodeOrZipcode' => "M130EJ",
    ]),

    'acceptTermsAndConditions' => false
]));

$errors = $response->errors;
// $errors is:
// [
//    'ReasonPhrase'                        => 'Validation errors occured.',
//    'FirstNameNotSpecified'               => 'The FirstName field is required.',
//    'AcceptTermsAndConditionsMustBeTrue'  => 'You must agree to the terms and conditions'
// ]
```
Now, say we correctly created that account and went to create a new account with the same email:
```php
$response = $this->client->account->create(new CreateAccountRequest([
    'email'     => "john@example.com",
    'firstName' => "John",
    'lastName'  => "Smith",
    'password'  => 'password',
    'title'     => "Mr",
    'address' => new Address([
       'line1'             => "testLine1",
       'line2'             => "testLine2",
       'country'           => "United Kingdom",
       'countyOrState'     => "testCountyOrState",
       'townOrCity'        => "testTownOrCity",
       'postcodeOrZipcode' => "M130EJ",
    ]),

    'acceptTermsAndConditions' => true
]));

$errors = $response->errors;
// $errors is:
// [
//    'ReasonPhrase'    => 'Bad request',
//    'General'         => 'That email address is already in use'
// ]
```

#### Response helper methods
There are a couple of helper methods on the response to make some API calls and validation easier:
* `$response->wasSuccessful()` – returns true if the response has a status code of 2xx.
* `$response->hasErrorMessages()` – returns true if the response has any error messages.
    **Note**: Some API actions do not return any error messages upon failure.
    This flag should be used to determine whether there is any useful error information to display, not to check if the action succeeded (use `wasSuccessful()` instead).
* `$response->existenceCheck()` – returns true if the response had a status code of 200, false if the status code is 404, and throws an exception otherwise.
    Useful for API calls that check for the existence of a resource.
