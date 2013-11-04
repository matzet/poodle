<?php

/**
 *
 *  Copyright (C) 2006 - 2013 Knowledge & Data Engineering Group,
 *                            University of Kassel, Germany
 *                            http://www.kde.cs.uni-kassel.de/
 *
 *  This program is free software; you can redistribute it and/or
 *  modify it under the terms of the GNU Lesser General Public License
 *  as published by the Free Software Foundation; either version 2
 *  of the License, or (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU Lesser General Public License for more details.
 *
 *  You should have received a copy of the GNU Lesser General Public License
 *  along with this program; if not, write to the Free Software
 *  Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */
require_once 'AuthenticationAccessor.php';
/**
 * Description of BasicAuth
 *
 * @author Sebastian Böttger <boettger@cs.uni-kassel.de>
 */
class BasicAuthAccessor extends AuthenticationAccessor {
    
    /**
     * 
     * @var string
     */
    protected $apiKey;

    /**
     * 
     * @param type $username
     * @param type $apiKey
     * @throws NeedUserCredentialsException
     */
    public function __construct($username, $apiKey) {
         
        parent::__construct($username, parent::AUTH_METHOD_BASIC);
        
        if(empty($username) || empty($apiKey)) {
            throw new NeedUserCredentialsException(
                    "User name and API key needed for HTTP Basic Authentication.", E_WARNING);
        }

        $this->apiKey = $apiKey;
    }
    
    /**
     * 
     * @return Zend_Http_Client
     */
    public function getClient() {
        
        
        $this->client = new Zend_Http_Client();
        $this->client->setAuth($this->username, $this->apiKey, Zend_Http_Client::AUTH_BASIC);
        
        return $this->client;
    }

    public function getAuthMethod() {
        
        return $this->authMethod;
    }

    public function getUsername() {
        
        return $this->username;
    }
}

?>
