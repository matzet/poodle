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

require_once __DIR__.'/bootstrap.php';
require_once __DIR__.'/RESTConfig.php';
require_once __DIR__.'/AuthenticationAccessor.php';
require_once __DIR__.'/exceptions/UnsupportedOperationException.php';
require_once __DIR__.'/exceptions/BibsonomyException.php';
require_once __DIR__.'/logic/LogicInterface.php';
require_once __DIR__.'/queries/post/CreatePostQuery.php';
require_once __DIR__.'/queries/post/CreateConceptQuery.php';
require_once __DIR__.'/queries/get/GetPostsQuery.php';
require_once __DIR__.'/queries/get/GetTagsQuery.php';
require_once __DIR__.'/queries/get/GetTagRelationQuery.php';
require_once __DIR__.'/queries/put/ChangePostQuery.php';
require_once __DIR__.'/queries/delete/DeletePostQuery.php';

/**
 * BibSonomyAPI is a package containing a RESTClient and some utilities that are 
 * useful for the development of apps which needing the BibSonomy (or PUMA) API. 
 * 
 * The RESTClient should be able to map all the functions provided by the 
 * BibSonomy API (not fully implemented yet).
 * 
 * In the folder 'utils' you can find a lot of utilities which are helpful to 
 * generate hashes, that are used from BibSonomy to identify resources like 
 * publications or bookmarks. In addition, there are methods to normalize 
 * publications based on the authors, the year of publication and the title.
 * 
 * @package BibSonomyAPI
 * @author Sebastian Böttger <boettger@cs.uni-kassel.de>
 */
class RESTClient implements LogicInterface {
    

    /**
     * @var AuthenticationAccessor
     */
    private $accessor;

    /**
     * @var string
     */
    private $apiURL;

    /**
     *
     * @var string
     */
    private $username;
    
    /**
     * 
     * @param string $apiURL
     * @param AuthenticationAccessor $accessor
     * @param string $username
     */
    public function __construct($apiURL, AuthenticationAccessor $accessor, $username) {
        
        $this->apiURL = $apiURL;
        
        $this->accessor = $accessor;    
        
        $this->username = $username;
    }

    /**
     * 
     * @param stdObject $concept
     * @paran string $conceptName
     * @param string $grouping (GROUPING)
     * @param string $groupingName
     */
    public function createConcept($concept, $conceptName, $grouping = GROUPING::USER, $groupingName = null) {
        
        
        $query = new CreateConceptQuery($this->apiURL, $this->accessor, $concept, $conceptName, $grouping, $groupingName);
        
        $query->execute();
        
        $response = $query->getResponse();

        if($response->isError()) {
            throw new BibsonomyException($response->getMessage(), E_WARNING);
        } else {
            return json_decode($response->getBody());
        }
       
    }

    /**
     * 
     * @param type $concept
     * @param type $grouping
     * @param type $groupingName
     */
    public function deleteConcept($concept, $grouping, $groupingName) {
        throw new UnsupportedOperationException("Operation not supported.");
    }
    
    /**
     * 
     * @param type $username
     * @param type $resourceHash
     * @param type $fileName
     * @throws UnsupportedOperationException
     */
    public function getDocument($username, $resourceHash, $fileName = null) {
        throw new UnsupportedOperationException("Operation not supported.");
    }
    
    /**
     * 
     * @param type $document
     * @param type $resourceHash
     * @throws UnsupportedOperationException
     */
    public function createDocument($document, $resourceHash) {
        throw new UnsupportedOperationException("Operation not supported.");
    }

    /**
     * 
     * @param type $document
     * @param type $resourceHash
     * @throws UnsupportedOperationException
     */
    public function deleteDocument($document, $resourceHash) {
        throw new UnsupportedOperationException("Operation not supported.");
    }
    
    /**
     * 
     * @param type $group
     * @throws UnsupportedOperationException
     */
    public function createGroup($group) {
        throw new UnsupportedOperationException("Operation not supported.");
    }

    /**
     * 
     * @param type $user
     * @throws UnsupportedOperationException
     */
    public function createUser($user) {
        throw new UnsupportedOperationException("Operation not supported.");
    }

