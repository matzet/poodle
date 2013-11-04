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
 * Use this Class to get concepts 
 * 1) from all users
 * 2) from a specified group or
 * 3) from a specified user
 * 
 * @author Sebastian Böttger <boettger@cs.uni-kassel.de>
 */
class GetConceptQuery extends AbstractQuery {
    
    /**
     * @var string $resourceType
     */
	protected $resourceType;
	private $groupingName;
	private $status = ConceptStatus::ALL;
	private $regex;	
	private $grouping = Grouping::ALL;
        
        
	private $tags;	
	
        public function __construct() {
		
	}
	
        protected function query() {

            $this->url = "";
		
		switch ($this->grouping) {
		case Grouping::USER:
			$uthis->rl = RESTConfig::USERS_URL . "/" . $this->groupingName . "/" . RESTConfig::CONCEPTS_URL;			
			break;
		case Grouping::GROUP:
			throw new UnsupportedOperationException("Grouping " . grouping . " is not implemented yet");
			//url = URL_GROUPS + "/" + this.groupingName + "/" + URL_CONCEPTS;
			//break;
		case Grouping::ALL:
			$this->url = RESTConfig::CONCEPTS_URL;
			break;
		default:
			throw new UnsupportedOperationException("Grouping " . grouping . " is not available for concept query");
		}
				
		if ($this->status != null) {
			$this->url .= "?" . RESTConfig::CONCEPT_STATUS_PARAM . "=" . strtolower($this->status->toString());
		}

		if ($this->resourceType != null) {
			$this->url .= "&" . RESTConfig::RESOURCE_TYPE_PARAM . "=" . $this->resourceType;
		}
		
		if ($this->regex != null) {
			$this->url .= "?" . RESTConfig::REGEX_PARAM . "=" + $this->regex;
		}	
		
		if (!empty($this->tags)) {
			$first = true;
			foreach ($tags as $tag) {
				if ($first) {
					$this->url .= "&" . RESTConfig::TAGS_PARAM . "=" . $tag;
					$first = false;
				} else {
					$this->url .= "+" . $tag;
				}
			}
		}
        }
        
        
	protected function doExecute() {
					
		
            $this->query();
            $client = $this->accessor->getClient();
            $client->setUri($this->url);
            $client->setHeaders(Zend_Http_Client::CONTENT_TYPE, 'application/json;charset=UTF-8');
            $this->response = $client->request(Zend_Http_Client::GET);
		
	}

	
	public function getResult() {
		if ($this->response == null) 
                    throw new IllegalStateException("Execute the query first.");
		        
                return json_decode($this->response->getBody());
	}

	public function setResourceType($resourceType) {
		$this->resourceType = $resourceType;
	}

	public function setUserName($userName) {
		$this->groupingName = $userName;
		$this->grouping = Grouping::USER;
	}

	public function setGroupName($groupName) {
		$this->groupingName = $groupName;
		$this->grouping = Grouping::GROUP;
	}
	
	public function setStatus($status) {
		$this->status = $status;
	}

	public function setRegex($regex) {
		$this->regex = $regex;
	}	

	public function setTags($tags) {
		$this->tags = $tags;
	}	
}
