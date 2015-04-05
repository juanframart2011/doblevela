
<?
error_reporting(E_ALL);
#key e47e56d77de09597486a87bbab159202
#Secrect aaa8781908b24ba73123714258671772

/**
 * Example of retrieving the products list using Admin account via Magento REST API. OAuth authorization is used
 * Preconditions:
 * 1. Install php oauth extension
 * 2. If you were authorized as a Customer before this step, clear browser cookies for 'yourhost'
 * 3. Create at least one product in Magento
 * 4. Configure resource permissions for Admin REST user for retrieving all product data for Admin
 * 5. Create a Consumer
 */
// $callbackUrl is a path to your file with OAuth authentication example for the Admin user

if( $_GET["f"] == "cliente" ){

	//Url de la conexión
	$client = new SoapClient("http://localhost:82/doblevela_git/api/?wsdl");
	 
	 echo 
	//Login
	$session = $client->login("doblevela_soap", "doblevela");
	  
	//Atributos para el nuevo cliente
	$data = array(
	    "firstname"       => $firstname = $_GET['firstname'],
	    "lastname"        => $lastname = $_GET['lastname'],
	    "email"           => $email = $_GET['email'],
	    "password_hash"   => md5 ($password_hash = $_GET ['password_hash']),
	    //"password_hash"   => $password_hash = $_GET ['password_hash'],
	    //"password_hash"   => md5("europa"),
	    "store_id"        => 1,
	    "website_id"      => 1,
	    "created_in"    =>   "English",
	    "group_id"      =>   1,
	    "disable_auto_group_change"     =>   0
	     
	     
	);
	
	print_r($client); 
	//Crea cliente
	$id = $client->call($session, "customer.create", array($data));
	 

	//Impresión
	print_r($id);
	  
	//Logout
	$client->endSession($session);
}

