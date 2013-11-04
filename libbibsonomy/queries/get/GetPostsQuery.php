<?php
/**
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
 * Use this Class to receive an ordered list of all posts.
 * 
 * @author Sebastian Böttger <boettger@cs.uni-kassel.de>
 */

class GetPostsQuery extends AbstractQuery {


    private $start;
    private $end;
    private $order;
    private $search;
    private $resourceType;
    private $tags;
    private $grouping = "ALL";
    private $groupingValue;
    private $resourceHash;
    private $username;

    
    /**
     * Gets bibsonomy's posts list.
     * 
     * @param start
     *            start of the list
     * @param end
     *            end of the list
     */
    public function __construct($apiHostUrl, AuthenticationAccessor $accessor, $username, $start = 0, $end = 19) {

        parent::__construct($apiHostUrl, $accessor, $username);
        if ($start < 0) {
            $start = 0;
        }
        if ($end < $start) {
            $end = $start;
        }

        $this->start = $start;
        $this->end = $end;
    }

    /**
     * Set the grouping used for this query. If {@link GroupingEntity#ALL} is
     * chosen, the groupingValue isn't evaluated (-> it can be null or empty).
     * 
     * @param string $grouping
     *            the grouping to use
     * @param string $groupingValue
     *            the value for the chosen grouping; for example the username if
     *            grouping is {@link GroupingEntity#USER}
     * @throws IllegalArgumentException
     *             if grouping is != {'ALL'} and
     *             groupingValue is null or empty
     */
    public function setGrouping($grouping, $groupingValue) {
        if($grouping == GROUPING::ALL) {
            $this->grouping = $grouping;
            return;
        }

        if ($groupingValue == null || strlen($groupingValue) == 0) {
            throw new IllegalArgumentException("no grouping value given");
        }

        $this->grouping = $grouping;
        $this->groupingValue = $groupingValue;
    }

    /**
     * set the resource type of the resources of the posts.
     * 
     * @param type
     *            the type to set
     */
    public function setResourceType($type) {
        $this->resourceType = $type;
    }

    /**
     * @param string resourceHash
     *            The resourceHash to set.
     */
    public function setResourceHash($resourceHash) {
            $this->resourceHash = $resourceHash;
    }

    /**
     * @param array tags
     *            the tags to set as array of strings
     */
    public function setTags($tags) {
            $this->tags = $tags;
    }

    /**
     * @param string $order
     *            the order to set
     */
    public function setOrder($order) {
            $this->order = urlencode($order);
    }

    /**
     * @param string $search
     *            the search string to set
     */
    public function setSearch($search) {
            
            $this->search = urlencode($search);
    }

    
    protected function doExecute() {
        
        //sets url
        $this->query();
        //print_r($this->url);
        $this->url = $this->apiHostUrl . "/". $this->url;
        
        //print_r($this->url);
        $client = $this->accessor->getClient();
        
        $client->setMethod(Zend_Http_Client::GET);
        $client->setHeaders(Zend_Http_Client::CONTENT_TYPE, 'application/json;charset=UTF-8');
        
        $client->setUri(
            Zend_Uri_Http::fromString($this->url)
        );
        
        $this->response = $client->request();
    }
    
    /**
     * 
     * @return string
     * @throws UnsupportedOperationException
     */
    protected function query() {
        
        $this->url = RESTConfig::POSTS_URL . "?" . RESTConfig::START_PARAM . "=" . 
                $this->start . "&" . RESTConfig::END_PARAM . "=" . $this->end;

        /*
        if ($this->resourceType != Resource.class) {
                    url += "&" + RESTConfig.RESOURCE_TYPE_PARAM + "=" + $this.resourceType).toLowerCase();
            }
        */
        
        if($this->resourceType) {
            $this->url .= '&resourcetype='.$this->resourceType;
        }
        
        switch ($this->grouping) {
            case GROUPING::USER:
                $this->url .= "&user=" . $this->groupingValue;
                break;
            case GROUPING::GROUP:
                $this->url .= "&group=" . $this->groupingValue;
                break;
            case GROUPING::VIEWABLE:
                $this->url .= "&viewable=" . $this->groupingValue;
                break;
            case GROUPING::ALL:
                break;
            case GROUPING::FRIEND:
                $this->url .= "&friend=" . $this->groupingValue;
                break;
            case GROUPING::CLIPBOARD:
                return RESTConfig::USERS_URL . "/" . $this->username . "/" . RESTConfig::CLIPBOARD_SUBSTRING;
                    
            default:
                throw new UnsupportedOperationException("The grouping " . $this->grouping . " is currently not supported by this query.");
        }

        if(!empty($this->tags)) {
            $first = true;
            foreach($this->tags as $tag) {
                if ($first) {
                    $this->url .= "&" . RESTConfig::TAGS_PARAM . "=" . urlencode($tag);
                    $first = false;
                } else {
                    $this->url .= "+" . $tag;
                }
            }
        }

        if($this->resourceHash != null && strlen($this->resourceHash) > 0) {
                $this->url .= "&" . RESTConfig::RESOURCE_PARAM . "=2" . $this->resourceHash;
        }

        if ($this->order != null) {
                $this->url .= "&" . RESTConfig::ORDER_PARAM . "=" . $this->order;
        }

        if ($this->search != null && strlen($this->search) > 0) {
                $this->url .= "&" . RESTConfig::SEARCH_PARAM . "=" . $this->search;
        }
        
    }

    /**
     * @param userName
     *            the userName to set
     */
    public function setUserName($username) {
            $this->username = $username;
    }
}
?>