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

require_once 'Zend/Uri/Http.php';
require_once 'Zend/Loader.php';
require_once 'Zend/Http/Client.php';

/**
 * AuthenticationAccessor
 * 
 * @package BibSonomyAPI
 * @author Sebastian Böttger <boettger@cs.uni-kassel.de>
 */
abstract class AuthenticationAccessor {
    
    const AUTH_METHOD_OAUTH = "OAuth";
    
    const AUTH_METHOD_BASIC = "Basic";
    
    
    /**
     *
     * @var array
     */
    protected $oAuthConfig;
    
    /**
     *
     * @var string
     */
    protected $authMethod;
    
    /**
     *
     * @var string
     */
    protected $username;
    
    /**
     * HTTP client
     * @var Zend_Http_Client 
     */
    protected $client;
    
    /**
     * 
     * @param string $username
     * @param string $authMethod 
     *          (AuthenticationAccessor::AUTH_METHOD_OAUTH or AuthenticationAccessor::AUTH_METHOD_BASIC)
     */
    public function __construct($username, $authMethod) {
        $this->username = $username;
        $this->authMethod = $authMethod;
    }
    
    /**
     * @return Zend_Http_Client
     */
    public abstract function getClient();
    
    
    public abstract function getAuthMethod();
    
    
    public abstract function getUsername();
    
}

?>
