Chaplean Rest-Client-Bundle
===========================
[![Codeship Status for chaplean/rest-client-bundle](https://app.codeship.com/projects/3fe51760-76ca-0135-4402-1639b58199d0/status?branch=master)](https://app.codeship.com/projects/244562)
[![Coverage Status](https://coveralls.io/repos/bitbucket/chaplean/rest-client-bundle/badge.svg?branch=master)](https://coveralls.io/bitbucket/chaplean/rest-client-bundle?branch=master)

# Prerequisites

This version of the bundle requires Symfony 2.8+.

# Installation

## 1. Composer

```bash
composer require chaplean/rest-client-bundle
```

## 2. AppKernel.php

Add
```php
new EightPoints\Bundle\GuzzleBundle\EightPointsGuzzleBundle(),
new Chaplean\Bundle\RestClientBundle\ChapleanRestClientBundle(),

// If you want to enable Database logging
new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),

// If you want to enable Email logging
new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
new Symfony\Bundle\TwigBundle\TwigBundle()
```

## 3. config.yml and parameters.yml

First you will need to configure guzzlehttp that we use under the hood to perform the actual http
requests. See the [bundle](https://github.com/8p/EightPointsGuzzleBundle) documentation or the [library](http://docs.guzzlephp.org/en/latest/request-options.html) documentation for full range
of options. Example:

config.yml
```yaml
eight_points_guzzle:
    logging: true
    clients:
        fake_api:
            # We inject guzzle configuration from parameters.yml but we could hardcode it here
            options: %fake_api.options%
```

You will probably also want to create some custom parameters.

parameters.yml
```yaml
parameters:
    # Guzzle configuration
    fake_api.options:
        timeout: 10
        verify: false
        expect: false
        
    # Your custom configuration, here we just define the base url of our fake_api
    fake_api.url: 'http://fakeapi.com/'
```

As you inject guzzle in your Api class you can have different configuration per Api. See next section.

Next this bunde expose some configuration if you want to enable extra features. You can enable database and / or email logging of requests.
To use the database or email loggers you will have to setup respectively [doctrine](https://symfony.com/doc/current/doctrine.html) or [swiftmailer](https://symfony.com/doc/current/email.html) in your project.
The default configuraton is:

config.yml
```yaml
chaplean_rest_client:
    enable_database_logging: false
    enable_email_logging: false
    email_logging:
        # Limit emails to the specified codes.
        # You can either use a code directly like 200, 404, …
        # or use XX to say all codes in the familly like 5XX to say all server errors.
        # 0 means that the request failed to run (either because of invalid parameters or a networking error)
        codes_listened: ['0', '1XX', '2XX', '3XX', '4XX', '5XX']
        address_from: ~
        address_to:   ~
```

You can override the default email content by overriding the translation keys or even the email body twig template.
The translation keys are under `chaplean_rest_client.email.request_executed_notification` and the template is `Resources/views/Email/request_executed_notification.txt.twig`.

# Usage

## Creating Api class

To use rest-client-bundle you have to create a class extending AbstractApi. You can create any number of classes extending AbstractApi and have all of them using different
configurations via dependency injection.

```php
<?php

use Chaplean\Bundle\RestClientBundle\Api\AbstractApi;
use Chaplean\Bundle\RestClientBundle\Api\Parameter;
use GuzzleHttp\ClientInterface;

class FakeApi extends AbstractApi
{
    protected $url;

    /**
     * AbstractApi required you to pass it a GuzzleHttp\ClientInterface, we also inject the base api of our fake_api
     */
    public function __construct(ClientInterface $client, $url)
    {
        parent::__construct($client);

        $this->url = $url;
    }

    /**
     * We define our api here, we'll dig into this in the next section
     */
    public function buildApi()
    {
        $this->globalParameters()
            ->urlPrefix($this->url) // here we set base url
            ->expectsJson();

        $this->get('fake_get', 'fake')
            ->urlParameters([
                'id' => Parameter::id(),
            ]);
    }
}
```

```yaml
services:
    app_rest.api.fake:
        class: App\Bundle\RestBundle\Api\FakeApi
        arguments:
            - '@guzzle.client.fake_api' # Guzzle client we defined in config.yml
            - '%fake_api.url%'          # the base url of fake_api
```

And we're done! We could repeat this process to create another Api with completely different configurations.

## Defining Api

Let's focus on the ```buildApi()``` function you have to fill in and what we can do in it.
The role of this function is to define your Api using rest-client-bundle api:

```php
<?php

public function buildApi()
{
    /*
     * You have to call this function first to set basic config
     */
    $this->globalParameters()
        ->urlPrefix('http://some.url/')  // set the base url of our api

    /*
     * We can then set some configurations that will be the default for every route we create later.
     * You have the exact same api available here and available when configuring routes.
     * See route definition for detailed descriptions of headers(), urlParameters(), queryParameters() and requestParameters()
     */
        ->expectsPlain()                 // Declare we expect responses to be plain text
        ->expectsJson()                  // Declare we expect responses to be json
        ->expectsXml()                   // Declare we expect responses to be xml

        ->sendFormUrlEncoded()           // Configure that we post our data as classic form url encoded  (only apply to post, put and patch requests)
        ->sendJson()                     // Configure that we post our data as json (only apply to post, put and patch requests)
        ->sendXml()                      // Configure that we post our data as xml (only apply to post, put and patch requests)
        ->sendJSONString()               // Configure that we post our data as a url-encoded key-value pair where the key is JSONString and the value is the request data in json format (only apply to post, put and patch requests)

        ->headers([])                    // Configure what headers we send
        ->urlParameters([])              // Configure what url placeholders we define
        ->queryParameters([])            // Configure what query strings we send
        ->requestParameters([]);         // Configure what post data we send (only apply to post, put and patch requests)

    /*
     * Here we define the core of our api, the routes. We can use get(), post(), put(), patch(), delete() functions
     * with a route name and a route url (with placeholders in you want) to define routes.
     */
    $this->get('query_one', 'data/{id}');
    $this->post('create_one', 'data');
    $this->patch('update_one', 'data/{id}');
    $this->put('update_one', 'data/{id}');
    $this->delete('delete_one', 'data/{id}');

    /*
     * Those function return the route object to further configure it.
     * As said previously the route api is the same as the one we get with globalParameters().
     */
    $this->post('create_one', 'data/{id}')
        ->expectsPlain()                 // Declare we expect responses to be plain text
        ->expectsJson()                  // Declare we expect responses to be json
        ->expectsXml()                   // Declare we expect responses to be xml

        ->sendFormUrlEncoded()           // Configure that we post our data as classic form url encoded  (only apply to post, put and patch requests)
        ->sendJson()                     // Configure that we post our data as json (only apply to post, put and patch requests)
        ->sendXml()                      // Configure that we post our data as xml (only apply to post, put and patch requests)
        ->sendJSONString()               // Configure that we post our data as a url-encoded key-value pair where the key is JSONString and the value is the request data in json format (only apply to post, put and patch requests)

        ->headers([])                    // Configure what headers we send
        ->urlParameters([])              // Configure what url placeholders we define
        ->queryParameters([])            // Configure what query strings we send
        ->requestParameters([]);         // Configure what post data we send (only apply to post, put and patch requests)

    /*
     * Finally calling headers(), urlParameters(), queryParameters() or requestParameters() without configuring parameters is sort of useless.
     * So let's see how to define parameters.
     */
    $this->put('update_data', 'data/{id}')
        ->urlParameters(                 // Define the placeholder parameter for the {id} in the url
            [
                'id' => Parameter::id(),
            ]
        )
    /**
     * We define a list of key => values pairs where key is the name of the parameter and the value is a parameter type.
     * We can also configure the parameters type. They all support at least optional(), defaultValue().
     */
        ->requestParameters(
            [
                'name'     => Parameter::string(),
                'birthday' => Parameter::dateTime('Y-m-d'),
                'is_human' => Parameter::bool()->defaultValue(true),
                'height'   => Parameter::int(),
                'weight'   => Parameter::float()->optional(),
                'tags'     => Parameter::object(
                    [
                        'id'   => Parameter::id(),
                        'name' => Parameter::string(),
                    ]
                ),
                'friends'  => Parameter::arrayList(Parameter::id()),
            ]
        );
}
```
