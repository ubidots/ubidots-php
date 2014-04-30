===================================
Ubidots PHP API Client
===================================

Installation
------------

Install with Composer
---------------------
Ubidots for php is available for install with `Composer <https://github.com/composer/composer/>`_., you can add Ubidots with it.

.. code-block:: json

    {
        "require": {
            "ubidots/ubidots": "dev-master"
        }
    }


Connecting to the API
----------------------

Before playing with the API you must be able to connect to it using your private API key, which can be found `in your profile <http://app.ubidots.com/userdata/api/>`_.

If you don't have an account yet, you can `create one here <http://app.ubidots.com/accounts/signup/>`_.

Once you have your API key, you can connect to the API by creating an ApiClient instance. Let's assume your API key is: "7fj39fk3044045k89fbh34rsd9823jkfs8323". Then your code would look like this:


.. code-block:: php

	require 'vendor/autoload.php';
	
	$api = new Ubidots\ApiClient($apikey="ffe22112fdd1c55f0f3969169f3d3f37b1ad0997");


Now you have an instance of ApiClient ("api") which can be used to connect to the API service.

Saving a new Value to a Variable
--------------------------------

Retrieve the variable you'd like the value to be saved to:

.. code-block:: php
    
    $my_variable = $api->get_variable('56799cf1231b28459f976417')

Given the instantiated variable, you can save a new value with the following line:

.. code-block:: php

    $new_value = $my_variable->save_value( array('value'=> 10) );

You can also specify a timestamp (optional):

.. code-block:: php

    $new_value = $my_variable->save_value( array('value'=> 10, 'timestamp'=> 1376061804407) );

If no timestamp is specified, the API server will assign the current time to it. We think it's always better for you to specify the timestamp so the record reflects the exact time the value was captured, not the time it arrived to our servers.