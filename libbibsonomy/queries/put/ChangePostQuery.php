<?php

/*
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

require_once __DIR__.'/../AbstractQuery.php';
require_once __DIR__.'/../../exceptions/IllegalArgumentException.php';

/**
 * Use this Class to change details of an existing post - change tags, for
 * example.
 * 
 * @author Sebastian Böttger <boettger@cs.uni-kassel.de>
 */
class ChangePostQuery extends AbstractQuery {
    
	private $post;
	private $username;
	private $resourceHash;
        private $url;
	/**
	 * Changes details of an existing post.
	 * 
         * @param string $apiHostUrl
         * 
         * @param AuthenticationAccessor $accessor
         *            BasicAuthAccessor or OAuthAccessor
	 * @param string $username
	 *            the username under which the post is to be created
	 * @param resourceHash
	 *            hash of the resource to change
	 * @param posts
	 *            the new value for the post
	 * @throws IllegalArgumentException
	 *             if
	 *             <ul>
	 *             <li>username or resourcehash are not specified</li>
	 *             <li>no resource is connected with the post</li>
	 *             <li>the resource is a bookmark: if no url is specified</li>
	 *             <li>the resource is a bibtex: if no title is specified</li>
	 *             <li>no tags are specified or the tags have no names</li>
	 *             </ul>
	 */
        public function __construct($apiHostUrl, AuthenticationAccessor $accessor, $username, $resourceHash, $posts) {
            if(empty($username)) throw new IllegalArgumentException("no username given");
            if(empty($resourceHash)) throw new IllegalArgumentException("no resourceHash given");
            if(empty($posts)) throw new IllegalArgumentException("no post specified");
            
            if(!$posts->post->bookmark && !$posts->post->bibtex) {
                throw new IllegalArgumentException("no resource specified");
            }

            if($posts->post->bookmark) {
                $bookmark = $posts->post->bookmark;
                if(empty($bookmark->url))
                    throw new IllegalArgumentException("no url specified in bookmark");
            }

            if($posts->post->bibtex) {
                $publication = $posts->post->bibtex;
                if(empty($publication->title)) 
                    throw new IllegalArgumentException("no title specified in bibtex");
            }
            
            if(empty($posts->post->tag)) 
                throw new IllegalArgumentException("no tags specified");

            foreach($posts->post->tag as $tag) {
                if(empty($tag->name)) 
                    throw new IllegalArgumentException("missing tagname");
            }
            
            $this->apiHostUrl = $apiHostUrl;
            $this->accessor = $accessor;
            $this->username = $username;
            $this->resourceHash = $resourceHash;
            $this->post = $posts;
        }
        
	protected function doExecute() {
            
            $this->query();
            
            $client = $this->accessor->getClient();

            $client->setUri(
                Zend_Uri_Http::fromString(
                    $this->url
                )
            );

            $client->setMethod(Zend_Http_Client::PUT);
            $client->setHeaders(Zend_Http_Client::CONTENT_TYPE, 'application/json;charset=UTF-8');

            $jsonPost = json_encode($this->post);
            $client->setRawData($jsonPost);


            $this->response = $client->request();
            $this->result = json_decode($this->response->getBody());
            //print_r($this->result);
	}
	
        public function query() {
            $this->url = $this->apiHostUrl."/".RESTConfig::USERS_URL . "/" . $this->username . "/" . RESTConfig::POSTS_URL . "/" . $this->resourceHash;
            //print_r($this->url);
        }
	
        public function getResult() {

            if(!empty($this->result) && $this->result->stat == 'ok') {

                return $this->result;
            }
            return $this->getError();
        }	
}
?>