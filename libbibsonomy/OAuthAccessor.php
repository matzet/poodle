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
 * Description of OAuthAccessor
 *
 * @author sebastian
 */
class OAuthAccessor extends AuthenticationAccessor {
    
    protected $accessToken;
    
    protected $oAuthConfig;
    
    public function __construct(
            $username,
            array $oAuthConfig,
            Zend_Oauth_Token $accessToken
            ) {
        
        parent::__construct($username, parent::AUTH_METHOD_OAUTH);
        $this->oAuthConfig = $oAuthConfig;
        $this->accessToken = $accessToken;
    }
    
    /**
     * 
     * @return Zend_Http_Client
     */
    public function getClient() {
        return $this->accessToken->getHttpClient($this->oAuthConfig);
    }

    /**
     * 
     * @return string (oAuth|Basic)
     */
    public function getAuthMethod() {
        return $this->authMethod;
    }

    /**
     * 
     * @return string user name
     */
    public function getUsername() {
        return $this->username;
    }

}

?>