if( $_GET["f"] == "api_c" ){

	/**
	* Example of products list retrieve using Customer account via Magento REST API. OAuth authorization is used
	*/

	//$callbackUrl = "http://localhost:82/doblevela_git/key_api.php?f=api_c";
	
	/*
	$temporaryCredentialsRequestUrl = "http://localhost:82/doblevela_git/mage/Oauth/initiate?oauth_callback=" . urlencode($callbackUrl);
	$adminAuthorizationUrl = 'http://localhost:82/doblevela_git/mage/Oauth/authorize';
	$accessTokenRequestUrl = 'http://localhost:82/doblevela_git/mage/Oauth/token';
	$apiUrl = 'http://localhost:82/doblevela_git/api/rest';
	*/
	$callbackUrl = "http://localhost/doblevela_git/oauth_admin.php";
	$temporaryCredentialsRequestUrl = "http://localhost/doblevela_git/oauth/initiate?oauth_callback=" . urlencode($callbackUrl);
	$adminAuthorizationUrl = 'http://localhost/doblevela_git/oauth/authorize';
	$accessTokenRequestUrl = 'http://localhost/doblevela_git/oauth/token';
	$apiUrl = 'http://localhost/doblevela_git/api/rest';

	$consumerKey = 'e47e56d77de09597486a87bbab159202';
	$consumerSecret = 'aaa8781908b24ba73123714258671772';

	session_start();
	if (!isset($_GET['oauth_token']) && isset($_SESSION['state']) && $_SESSION['state'] == 1) {
	    $_SESSION['state'] = 0;
	}
	try {
		echo "string";
	    $authType = ($_SESSION['state'] == 2) ? OAUTH_AUTH_TYPE_AUTHORIZATION : OAUTH_AUTH_TYPE_URI;
	    echo "<br>a";
	    $oauthClient = new OAuth($consumerKey, $consumerSecret, OAUTH_SIG_METHOD_HMACSHA1, $authType);
	    echo "<br>c";
	    $oauthClient->enableDebug();

	    if (!isset($_GET['oauth_token']) && !$_SESSION['state']) {
	        $requestToken = $oauthClient->getRequestToken($temporaryCredentialsRequestUrl);
	        $_SESSION['secret'] = $requestToken['oauth_token_secret'];
	        $_SESSION['state'] = 1;
	        header('Location: ' . $adminAuthorizationUrl . '?oauth_token=' . $requestToken['oauth_token']);
	        exit;
	    } else if ($_SESSION['state'] == 1) {
	        $oauthClient->setToken($_GET['oauth_token'], $_SESSION['secret']);
	        $accessToken = $oauthClient->getAccessToken($accessTokenRequestUrl);
	        $_SESSION['state'] = 2;
	        $_SESSION['token'] = $accessToken['oauth_token'];
	        $_SESSION['secret'] = $accessToken['oauth_token_secret'];
	        header('Location: ' . $callbackUrl);
	        exit;
	    } else {
	        $oauthClient->setToken($_SESSION['token'], $_SESSION['secret']);
	        $resourceUrl = "$apiUrl/products";
	        $productData = json_encode(array(
	            'type_id'           => 'simple',
	            'attribute_set_id'  => 4,
	            'sku'               => 'simple' . uniqid(),
	            'weight'            => 1,
	            'status'            => 1,
	            'visibility'        => 4,
	            'name'              => 'Simple Product',
	            'description'       => 'Simple Description',
	            'short_description' => 'Simple Short Description',
	            'price'             => 99.95,
	            'tax_class_id'      => 0,
	        ));
	        $headers = array('Content-Type' => 'application/json');
	        $oauthClient->fetch($resourceUrl, $productData, OAUTH_HTTP_METHOD_POST, $headers);
	        print_r($oauthClient->getLastResponseInfo());
	    }
	} catch (OAuthException $e) {
	    print_r($e);
	}
}
error_reporting(E_ALL);
if( $_GET["f"] == "api_b" ){

	/**
	 * Example of retrieving the products list using Admin account via Magento REST API. OAuth authorization is used
	 * Preconditions:
	 * 1. Install php oauth extension
	 * 2. If you were authorized as a Customer before this step, clear browser cookies for 'yourhost'
	 * 3. Create at least one product in Magento
	 * 4. Configure resource permissions for Admin REST user for retrieving all product data for Admin
	 * 5. Create a Consumer
	 */
	// $callbackUrl is a path to your file with OAuth authentication example for the Admin user
	$callbackUrl = "http://yourhost/oauth_admin.php";
	$temporaryCredentialsRequestUrl = "http://yourhost/oauth/initiate?oauth_callback=" . urlencode($callbackUrl);
	$adminAuthorizationUrl = 'http://yourhost/admin/oAuth_authorize';
	$accessTokenRequestUrl = 'http://yourhost/oauth/token';
	$apiUrl = 'http://yourhost/api/rest';
	$consumerKey = 'yourconsumerkey';
	$consumerSecret = 'yourconsumersecret';

	session_start();
	if (!isset($_GET['oauth_token']) && isset($_SESSION['state']) && $_SESSION['state'] == 1) {
	    $_SESSION['state'] = 0;
	}
	try {
	    $authType = ($_SESSION['state'] == 2) ? OAUTH_AUTH_TYPE_AUTHORIZATION : OAUTH_AUTH_TYPE_URI;
	    $oauthClient = new OAuth($consumerKey, $consumerSecret, OAUTH_SIG_METHOD_HMACSHA1, $authType);
	    $oauthClient->enableDebug();

	    if (!isset($_GET['oauth_token']) && !$_SESSION['state']) {
	        $requestToken = $oauthClient->getRequestToken($temporaryCredentialsRequestUrl);
	        $_SESSION['secret'] = $requestToken['oauth_token_secret'];
	        $_SESSION['state'] = 1;
	        header('Location: ' . $adminAuthorizationUrl . '?oauth_token=' . $requestToken['oauth_token']);
	        exit;
	    } else if ($_SESSION['state'] == 1) {
	        $oauthClient->setToken($_GET['oauth_token'], $_SESSION['secret']);
	        $accessToken = $oauthClient->getAccessToken($accessTokenRequestUrl);
	        $_SESSION['state'] = 2;
	        $_SESSION['token'] = $accessToken['oauth_token'];
	        $_SESSION['secret'] = $accessToken['oauth_token_secret'];
	        header('Location: ' . $callbackUrl);
	        exit;
	    } else {
	        $oauthClient->setToken($_SESSION['token'], $_SESSION['secret']);

	        $resourceUrl = "$apiUrl/products";
	        $oauthClient->fetch($resourceUrl, array(), 'GET', array('Content-Type' => 'application/json'));
	        $productsList = json_decode($oauthClient->getLastResponse());
	        print_r($productsList);
	    }
	} catch (OAuthException $e) {
	    print_r($e->getMessage());
	    echo "<br/>";
	    print_r($e->lastResponse);
	}
}

