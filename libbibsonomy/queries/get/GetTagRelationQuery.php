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
 * Use this Class to receive a list of related tags
 * 
 * @author Sebastian Böttger <boettger@cs.uni-kassel.de>
 * @version $Id: GetTagsQuery.java,v 1.22 2012-01-20 11:36:10 folke Exp $
 */
class GetTagRelationQuery extends AbstractQuery {
    

    private $start;
    private $end;
    private $filter = null;
    private $order = null;
    private $grouping = 'ALL';
    private $groupingValue;
    private $resourceType;
    private $relatedTags;
        
    public function __construct($apiHostUrl, AuthenticationAccessor $accessor, array $relatedTags, $username, $start = 0, $end = 19) {
        parent::__construct($apiHostUrl, $accessor, $username);
        if ($start < 0) {
            $start = 0;
        }
        if ($end < $start) {
            $end = $start;
        }

        $this->start = $start;
        $this->end = $end;
        $this->relatedTags = $relatedTags;
    }

    /**
     * Set the grouping used for this query. If {@link GroupingEntity#ALL} is
     * chosen, the groupingValue isn't evaluated (-> it can be null or empty).
     * 
     * @param grouping
     *            the grouping to use
     * @param groupingValue
     *            the value for the chosen grouping; for example the username if
     *            grouping is {@link GroupingEntity#USER}
     */
    public function setGrouping($grouping, $groupingValue) {
        
        if($grouping == 'ALL') {
            $this->grouping = $grouping;
            return;
        }

        if($groupingValue == null || strlen($groupingValue) == 0) 
            throw new IllegalArgumentException("no grouping value given");

        $this->grouping = $grouping;
        $this->groupingValue = $groupingValue;
    }

    /**
     * @param order the order to set
     */
    public function setOrder($order) {
        $this->order = $order;
    }

    /**
     * TODO: change to Class<? extends Resource> and reuse methods of the {@link ResourceFactory}
     * Be careful with 'bibtex' (ensure on rest server that {@link ResourceFactory} is used too)
     * 
     * Set the content type of this query, i.e. whether to retrieve only tags 
     * beloning to bookmarks or bibtexs
     * 
     * @param resourceType
     */
    public function setResourceType($resourceType) {
            $this->resourceType = $resourceType;
    }

    /**
     * @param filter
     *            The filter to set.
     */
    public function setFilter($filter) {
            $this->filter = $filter;
    }

    /**
     * @return void
     */
    protected function query() {

        $this->url = $this->apiHostUrl . "/";
        
        if(empty($this->relatedTags)) {
            throw new IllegalArgumentException("no relation tag(s) given");
        }
        $relTags = "";
        for($i = count($this->relatedTags); $i > 0; --$i) {
            $relTags .= $this->relatedTags[$i-1];
            if($i > 1) {
                $relTags .= "+";
            }
        }
        
        $this->url .= RESTConfig::TAGS_URL . "/" . $relTags . "?" . RESTConfig::TAG_REL_PARAM;
        
        $this->url .= '&'. RESTConfig::START_PARAM . "=" . 
                $this->start . "&" . RESTConfig::END_PARAM . "=" . $this->end;

        if($this->order != null) {
            $this->url .= "&" . RESTConfig::ORDER_PARAM . "=" . $this->order;
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
        }

        if(!empty($this->filter)) {
            $this->url .= "&" . RESTConfig::FILTER_PARAM . "=" . $this->filter;
        }

        if($this->resourceType != null) {
            $this->url .= "&" . RESTConfig::RESOURCE_TYPE_PARAM . "=" . $this->resourceType;
        }	

    }
        
    protected function doExecute() {
                //sets url
        $this->query();
        
        $client = $this->accessor->getClient();
        
        $client->setMethod(Zend_Http_Client::GET);
        $client->setHeaders(Zend_Http_Client::CONTENT_TYPE, 'application/json;charset=UTF-8');
        
        $client->setUri(
            Zend_Uri_Http::fromString($this->url)
        );
        
        $this->response = $client->request();
    }   //put your code here
}

?>
