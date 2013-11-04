<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require_once __DIR__.'/BibsonomyException.php';

/**
 * Description of NeedUserCredentialsException
 *
 * @author sebastian
 */
class NeedUserCredentialsException extends BibsonomyException {
    
    /**
     * 
     * @param string $message
     * @param integer $code
     */
    public function __construct($message, $code = 0) {
        
        parent::__construct($message, $code);
    }

}

?>
