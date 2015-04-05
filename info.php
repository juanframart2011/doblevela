<?
if( $_GET["f"] == "a" ){

	$proxy = new SoapClient('http://localhost:82/doblevela_git/api/v2_soap/?wsdl'); // TODO : change url
	$sessionId = $proxy->login('doblevela_soap', 'doblevela'); // TODO : change login and pwd if necessary
	$result = $proxy->catalogCategoryTree($sessionId);
	echo'<pre>'.print_r($result).'</pre>';
}

if( $_GET["f"] == "b" ){

	$client = new SoapClient('http://localhost:82/doblevela_git/api/v2_soap/?wsdl');

	// If some stuff requires api authentification,
	// then get a session token
	$session = $client->login('doblevela_soap', 'doblevela');



	// get attribute set
	$attributeSets = $client->catalogProductAttributeSetList($session);
	print_r($attributeSets);

	//$attributeSet[1]->set_id;
	$attributeSet = current($attributeSets);

	$result = $client->catalogProductCreate($session, 'simple', 15, 'bolas_peuebass', array(
	    'categories' => array(2),
	    'websites' => array(1),
	    'category_ids' => 103,
	    'name' => 'impuesto',
	    'description' => 'Product descrdaiption',
	    'short_description' => 'Product shoadart description',
	    'weight' => '14',
	    'status' => '1',
	    'url_key' => 'product-url-key',
	    'url_path' => 'product-url-path',
	    'visibility' => '4',
	    'price' => '100',
	    'tax_class_id' => 1,
	    'meta_title' => 'Product metxczxa title',
	    'meta_keyword' => 'Product mczxeta keyword',
	    'meta_description' => 'Produczxczxt meta description',
	    'is_in_stock' => 1,
	    'qty' => '100'
	));

	var_dump ($result);
}

if( $_GET["f"] == "c" ){

	$proxy = new SoapClient('http://localhost:82/doblevela_git/api/v2_soap/?wsdl'); 
	$sessionId = $proxy->login('doblevela_soap', 'doblevela'); 
	 
	$result = $proxy->catalogInventoryStockItemUpdate($sessionId, 71, array(
	'qty' => '49', 
	'is_in_stock' => 1
	));

	var_dump($result);
}
?>