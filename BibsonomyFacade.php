<?php

include('libbibsonomy/bootstrap.php');
require_once('libbibsonomy/RESTClient.php');
require_once('libbibsonomy/BasicAuthAccessor.php');
require_once('libbibsonomy/RESTConfig.php');

//set_include_path($include_path . PATH_SEPARATOR . __DIR__.'\libbibsonomy');

class BibsonomyFacade {
    
    private $user;
    private $apiKey;
    
    private $authAccessor;
    private $bibClient;

    public function __construct($user, $api) {
        $this->user = $user;
        $this->apiKey = $api;
        $this->authAccessor = new BasicAuthAccessor($user, $api);
        $this->bibClient = new RESTClient("http://puma.uni-kassel.de/api", $this->authAccessor, $user);
    }

    public function fetchPublications($user, $tags = array()) {
        $posts = $this->bibClient->getPosts("publication", Grouping::USER, $user, $tags, null, null, null, null, null, null);
        $documents = array();
        foreach($posts->posts->post as $post) {
            $o = new stdClass();
            $o->author = $post->bibtex->author;
            $o->title = $post->bibtex->title;
            $o->year = $post->bibtex->year;
            $documents[] = $o;
        }
        return $documents;
    }
}

?>
