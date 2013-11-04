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

/**
 *
 * @author Sebastian Böttger <boettger@cs.uni-kassel.de>
 */
interface PostLogicInterface {
    
    /**  
     * retrieves a filterable list of posts.
     * 
     * @param <T> resource type to be shown.
     * @param resourceType resource type to be shown.
     * @param grouping
     *            grouping tells whom posts are to be shown: the posts of a
     *            user, of a group or of the viewables.
     * @param groupingName
     *            name of the grouping. if grouping is user, then its the
     *            username. if grouping is set to {@link GroupingEntity#ALL},
     *            then its an empty string!
     * @param tags
     *            a set of tags. remember to parse special tags like
     *            ->[tagname], -->[tagname] and <->[tagname]. see documentation.
     *            if the parameter is not used, its an empty list
     * @param hash
     *            hash value of a resource, if one would like to get a list of
     *            all posts belonging to a given resource. if unused, its empty
     *            but not null.
     * @param search - free text search
     * @param filter - filter for the retrieved posts
     * @param order - a flag indicating the way of sorting
     * @param startDate - if given, only posts that have been created after (inclusive) startDate are returned  
     * @param endDate - if given, only posts that have been created before (inclusive) endDate are returned 
     * @param start - inclusive start index of the view window
     * @param end - exclusive end index of the view window
     * @return A filtered list of posts. may be empty but not null
     */
    public function getPosts($resourceType, $grouping, $groupingName, $tags, $hash, $search, $filter, $order, $startDate, $endDate, $start, $end);

    /**
     * Returns details to a post. A post is uniquely identified by a hash of the
     * corresponding resource and a username.
     * 
     * @param resourceHash hash value of the corresponding resource
     * @param userName name of the post-owner
     * @return the post's details, null else
     * @throws ResourceMovedException  - when no resource 
     * with that hash exists for that user, but once a resource 
     * with that hash existed that has been moved. The new hash 
     * is returned inside the exception. 
     * @throws ResourceNotFoundException 
     */
    public function getPostDetails($username, $resourceHash);

    /**
     * Removes the given post - identified by the connected resource's hash -
     * from the user.
     * 
     * @param string username user who's posts are to be removed
     * @param string resourceHash
     *            hash of the resource, which is connected to the post to delete
     */
    public function deletePosts($username, $resourceHashes);

    /**
     * Add the posts to the database.
     * 
     * @param posts  the posts to add
     * @return the resource hashes of the created posts
     */
    public function createPosts($posts);

    /**
     * Updates the posts in the database.
     * 
     * @param posts  the posts to update
     * @return resourceHashes the (new) hashes of the updated resources
     */
    public function updatePosts($posts, $username);

    /**  
     * retrieves the number of posts matching to the given constraints
     * 
     * @param resourceType resource type to be shown.
     * @param grouping
     *            grouping tells whom posts are to be shown: the posts of a
     *            user, of a group or of the viewables.
     * @param groupingName
     *            name of the grouping. if grouping is user, then its the
     *            username. if grouping is set to {@link GroupingEntity#ALL},
     *            then its an empty string!
     * @param tags
     *            a set of tags. remember to parse special tags like
     *            ->[tagname], -->[tagname] and <->[tagname]. see documentation.
     *            if the parameter is not used, its an empty list
     * @param hash
     *            hash value of a resource, if one would like to get a list of
     *            all posts belonging to a given resource. if unused, its empty
     *            but not null.
     * @param search free text search
     * @param filter filter for the retrieved posts
     * @param constraint - a possible constraint on the statistics
     * @param order a flag indicating the way of sorting
     * @param startDate - if given, only posts that have been created after (inclusive) startDate are regarded  
     * @param endDate - if given, only posts that have been created before (inclusive) endDate are regarded
     * @param start inclusive start index of the view window
     * @param end exclusive end index of the view window
     * @return a filtered list of posts. may be empty but not null
     */
    public function getPostStatistics($resourceType, $grouping, $groupingName, $tags, $hash, $search, $filter, $constraint, $order, $startDate, $endDate, $start, $end);

}

?>
