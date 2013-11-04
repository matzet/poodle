<?php
/**
 *
 *  BibSonomy-Rest-Client - The REST-client.
 *
 *  Copyright (C) 2006 - 2011 Knowledge & Data Engineering Group,
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

require_once __DIR__.'/../../RESTConfig.php';
require_once __DIR__.'/../AbstractQuery.php';
require_once __DIR__.'/../../exceptions/BibsonomyException.php';
require_once __DIR__.'/../../exceptions/IllegalArgumentException.php';

/**
 * Use this Class to delete a specified post.
 * 
 * @author Sebastian Böttger <boettger@cs.uni-kassel.de>
 */

class DeletePostQuery extends AbstractQuery {
    
    private $resourceHash;

    private $url;
    
    /**
     * Deletes a post.
     * 
     * @param userName
     *            the userName owning the post to deleted
     * @param resourceHash
     *            hash of the resource connected to the post
     * @throws IllegalArgumentException
     *             if userName or groupName are null or empty
     */
    public function __construct($apiHostUrl, AuthenticationAccessor $accessor, $username, $resourceHash) {
        
        parent::__construct($apiHostUrl, $accessor, $username);

        if(empty($resourceHash)) 
            throw new IllegalArgumentException("no resourcehash given", E_WARNING);

        $this->username = $username;
        $this->resourceHash = $resourceHash;
    }
	

    protected function query() {
        $this->url = $this->apiHostUrl . "/" . RESTConfig::USERS_URL . "/" . $this->username . "/" . RESTConfig::POSTS_URL . "/" . $this->resourceHash;
        
    }

    protected function doExecute() {
        
        $this->query();
        
        $client = $this->accessor->getClient();
        
        $client->setMethod(Zend_Http_Client::DELETE);
        
        $client->setHeaders(Zend_Http_Client::CONTENT_TYPE, 'application/json;charset=UTF-8');
        
        $client->setUri(
            Zend_Uri_Http::fromString($this->url)
        );
        
        $this->response = $client->request();
    }

}