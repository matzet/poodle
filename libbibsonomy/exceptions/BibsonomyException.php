<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require_once __DIR__.'/BibsonomyException.php';

/**
 * BibsonomyException
 *
 * @author Sebastian
 */
class BibsonomyException extends Exception {
    
    
    /**
     * 
     * @param string $message
     * @param integer $code
     */
    public function __construct($message, $code = 0) {
        
        parent::__construct($message, $code);
    }


    public function __toString() {
        
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }

}

?>
