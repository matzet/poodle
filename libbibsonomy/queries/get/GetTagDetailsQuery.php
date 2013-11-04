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
 * Use this Class to receive information about a specific tag
 * 
 * @author Sebastian Böttger <illig@innofinity.de>
 * @version $Id: GetTagDetailsQuery.java,v 1.15 2013-03-01 18:04:46 jil Exp $
 */
class GetTagDetailsQuery extends AbstractQuery {
    
	private $tagName;

	/**
	 * @param tagName the name of the tag
	 */
	public function __construct(AuthenticationAccessor $accessor, $apiHostUrl, $username, $tagName) {
            parent::__construct($accessor, $apiHostUrl, $username);		
            
            
            $this->tagName = $tagName;
            
	}

	
	public function getResult() {
		if ($this->reponse == null) 
                    throw new IllegalStateException("Execute the query first.");
		return json_decode($this->response->getBody());
	}

	public function query() {
            $this->url = $this->apiHostUrl . "/" .RESTConfig::TAGS_URL + "/" + $this->tagName;
        }

	protected function doExecute() {
            
            $this->query();
            $client = $this->accessor->getClient();
            $client->setUri($this->url);
            $client->setHeaders(Zend_Http_Client::CONTENT_TYPE, 'application/json;charset=UTF-8');
            $this->response = $client->request(Zend_Http_Client::GET);
            
	}
}