    /**
     * 
     * @param type $sourceUser
     * @param type $targetUser
     * @param type $relation
     * @param type $tag
     * @throws UnsupportedOperationException
     */
    public function createUserRelationship($sourceUser, $targetUser, $relation, $tag) {
        throw new UnsupportedOperationException("Operation not supported.");
    }

    /**
     * 
     * @throws UnsupportedOperationException
     */
    public function getAuthenticatedUser() {
        throw new UnsupportedOperationException("Operation not supported.");
    }

    public function deleteGroup($groupName) {
        throw new UnsupportedOperationException("Operation not supported.");
    }

    public function deleteUser($username) {
        throw new UnsupportedOperationException("Operation not supported.");
    }

    public function deleteUserFromGroup($groupName, $username) {
        throw new UnsupportedOperationException("Operation not supported.");
    }

    public function deleteUserRelationship($sourceUser, $targetUser, $relation, $tag) {
        throw new UnsupportedOperationException("Operation not supported.");
    }


    public function getConceptDetails($conceptName, $grouping, $groupingName) {
        throw new UnsupportedOperationException("Operation not supported.");
    }

    public function getConcepts($resourceType, $grouping, $groupingName, $regex, $tags, $status, $start, $end) {
        throw new UnsupportedOperationException("Operation not supported.");
    }



    public function getGroupDetails($groupName) {
        throw new UnsupportedOperationException("Operation not supported.");
    }

    public function getGroups($start, $end) {
        throw new UnsupportedOperationException("Operation not supported.");
    }

    public function getTagDetails($tagName) {
        
    }

    /**
     * 
     * @param type $resourceType (publication|bookmark)
     * @param type $grouping (RESTConfig::GROUPING_...
     * @param string $groupingValue (username, groupName etc...)
     * @param array $tags related tags
     * @param type $hash  //not implemented yet
     * @param type $search //not implemented yet
     * @param type $regex //regex filter 
     * @param type $relation //not implemented yet
     * @param type $order order
     * @param type $startDate //not implemented yet
     * @param type $endDate //not implemented yet
     * @param type $start start pos of range (optional) = 0
     * @param type $end end pos of range (optional) = 19
     * @return stdClass
     * @throws BibsonomyException
     */
    public function getTags($resourceType, $grouping, $groupingValue, $tags, $hash, $search, $regex, $relation, $order, $startDate, $endDate, $start = 0, $end = 19) {
        
        $query = new GetTagsQuery($this->apiURL, $this->accessor, $this->username, $start, $end);
        
        if($resourceType) {
            $query->setResourceType($resourceType);
        }
        if($grouping && $groupingValue) {
            $query->setGrouping($grouping, $groupingValue);
        } 
        if($order) {
            $query->setOrder($order);
        }
        if($regex) {
            $query->setFilter($regex);
        }
        
        $query->execute();
        $response = $query->getResponse();
        //print_r($response);
        if($response->isError()) {
            throw new BibsonomyException($response->getMessage(), E_WARNING);
        } else {
            return json_decode($response->getBody());
        }
    }

    public function getRelatedTags($resourceType, $grouping, $groupingValue, $relatedTags, $regex, $order, $start = 0, $end = 19) {
        
        $query = new GetTagRelationQuery($this->apiURL, $this->accessor, $relatedTags, $this->username, $start, $end);
        
        if($resourceType) {
            $query->setResourceType($resourceType);
        }
        if($grouping && $groupingValue) {
            $query->setGrouping($grouping, $groupingValue);
        } 
        if($order) {
            $query->setOrder($order);
        }
        if($regex) {
            $query->setFilter($regex);
        }
        
        $query->execute();
        $response = $query->getResponse();
        
        if($response->isError()) {
            throw new BibsonomyException($response->getMessage(), E_WARNING);
        } else {
            return json_decode($response->getBody());
        }
    }
    
    public function getUserDetails($username) {
        
    }

    public function getUserRelationship($sourceUser, $relation, $tag) {
        throw new UnsupportedOperationException("Operation not supported.");
    }

    public function getUsers($resourceType, $grouping, $groupingName, $tags, $hash, $order, $relation, $search, $start, $end) {
        
    }

    public function updateConcept($concept, $grouping, $groupingName, $operation) {
        throw new UnsupportedOperationException("Operation not supported.");
    }

