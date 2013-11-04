About BibSonomyAPI
==================

The BibSonomyAPI package contains a RESTClient and some utilities that are 
useful for the development of PHP applications that shall interact with the BibSonomy (or PUMA) REST-API.
The RESTClient maps all the functions provided by the BibSonomy REST-API (not all are fully implemented, yet). 
In the folder 'utils' you can find some utilities that are helpful to generate the hashes, that are used by
BibSonomy/PUMA to identify resources like publications. In addition, there 
are methods to normalize publications based on the authors, the year of 
publication and the title.

Usage
=====

RESTClient
----------

Copy BibSonomyAPI in your PHP project.

### Getting Posts ###

The main usage of BibSonomyAPI is getting posts from BibSonomy/PUMA in 3rd party software.
To do this, inlcude RESTClient.php and create an instance of an accessor and of the `RESTClient` class.

#### Accessor for Basic Authentication #####

You can choose a `BasicAuthAccessor` for HTTP basic access authentication (http://tools.ietf.org/html/rfc1945#section-11). In this case use the user name and API key as user credentials.

<code>
    
    include 'BibSonomyAPI/bootstrap.php';
    require_once 'BibSonomyAPI/RESTClient.php';
    require_once 'BibSonomyAPI/BasicAuthAccessor.php';
    require_once 'BibSonomyAPI/RESTConfig.php';
    
    class ExampleClass {
    
        private $authAccessor;
        private $bibClient;
        
        public function __construct() {
    
            //creates new BasicAuthAccessor, with user name and API key
            $this->authAccessor = new BasicAuthAccessor("testuser", "AJs7aj3najas76ass0921hKKhjasdASD");
            
            $this->bibClient = new RESTClient("http://www.bibsonomy.org/", $this->accessor, "testuser");
        }
    
        public function prepareBibPublications() {
            
            $posts = $this->bibClient->getPosts("publication", RESTConfig::USER, "testuser", "myown", null, null, null, null, null, null);
    
            echo "<pre>";
            print_r($posts);
            echo "</pre>";
            
        }
    
        public function prepareBibBookmarks() {
            $posts = $this->bibClient->getPosts("bookmarks", RESTConfig::USER, "testuser", array(), null, null, null, null, null, null);
    
            echo "<pre>";
            print_r($posts);
            echo "</pre>";
        }
    }

</code>

#### Accessor for OAuth ####

You can also use oAuth for user authentication. In this case you have to use `OAuthAccessor`. The constructor expects user name, a config array and an access token of type `Zend_Oauth_Token` as its params. 

<code>

    $oAuthConfig = array(
                
        'callbackUrl' => $config['Site']['url'].'/BibSonomy/OAuthCallback',
        'siteUrl' => 'http://www.bibsonomy.org/oauth',
        'consumerKey' => 'Jhgzr568gjhvncteGE§$',
        'consumerSecret' => 'r568gjhvncteGE§',
        'requestTokenUrl' => 'http://www.bibsonomy.org/oauth/requestToken',
        'requestScheme' => Zend_Oauth::REQUEST_SCHEME_QUERYSTRING,
        'accessTokenUrl' => 'http://www.bibsonomy.org/oauth/accessToken',
        'authorizeUrl' => 'http://www.bibsonomy.org/autoRegisterSamlAndOAuth')
    );
</code>
If we have no accessToken, at first we need to get a requestToken.
<code>

    $consumer = new Zend_Oauth_Consumer($OAuthConfig);

    // get requestToken from BibSonomy
    $token = $consumer->getRequestToken();

    // store token in session
    $_SESSION['BIB_REQUEST_TOKEN'] = serialize($token);

    /* 
     * redirect user to bibsonomy, to login or/and OAuth authorizing.
     * bibsonomy redirects back to your defined callbackUrl. In this case 
     * /BibSonomy/OAuthCallback
     *
     */
    $consumer->redirect(); 
</code>

After that, in OAuthCallback we can request the access token, using the request token.

File: /BibSonomy/OAuthCallback
<code>

    if (!empty($_GET) && isset($_SESSION['BIB_REQUEST_TOKEN'])) {

        $consumer = new Zend_Oauth_Consumer($oAuthConfig);

        try {
            // getAccessToken 
            // in $_GET ist der verfication code von Puma, der,  genauso wie
            // der RequestToken benötigt wird, um den AccessToken anzufragen
            $accessToken = $consumer->getAccessToken(
                    $_GET, unserialize($_SESSION['BIB_REQUEST_TOKEN'])
            );
            // save AccessToken in database (i.e.)
            <YourDBHelperClass>::saveAccessToken("testuser", $accessToken);

        } catch (Exception $e) {
            //unset request token in session
            $_SESSION['BIB_REQUEST_TOKEN'] = null;
            error_log($e->getMessage());
        }

        // delete request token from session
        $_SESSION['BIB_REQUEST_TOKEN'] = null;

    }
</code>
Now, the constructor of our `ExampleClass` looks like this:
<code>

    //...
    public function __construct() {
        global $oAuthConfig;
        
        $accessToken = <YourDBHelperClass>::getAccessToken("testuser");

        //creates new OAuthAccessor, with user name and API key
        $this->authAccessor = new OAuthAuthAccessor("testuser", $oAuthConfig, $accessToken);
        
        $this->bibClient = new RESTClient("http://www.bibsonomy.org/", $this->accessor, "testuser");
    }
    //...
    
</code>

## Using the model ##

Many functions of BibSonomyAPI expects varibales of type `BibsonomyPublication`. `BibsonomyPublication` is an interface which defines functions that are necessary for other program parts of BibSonomyAPI.

The best way to work with it is to create an own class which extends the original model class of the publication record you want to store in BibSonomy/PUMA and implement the Interface `BibsonomyPublication` (or `BibsonomyPublicationFullBibtex` for extended publication meta data).

Now you can implement the functions and filtering the relevant data for respective function from the original model file.

## Using hashes ##

To determine if there is a user that has a specific publication already stored in BibSonomy/PUMA, you can use hashes. The identifier for any publication in BibSonomy/PUMA is the interhash. The interhash identifies a publication by title, author and year. In the folder utils you can find the static class `SimHashUtils`. The static function `getSimHash1` expects a publication record of type `BibsonomyPublication` as parameter and calculates the interhash.