if( $_GET["f"] == "api_a" ){

	/**
	* Example of simple product POST using Admin account via Magento REST API. OAuth authorization is used
	*/
	$callbackUrl = "http://yourhost/oauth_admin.php";
	$temporaryCredentialsRequestUrl = "http://localhost:82/doblevela_git/oauth/initiate?oauth_callback=" . urlencode($callbackUrl);
	$adminAuthorizationUrl = 'http://localhost:82/doblevela_git/admin/oauth_authorize';
	$accessTokenRequestUrl = 'http://localhost:82/doblevela_git/oauth/token';
	$apiUrl = 'http://localhost:82/doblevela_git/api/rest';
	$consumerKey = 'e47e56d77de09597486a87bbab159202';
	$consumerSecret = 'aaa8781908b24ba73123714258671772';
	 
	session_start();
	if (!isset($_GET['oauth_token']) && isset($_SESSION['state']) && $_SESSION['state'] == 1) {
		$_SESSION['state'] = 0;
	}
	try {
		$authType = ($_SESSION['state'] == 2) ? OAUTH_AUTH_TYPE_AUTHORIZATION : OAUTH_AUTH_TYPE_URI;
		$oauthClient = new OAuth($consumerKey, $consumerSecret, OAUTH_SIG_METHOD_HMACSHA1, $authType);
		$oauthClient->enableDebug();
		 
		if (!isset($_GET['oauth_token']) && !$_SESSION['state']) {
			$requestToken = $oauthClient->getRequestToken($temporaryCredentialsRequestUrl);
			$_SESSION['secret'] = $requestToken['oauth_token_secret'];
			$_SESSION['state'] = 1;
			header('Location: ' . $adminAuthorizationUrl . '?oauth_token=' . $requestToken['oauth_token']);
			exit;
		} else if ($_SESSION['state'] == 1) {
			$oauthClient->setToken($_GET['oauth_token'], $_SESSION['secret']);
			$accessToken = $oauthClient->getAccessToken($accessTokenRequestUrl);
			$_SESSION['state'] = 2;
			$_SESSION['token'] = $accessToken['oauth_token'];
			$_SESSION['secret'] = $accessToken['oauth_token_secret'];
			header('Location: ' . $callbackUrl);
		exit;
		} else {
			$oauthClient->setToken($_SESSION['token'], $_SESSION['secret']);
			$resourceUrl = "$apiUrl/products";
			$productData = json_encode(array(
			'type_id'           => 'simple',
			'attribute_set_id'  => 4,
			'sku'               => 'simple' . uniqid(),
			'weight'            => 1,
			'status'            => 1,
			'visibility'        => 4,
			'name'              => 'Simple Product',
			'description'       => 'Simple Description',
			'short_description' => 'Simple Short Description',
			'price'             => 99.95,
			'tax_class_id'      => 0,
			));
			$headers = array('Content-Type' => 'application/json');
			$oauthClient->fetch($resourceUrl, $productData, OAUTH_HTTP_METHOD_POST, $headers);
			print_r($oauthClient->getLastResponseInfo());
		}
	} catch (OAuthException $e) {
		print_r($e);
	}
}

