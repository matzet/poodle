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


/**
 * @author Sebastian Böttger <boettger@cs.uni-kassel.de>
 * @version $Id: CreatePostDocumentQuery.java,v 1.9 2013-03-13 10:42:33 jil Exp $
 */
class CreatePostDocumentQuery extends AbstractQuery {

	private $file;
	private $username;
	private $resourceHash;

	/**
	 * @param username
	 * @param resourceHash
	 * @param file
	 */
	public function __construct($apiHostUrl, AuthenticationAccessor $accessor, $username, $resourceHash, $file) {
	
            parent::__constrcut($apiHostUrl, $accessor);
            
            if(empty($username)) throw new IllegalArgumentException("no username given");
            if(empty($resourceHash)) throw new IllegalArgumentException("no resourceHash given");

            $this->username = $username;
            $this->resourceHash = $resourceHash;

            $this->file = $file;
	}

        protected function performMultipartPostRequest($url, $file) {	
            
            $client = $this->accessor->getClient();
            
            $url .= $this->apiHostUrl . "/". $url;
            
            $client->setUri($url);
            
            $client->setStream(file_get_contents($file));
            
            return $client->request();
            
	}
	
	protected function doExecute() {
            $url = RESTConfig::USERS_URL . "/". $this->username . "/posts/" . $this->resourceHash ."/documents";
            $this->response = $this->performMultipartPostRequest($url, $this->file);
            $this->result = json_decode($this->response->getBody());
	}

        public function getResult() {
            if($this->response->isSuccessful()) {
            
                return $this->result;
            }
            return $this->getError();
        }
}
