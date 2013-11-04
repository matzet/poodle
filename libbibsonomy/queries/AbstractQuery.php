<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require_once __DIR__.'/../exceptions/IllegalStateException.php';

/**
 * Description of AbstractQuery
 *
 * @author Sebastian Böttger <boettger@cs.uni-kassel.de>
 */
abstract class AbstractQuery {
    
    /**
     *
     * @var string 
     */
    protected $apiHostUrl;
    
    /**
     * @var string
     */
    private $username;
    
    /**
     * @var AuthenticationAccessor
     */
    protected $accessor;
    
    /**
     * @var integer
     */
    private $statusCode = -1;

    /**
     * @var stdClass
     */
    protected $result;
    
    /**
     *
     * @var Zend_Http_Response
     */
    protected $response;
    
    /**
     * @var boolean
     */
    private $executed = false;

    /**
     * executes the query and saves the response ($this->response) and result 
     * ($this->result) 
     */
    protected abstract function doExecute();
    
    /**
     * 
     * @param string $apiHostUrl
     * @param AuthenticationAccessor $accessor
     */
    public function __construct($apiHostUrl = "http://www.bibsonomy.org/api", AuthenticationAccessor $accessor, $username = "") {
        $this->apiHostUrl = $apiHostUrl;
        $this->accessor = $accessor;
        if(!empty($username)) {
            $this->username = $username;
        }
        
    }
    
    
    /**
     * triggers the HTTP request
     * @param string $username
     * @param AuthenticationAccessor $accessor
     */
    public function execute() {
        $this->result = $this->doExecute();
        $this->executed = true;
    }
    
    /**
     * return HTTP status code
     * 
     * @return int
     * @throws BibsonomyException
     */
    public function getHttpStatusCode() {
        if($this->statusCode == -1) 
            throw new IllegalStateException("Execute the query first.");
        return $this->response->getStatus();
    }
    
    public function getResult() {
        if(!$this->executed) 
            throw new IllegalStateException("Execute the query first.");
        return $this->result;
    }
    
    /**
     * Zend_Http_Response 
     * 
     * @return Zend_Http_Response 
     */
    public function getResponse() {
        
        if($this->response == null) 
            throw new IllegalStateException("Execute the query first.");
        
        return $this->response;
    }
    
    /**
     * Returns an error message if an error occured, otherwise returns false.
     * 
     * @return string|boolean
     * @throws IllegalStateException – Execute the query first.
     */
    public function getError() {
        
    
        if($this->response == null) 
            throw new IllegalStateException("Execute the query first.");
        
        if ($this->response->isError()) {
            return
                "Error transmitting data.\n" .
                "Server reply was: " . $this->response->getStatus() .
                " " . $this->response->getMessage() . "\n";
        }
        
        return false; 
    }    
}

?>