if( $_GET["f"] == "a" ){

	echo "Esta en la sección 1<br>";

	$callbackUrl = "http://localhost:82/doblevela_git/oauth_admin.php";
	$temporaryCredentialsRequestUrl = "http://localhost:82/doblevela_git/oauth/initiate?oauth_callback=" . urlencode($callbackUrl);
	$adminAuthorizationUrl = 'http://localhost:82/doblevela_git/admin/oAuth_authorize';
	$accessTokenRequestUrl = 'http://localhost:82/doblevela_git/oauth/token';
	$apiUrl = 'http://localhost:82/doblevela_git/api/rest';
	$consumerKey = 'e47e56d77de09597486a87bbab159202';
	$consumerSecret = 'aaa8781908b24ba73123714258671772';

	echo "Parte H<br>";

	session_start();

	echo "Parte sesion<br>";

	if (!isset($_GET['oauth_token']) && isset($_SESSION['state']) && $_SESSION['state'] == 1) {
	    $_SESSION['state'] = 0;
	    echo "Parte A<br>";
	}
	try {

		echo "Parte BB<br>";
	    $authType = ($_SESSION['state'] == 2) ? OAUTH_AUTH_TYPE_AUTHORIZATION : OAUTH_AUTH_TYPE_URI;
	    echo "Parte BBB<br>";
	    print_r($authType);
	    $oauthClient = new OAuth($consumerKey, $consumerSecret, OAUTH_SIG_METHOD_HMACSHA1, $authType);
	    echo "Parte BBBB<br>";
	    $oauthClient->enableDebug();

	    echo "Parte B<br>";

	    if (!isset($_GET['oauth_token']) && !$_SESSION['state']) {
	        $requestToken = $oauthClient->getRequestToken($temporaryCredentialsRequestUrl);
	        $_SESSION['secret'] = $requestToken['oauth_token_secret'];
	        $_SESSION['state'] = 1;
	        header('Location: ' . $adminAuthorizationUrl . '?oauth_token=' . $requestToken['oauth_token']);
	        exit;

	        echo "Parte C<br>";
	    } else if ($_SESSION['state'] == 1) {
	        $oauthClient->setToken($_GET['oauth_token'], $_SESSION['secret']);
	        $accessToken = $oauthClient->getAccessToken($accessTokenRequestUrl);
	        $_SESSION['state'] = 2;
	        $_SESSION['token'] = $accessToken['oauth_token'];
	        $_SESSION['secret'] = $accessToken['oauth_token_secret'];
	        header('Location: ' . $callbackUrl);
	        exit;

	        echo "Parte D<br>";
	    } else {
	        $oauthClient->setToken($_SESSION['token'], $_SESSION['secret']);

	        $resourceUrl = "$apiUrl/products";
	        $oauthClient->fetch($resourceUrl, array(), 'GET', array('Content-Type' => 'application/json'));
	        $productsList = json_decode($oauthClient->getLastResponse());
	        print_r($productsList);

	        echo "Parte E<br>";
	    }

	    echo "Parte EEE<br>";
	} catch (OAuthException $e) {

	    print_r($e->getMessage());
	    echo "<br/>";
	    print_r($e->lastResponse);
	    echo "Parte F<br>";
	}

	echo "Parte G<br>";
}


if( $_GET["f"] == "b" ){

	// $callbackUrl is a path to your file with OAuth authentication example for the Customer user

	$callbackUrl = "http://localhost:82/doblevela_git/key_api.php";
	$temporaryCredentialsRequestUrl = "http://localhost:82/doblevela_git/oauth/initiate?oauth_callback=" . urlencode($callbackUrl);
	$adminAuthorizationUrl = 'http://localhost:82/doblevela_git/admin/oAuth_authorize';
	$accessTokenRequestUrl = 'http://localhost:82/doblevela_git/oauth/token';
	$apiUrl = 'http://localhost:82/doblevela_git/api/rest';
	$consumerKey = 'e47e56d77de09597486a87bbab159202';
	$consumerSecret = 'aaa8781908b24ba73123714258671772';

	session_start();
	if (!isset($_GET['oauth_token']) && isset($_SESSION['state']) && $_SESSION['state'] == 1) {
	    $_SESSION['state'] = 0;
	}
	try {
	    $authType = ($_SESSION['state'] == 2) ? OAUTH_AUTH_TYPE_AUTHORIZATION : OAUTH_AUTH_TYPE_URI;
	    $oauthClient = new OAuth($consumerKey, $consumerSecret, OAUTH_SIG_METHOD_HMACSHA1, $authType);
	    $oauthClient->enableDebug();

	    if (!isset($_GET['oauth_token']) && !$_SESSION['state']) {
	        $requestToken = $oauthClient->getRequestToken($temporaryCredentialsRequestUrl);
	        $_SESSION['secret'] = $requestToken['oauth_token_secret'];
	        $_SESSION['state'] = 1;
	        header('Location: ' . $customerAuthorizationUrl . '?oauth_token=' . $requestToken['oauth_token']);
	        exit;
	    } else if ($_SESSION['state'] == 1) {
	        $oauthClient->setToken($_GET['oauth_token'], $_SESSION['secret']);
	        $accessToken = $oauthClient->getAccessToken($accessTokenRequestUrl);
	        $_SESSION['state'] = 2;
	        $_SESSION['token'] = $accessToken['oauth_token'];
	        $_SESSION['secret'] = $accessToken['oauth_token_secret'];
	        header('Location: ' . $callbackUrl);
	        exit;
	    } else {
	        $oauthClient->setToken($_SESSION['token'], $_SESSION['secret']);

	        $resourceUrl = "$apiUrl/products";
	        $oauthClient->fetch($resourceUrl, array(), 'GET', array('Content-Type' => 'application/json'));
	        $productsList = json_decode($oauthClient->getLastResponse());
	        print_r($productsList);
	    }
	} catch (OAuthException $e) {
	    print_r($e->getMessage());
	    echo "<br/>";
	    print_r($e->lastResponse);
	}
}

