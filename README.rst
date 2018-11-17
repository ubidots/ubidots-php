===================================
Ubidots PHP API Client
===================================

The Ubidots PHP API Client makes calls to the `Ubidots Api <http://things.ubidots.com/api>`_. 

Installation
------------

Install with Composer
---------------------
Ubidots for php is available for install with `Composer <https://github.com/composer/composer/>`_:

.. code-block:: json

    {
        "require": {
            "ubidots/ubidots": "dev-master"
        }
    }


Connecting to the API
----------------------

Before playing with the API you should connect to it using your private API key, which can be found `in your profile <http://app.ubidots.com/userdata/api/>`_.

If you don't have an account yet, you can `create one here <http://app.ubidots.com/accounts/signup/>`_.

Once you have your API key, you can connect to the API by creating an ApiClient instance. Let's assume your API key is: "7fj39fk3044045k89fbh34rsd9823jkfs8323". Then your code would look like this:


.. code-block:: php

	require 'vendor/autoload.php';
	
	$api = new Ubidots\ApiClient($apikey="7fj39fk3044045k89fbh34rsd9823jkfs8323");


Now you have an instance of ApiClient ("api") which can be used to connect to the Ubidots API.

Saving a new Value to a Variable
--------------------------------

Retrieve the variable you'd like the value to be saved to:

.. code-block:: php
    
    $my_variable = $api->get_variable('56799cf1231b28459f976417');

Given the instantiated variable, you can save a new value with the following line:

.. code-block:: php

    $new_value = $my_variable->save_value( json_encode(array('value'=>10)) );

You can also specify a timestamp (optional):

.. code-block:: php

    $new_value = $my_variable->save_value( array('value'=>10, 'timestamp'=>1376061804407) );

If no timestamp is specified, the API server will assign the current time to it. We think it's always better for you to specify the timestamp so the record reflects the exact time the value was captured, not the time it arrived to our servers.

Creating a Data Source
----------------------

As you might know by now, a data source represents a device that's generating time-series data.

This line creates a new data source:

.. code-block:: php
    
    $new_datasource = $api->create_datasource( array("name"=>"myNewDs", "tags"=>array("firstDs", "new"), "description"=>"any des") );

The 'name' key is required, but the 'tags' and 'description' keys are optional. This new data source can be used to track different variables, so let's create one.


Creating a Variable
--------------------

A variable is a time-series containing different values over time. Let's create one:


.. code-block:: php
    
    $my_variable = $new_datasource->create_variable( array("name"=>"myNewVar", "unit"=>"Nw") );

The 'name' and 'unit' keys are required.

Getting Values
--------------

To get the values of a variable, use the method get_values in an instance of the class Variable. This will return a values array.

If you only want the last N values call the method with the number of elements you want.

.. code-block:: php
    
    /*
     * Getting all the values from the server. Note that this could result in a
     * lot of requests, and potentially violate your requests per second limit.
     */
    $all_values = $new_variable->get_values();
    
    /* If you want just the last 100 values you can use: */
    $some_values = $new_variable->get_values(100);
    

Getting a group of Data Sources
--------------------------------

If you want to get all your data sources you can a method on the ApiClient instance directly. This method return a objects Datasource array.

.. code-block:: php
    
    /* Get all datasources */
    $all_datasources = $api->get_datasources();
    
    /* Get the last five created datasources */
    $some_datasources = $api->get_datasources(5);


Getting a specific Data Source
-------------------------------

Each data source is identified by an ID. A specific data source can be retrieved from the server using this ID.

For example, if a data source has the id 51c99cfdf91b28459f976414, it can be retrieved as follows:


.. code-block:: php

    $my_specific_datasource = $api->get_datasource('51c99cfdf91b28459f976414');

Getting a group of Variables from a Data source
------------------------------------------------

You can also retrieve some or all of the variables of a data source:

.. code-block:: php

    /* Get all variables */
    $all_variables =  $my_datasource->get_variables();
    
    /* Get last 10 variables */
    $some_variables =  $my_datasource->get_variables(10)


Getting a specific Variable
------------------------------

As with data sources, you can use your variable's ID to retrieve the details about it:

.. code-block:: php

    $my_specific_variable = $api->get_variable('56799cf1231b28459f976417');
