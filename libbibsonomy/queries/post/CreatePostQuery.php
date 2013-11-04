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

require_once __DIR__.'/../AbstractQuery.php';
require_once __DIR__.'/../../exceptions/IllegalArgumentException.php';


/**
 * Use this Class to post a post. ;)
 * 
 * @author Sebastian Böttger <boettger@cs.uni-kassel.de>
 * 
 */
class CreatePostQuery extends AbstractQuery {
    
    private $post;
    
    private $username;

    /**
     * Creates a new post in bibsonomy.
     * 
     * @param string $apiHostUrl
     * 
     * @param AuthenticationAccessor $accessor
     * 
     * @param string $username
     *            the username under which the post is to be created
     * @param stdClass $post
     *            the post to be created (stdClass)
     * @throws IllegalArgumentException
     * 
     */
    public function __construct($apiHostUrl, AuthenticationAccessor $accessor, $username, $posts) {
        
        parent::__construct($apiHostUrl, $accessor);
        
        if(empty($username)) throw new IllegalArgumentException("no username given");
        if(empty($posts)) throw new IllegalArgumentException("no post specified");
        
         
        if(!@isset($posts->post->bookmark) && !@isset($posts->post->bibtex)) {
            throw new IllegalArgumentException("no resource specified");
        }

        if(@isset($posts->post->bookmark)) {
            $bookmark = $posts->post->bookmark;
            if(empty($bookmark->url))
                throw new IllegalArgumentException("no url specified in bookmark");
        }

        if(@isset($posts->post->bibtex)) {
            $publication = $posts->post->bibtex;
            if(empty($publication->title)) 
                throw new IllegalArgumentException("no title specified in bibtex");
        }

        if(@isset($posts->post->publicationFileUpload)) {
            $publication = $posts->post->publicationFileUpload; //array('marc' => marcobject, pica=>picaobject)
            //error_log(print_r($publication, true));
            if( !isset($publication) || !is_array($publication) ) {
                throw new IllegalArgumentException("no marc or pica field spezified");
            }
        }
        if(empty($posts->post->tag)) 
            throw new IllegalArgumentException("No tags specified");

        foreach(@$posts->post->tag as $tag) {
            if(empty($tag->name)) 
                throw new IllegalArgumentException("Missing tagname");
        }

        $this->username = $username;
        $this->post = $posts;
    }

    protected function doExecute() {
        
        $client = $this->accessor->getClient();
        $zendURI = $this->apiHostUrl."/".RESTConfig::USERS_URL . "/" . $this->username . "/" . RESTConfig::POSTS_URL;
        
        $client->setUri(
            Zend_Uri_Http::fromString(
                $zendURI
            )
        );
        
        $client->setMethod(Zend_Http_Client::POST);
        $client->setHeaders(Zend_Http_Client::CONTENT_TYPE, 'application/json;charset=UTF-8');
        
        if(!empty($this->post->post->publicationFileUpload['marc']) && !empty($this->post->post->publicationFileUpload['pica'])) {
            
            $marcRecord = $this->post->post->publicationFileUpload['marc'];
            $picaRecord = $this->post->post->publicationFileUpload['pica'];
            
            unset($this->post->post->publicationFileUpload);
            $this->post->post->publicationFileUpload = new stdClass();
            
            $this->post->post->publicationFileUpload->multipartName = 'marc:pica';
        } 

        $jsonPost = json_encode($this->post);
        
        if($this->post->post->publicationFileUpload->multipartName == 'marc:pica') {

            $client->setFileUpload($this->post->post->bibtex->uniqueid.".json", 'main', $jsonPost, 'application/json;charset=UTF-8');
            $client->setFileUpload($this->post->post->bibtex->uniqueid.".marc", 'marc', $marcRecord, 'application/marc;charset=UTF-8');
            $client->setFileUpload($this->post->post->bibtex->uniqueid.".pica", 'pica', $picaRecord, 'application/pica;charset=UTF-8');
        } else {
            $client->setRawData($jsonPost);
        }

        $this->response = $client->request();
        $this->result = json_decode($this->response->getBody());
    }

    public function getResult() {
        
        if($this->response->isSuccessful()) {
            
            return $this->result;
        }
        return $this->getError();
    }	
}