if( $_GET["f"] == "c" ){

	/**
	* Example of simple product POST using Admin account via Magento REST API. OAuth authorization is used
	*/
	$callbackUrl = "http://yourhost/oauth_admin.php";
	$temporaryCredentialsRequestUrl = "http://magentohost/oauth/initiate?oauth_callback=" . urlencode($callbackUrl);
	$adminAuthorizationUrl = 'http://magentohost/admin/oauth_authorize';
	$accessTokenRequestUrl = 'http://magentohost/oauth/token';
	$apiUrl = 'http://magentohost/api/rest';
	$consumerKey = 'yourconsumerkey';
	$consumerSecret = 'yourconsumersecret';

	session_start();
	if (!isset($_GET['oauth_token']) && isset($_SESSION['state']) && $_SESSION['state'] == 1) {
	    $_SESSION['state'] = 0;
	}
	try {
	    $authType = ($_SESSION['state'] == 2) ? OAUTH_AUTH_TYPE_AUTHORIZATION : OAUTH_AUTH_TYPE_URI;
	    $oauthClient = new OAuth($consumerKey, $consumerSecret, OAUTH_SIG_METHOD_HMACSHA1, $authType);
	    $oauthClient->enableDebug();

	    if (!isset($_GET['oauth_token']) && !$_SESSION['state']) {
	        $requestToken = $oauthClient->getRequestToken($temporaryCredentialsRequestUrl);
	        $_SESSION['secret'] = $requestToken['oauth_token_secret'];
	        $_SESSION['state'] = 1;
	        header('Location: ' . $adminAuthorizationUrl . '?oauth_token=' . $requestToken['oauth_token']);
	        exit;
	    } else if ($_SESSION['state'] == 1) {
	        $oauthClient->setToken($_GET['oauth_token'], $_SESSION['secret']);
	        $accessToken = $oauthClient->getAccessToken($accessTokenRequestUrl);
	        $_SESSION['state'] = 2;
	        $_SESSION['token'] = $accessToken['oauth_token'];
	        $_SESSION['secret'] = $accessToken['oauth_token_secret'];
	        header('Location: ' . $callbackUrl);
	        exit;
	    } else {
	        $oauthClient->setToken($_SESSION['token'], $_SESSION['secret']);
	        $resourceUrl = "$apiUrl/products";
	        $productData = json_encode(array(
	            'type_id'           => 'simple',
	            'attribute_set_id'  => 4,
	            'sku'               => 'simple' . uniqid(),
	            'weight'            => 1,
	            'status'            => 1,
	            'visibility'        => 4,
	            'name'              => 'Simple Product',
	            'description'       => 'Simple Description',
	            'short_description' => 'Simple Short Description',
	            'price'             => 99.95,
	            'tax_class_id'      => 0,
	        ));
	        $headers = array('Content-Type' => 'application/json');
	        $oauthClient->fetch($resourceUrl, $productData, OAUTH_HTTP_METHOD_POST, $headers);
	        print_r($oauthClient->getLastResponseInfo());
	    }
	} catch (OAuthException $e) {
	    print_r($e);
	}
}