    public function updateGroup($group, $operation) {
        throw new UnsupportedOperationException("Operation not supported.");
    }

    public function updateTags($user, $tagsToReplace, $replacementTags, $updateRelations) {
        throw new UnsupportedOperationException("Operation not supported.");
    }

    public function updateUser($user, $operation) {
        throw new UnsupportedOperationException("Operation not supported.");
    }

    /**
     * 
     * @param stdClass $posts
     */
    public function createPosts($posts) {
       
        $query = new CreatePostQuery($this->apiURL, $this->accessor, $this->username, $posts);
        $query->execute();
        $response = $query->getResponse();
        //print_r($response);
        if($response->isError()) {
            $error = "";
            $body = json_decode($response->getBody());
            if($body->error) {
                $error = ": ".$body->error;
            }
            throw new BibsonomyException($response->getMessage().$error, E_WARNING);
        } else {
            return json_decode($response->getBody());
        }
        
    }

    public function getPostDetails($username, $resourceHash) {
        throw new UnsupportedOperationException("Operation not supported.");
    }
    
    /**
     * @param string $username
     * @param string $resourceHash
     */
    public function deletePosts($username, $resourceHash) {
        $query = new DeletePostQuery($this->apiURL, $this->accessor, $username, $resourceHash);
        $query->execute();
        $response = $query->getResponse();
        
        if($response->isError()) {
            throw new BibsonomyException($response->getMessage(), E_WARNING);
        } else {
            return json_decode($response->getBody());
        }
        
    }


    public function getPostStatistics($resourceType, $grouping, $groupingName, $tags, $hash, $search, $filter, $constraint, $order, $startDate, $endDate, $start, $end) {
        
    }

    /**
     * 
     * @param string $resourceType (publication|bookmark)
     * @param string $grouping (RESTConfig::GROUPING_...
     * @param string $groupingValue (username, groupName etc...)
     * @param array $tags tags
     * @param string $hash intrahash
     * @param string $search search pattern
     * @param type $filter //not implemented yet
     * @param string $order 
     * @param type $startDate //not implemented yet
     * @param type $endDate //not implemented yet
     * @param int $start  start position of a range (optional) = 0
     * @param int $end end position of a range (optional = 19
     * @return stdObject
     * @throws BibsonomyException
     */
    public function getPosts($resourceType, $grouping, $groupingValue, $tags, $hash, $search, $filter, $order, $startDate, $endDate, $start = 0, $end = 19) {
        
        $query = new GetPostsQuery($this->apiURL, $this->accessor, $this->username, $start, $end);
        
        if($resourceType) {
            $query->setResourceType($resourceType);
        }
        if($grouping && $groupingValue) {
            $query->setGrouping($grouping, $groupingValue);
        }
        if(!empty($tags)) {
            $query->setTags($tags);
        }
        if($hash) {
            $query->setResourceHash($hash);
        }
        if($search) {
            $query->setSearch($search);
        }
        if($filter) {
            //$query->set
        }
        if($order) {
            $query->setOrder($order);
        }
        if($startDate) {
            //$query->set
        }
        if($endDate) {
            //$query->set
        }
        
        $query->execute();
        $response = $query->getResponse();
        
        if($response->isError()) {
            throw new BibsonomyException($response->getMessage(), E_WARNING);
        } else {
            return json_decode($response->getBody());
        }
    }

    /**
     * 
     * @param type $posts
     * @param type $username
     * @return type
     * @throws BibsonomyException
     */
    public function updatePosts($posts, $username) {

        /*
         * FIXME: this iteration should be done on the server, i.e.,
         * CreatePostQuery should support several posts ... although it's
         * probably not so simple.
         */
	$resourceHashes = array();
		
        foreach($posts as $obj) {
            $query = new ChangePostQuery($this->apiURL, $this->accessor, $username, $obj->post->bibtex->intrahash, $obj);
            $query->execute();
            $response = $query->getResponse();
            if ($response->isError()) {
                throw new BibsonomyException($response->getMessage(), E_WARNING);
            }
            // hashes are recalculated by the server
            
            $res = $query->getResult();
            //print_r($res);
            if($res->stat == 'ok') {
                $resourceHashes[] = $res->resourcehash;
            }
        }
        return $resourceHashes;
    }


}
?>