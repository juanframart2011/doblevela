<?
class Inchoo_RestConnect_TestController extends Mage_Core_Controller_Front_Action {
 
    public function indexAction() {
 
        //Basic parameters that need to be provided for oAuth authentication
        //on Magento
        $params = array(
            'siteUrl' => 'http://localhost:82/doblevela_git/oauth',
            'requestTokenUrl' => 'http://localhost:82/doblevela_git/oauth/initiate',
            'accessTokenUrl' => 'http://localhost:82/doblevela_git/oauth/token',
            'authorizeUrl' => 'http://localhost:82/doblevela_git/admin/oAuth_authorize',//This URL is used only if we authenticate as Admin user type
            'consumerKey' => 'e47e56d77de09597486a87bbab159202',//Consumer key registered in server administration
            'consumerSecret' => 'aaa8781908b24ba73123714258671772',//Consumer secret registered in server administration
            'callbackUrl' => 'http://localhost:82/doblevela_git/probador/prueba.php',//Url of callback action below
        );
 
        // Initiate oAuth consumer with above parameters
        $consumer = new Zend_Oauth_Consumer($params);
        // Get request token
        $requestToken = $consumer->getRequestToken();
        // Get session
        $session = Mage::getSingleton('core/session');
        // Save serialized request token object in session for later use
        $session->setRequestToken(serialize($requestToken));
        // Redirect to authorize URL
        $consumer->redirect();
 
        return;
    }
 
    public function callbackAction() {
 
        //oAuth parameters
        $params = array(
            'siteUrl' => 'http://localhost:82/doblevela_git/oauth',
            'requestTokenUrl' => 'http://localhost:82/doblevela_git/oauth/initiate',
            'accessTokenUrl' => 'http://localhost:82/doblevela_git/oauth/token',
            'consumerKey' => 'e47e56d77de09597486a87bbab159202',
            'consumerSecret' => 'aaa8781908b24ba73123714258671772'
        );
 
        // Get session
        $session = Mage::getSingleton('core/session');
        // Read and unserialize request token from session
        $requestToken = unserialize($session->getRequestToken());
        // Initiate oAuth consumer
        $consumer = new Zend_Oauth_Consumer($params);
        // Using oAuth parameters and request Token we got, get access token
        $acessToken = $consumer->getAccessToken($_GET, $requestToken);
        // Get HTTP client from access token object
        $restClient = $acessToken->getHttpClient($params);
        // Set REST resource URL
        $restClient->setUri('http://magento.loc/api/rest/products');
        // In Magento it is neccesary to set json or xml headers in order to work
        $restClient->setHeaders('Accept', 'application/json');
        // Get method
        $restClient->setMethod(Zend_Http_Client::GET);
        //Make REST request
        $response = $restClient->request();
        // Here we can see that response body contains json list of products
        Zend_Debug::dump($response);
 
        return;
    }
 
}
?>