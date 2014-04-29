===================================
Ubidots PHP API Client
===================================

Connecting to the API
----------------------

Before playing with the API you must be able to connect to it using your private API key, which can be found `in your profile <http://app.ubidots.com/userdata/api/>`_.

If you don't have an account yet, you can `create one here <http://app.ubidots.com/accounts/signup/>`_.

Once you have your API key, you can connect to the API by creating an ApiClient instance. Let's assume your API key is: "7fj39fk3044045k89fbh34rsd9823jkfs8323". Then your code would look like this:


.. code-block:: php

	require 'vendor/autoload.php';
	
	$api = new Ubidots\ApiClient($apikey="ffe22112fdd1c55f0f3969169f3d3f37b1ad0997");


Now you have an instance of ApiClient ("api") which can be used to connect to the API service.