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

require_once __DIR__.'/PostLogicInterface.php';

/**
 *
 * @author Sebastian Böttger <boettger@cs.uni-kassel.de>
 */
interface LogicInterface extends PostLogicInterface {

	/**
	 * @return the name of the authenticated user
	 */
	public function getAuthenticatedUser();
	
	/**
         * URL: /users
         * 
         * 
	 * Generic method to retrieve lists of users
	 * 
	 * @param resourceType
	 * 			- restrict users by a certain resource type
	 * @param grouping
	 * 			- the grouping entity
	 * @param groupingName
	 * 			- the grouping name
	 * @param tags
	 * 			- a list of tags by which to retrieve users (e.g., users related to these tags by folkrank)
	 * @param hash
	 * 			- a resourcehash 
	 * @param order
	 * 			- the order by which to retrieve the users
	 * @param relation
	 * 			- the relation between the users
	 * @param search
	 * 			- a search string
	 * @param start
	 * @param end
	 * 
	 * @return list of user
	 */
	public function getUsers($resourceType, $grouping, $groupingName, $tags, $hash, $order,  $relation, $search, $start, $end);	

	/**
         * 
         * /users/[username]
         * 
	 * Returns details about a specified user
	 * 
	 * @param userName name of the user we want to get details from
	 * @return details about a named user, null else
	 */
	public function getUserDetails($username);
	

	/**
         * 
         * /groups
         * 
	 * Returns all groups of the system.
	 * 
	 * @param end
	 * @param start
	 * @return a set of groups, an empty set else
	 */
	public function getGroups($start, $end);

	/**
         * 
         * /groups/[groupname]
         * 
	 * Returns details of one group.
	 * 
	 * @param groupName
	 * @return the group's details, null else
	 */
	public function getGroupDetails($groupName);

        
	/** 
         * 
         * /tags ?filter=[regex] ?(user|group|viewable)=[username/groupname] ?order=(frequency|alph)
         * 
	 * Returns a list of tags which can be filtered.
	 * @param resourceType
	 * 			  a resourceType (i.e. {@link BibTex} or {@link Bookmark}) to get tags
	 *  		  only from a bookmark or a publication entry
	 * @param grouping
	 *            grouping tells whom tags are to be shown: the tags of a user,
	 *            of a group or of the viewables.
	 * @param groupingName
	 *            name of the grouping. if grouping is user, then its the
	 *            username. if grouping is set to {@link GroupingEntity#ALL},
	 *            then its an empty string!
	 * @param tags
	 * @param hash
				  a resource hash (publication or bookmark)
	 * @param search - search string
	 * @param regex
	 *            a regular expression used to filter the tagnames
	 * @param relation TODO
	 * @param order 
	 * @param startDate - if given, only tags of posts that have been created after (inclusive) startDate are returned  
	 * @param endDate - if given, only tags of posts that have been created before (inclusive) endDate are returned 
	 * @param start
	 * @param end
	 * @return a set of tags, an empty list else
	 */
	public function getTags($resourceType, $grouping, $groupingName, $tags, $hash, $search, $regex, $relation, $order, $startDate, $endDate, $start, $end);


	
	/**
         * 
         * /tags/[tag]
         * 
	 * Returns details about a tag. Those details are:
	 * <ul>
	 * <li>details about the tag itself, like number of occurrences etc</li>
	 * <li>list of subtags</li>
	 * <li>list of supertags</li>
	 * <li>list of correlated tags</li>
	 * </ul>
	 * 
	 * @param tagName name of the tag
	 * @return the tag's details, null else
	 */
	public function getTagDetails($tagName);

        
	/** 
         * 
         * Unsupported Operation
         * 
         * Updates the tags of the given user by replacing ALL tags of <code>tagsToReplace</code>
	 * with ALL tags from <code>replacementTags</code>.
	 * <p>That means, in all posts which contain all of the first tags, those tags will be 
	 * replaced by the second tags.</p>
	 * <p>This method does not change relations/concepts!</p>
	 * 
	 * @param user - the user whose tags should be updated.
	 * @param tagsToReplace - the tags which should be replaced. Only when all tags occur
	 * together at the same post, they're replaced!
	 * 
	 * @param replacementTags - the tags which replace the other tags.
	 * @param updateRelations - if true additional to the replace of the tags the corresponding relations are updated,
	 * be aware that this can only be done if tagsToReplace.size == 1 and replacementTags == 1
	 * @return - The number of posts which were updated.
	 */
	public function updateTags($user, $tagsToReplace, $replacementTags, $updateRelations);
	
	/**
         * 
         * Unsupported Operation
         * 
	 * Removes the given user.
	 * 
	 * @param userName the user to delete
	 */
	public function deleteUser($username);

	/**
         * 
         * Unsupported Operation
         * 
	 * Removes the given group.
	 * 
	 * @param groupName the group to delete
	 */
	public function deleteGroup($groupName);

	/**
         * 
         * Unsupported Operation
         * 
	 * Removes an user from a group.
	 * 
	 * @param groupName the group to change
	 * @param userName the user to remove
	 */
	public function deleteUserFromGroup($groupName, $username);

	/**
         * 
         * Unsupported Operation
         * 
	 * Adds a user to the database.
	 * 
	 * @param user  the user to add
	 * @return userid the user id of the created user
	 */
	public function createUser($user);

	/**
         * 
         * Unsupported Operation
         * 
	 * Updates a user to the database.
	 * 
	 * @param user  the user to update
	 * @param operation the user operation
	 * @return userid the user id of the updated user
	 */
	public function updateUser($user, $operation);

	/**
         * 
         * Unsupported Operation
         * 
	 * Adds a group to the database.
	 * 
	 * @param group  the group to add
	 * @return groupID the group id of the created group
	 */
	public function createGroup($group);

	/**
         * 
         * Unsupported Operation
         * 
	 * Updates a group in the database.
	 * 
	 * Depending on the {@link GroupUpdateOperation}, different actions are done:
	 * <dl>
	 * <dt>{@link GroupUpdateOperation#ADD_NEW_USER}</dt><dd>Adds an existing user to an existing group.</dd>
	 * <dt>{@link GroupUpdateOperation#UPDATE_SETTINGS}</dt><dd>Updates the settings of the group.</dd>
	 * <dt>{@link GroupUpdateOperation#UPDATE_ALL}</dt><dd>Updates the complete group.</dd>
	 * </dl>
	 * 
	 * 
	 * @param group  the group to update
	 * @param operation the operation which should be performed
	 * @return groupID the group id of the updated group
	 */
	public function updateGroup($group, $operation);

	/**
         * 
         * Unsupported Operation
         * 
	 * Adds a document. If the resourceHash is given, the document is connected
	 * to the corresponding post. Otherwise, the document is independent of any
	 * post (e.g., a layout file.
	 * 
	 * @param document
	 * @param resourceHash
	 * 
	 * @return The hash of the created document.
	 */
	public function createDocument($document, $resourceHash);


	/**
         * 
         * Unsupported Operation
         * 
	 * Get a document from an existing Bibtex entry
	 * @param userName 
	 * @param resourceHash 
	 * @param fileName 
	 * 
	 * @return document
	 */
	public function getDocument($username, $resourceHash, $fileName = null);

	/**
         * Unsupported Operation
         * 
	 * Deletes an existing document. If the resourceHash is given, the document
	 * is assumed to be connected to the corresponding resource (identified by 
	 * the user name in the document). Otherwise the document is independent of
	 * any post.
         *
	 * @param document - the document which should be deleted.  
	 * @param resourceHash - the hash of a post the document belongs to.
	 */
	public function deleteDocument($document, $resourceHash);

	
	/**
         * 
         * GET /users/[username]/concepts/[conceptname]
         * 
	 * Retrieve relations
	 * 
	 * @param conceptName - the supertag of the concept
         * 
	 * @param grouping - grouping entity RESTConfig::GROUPING_<xyz>
         * 
	 * @param groupingName - the grouping name	
	 * @return a concept, i.e. a tag containing its assigned subtags
         * @author sts
	 */
	public function getConceptDetails($conceptName, $grouping, $groupingName);

	/**
         * 
         * POST /users/[username]/concepts/[conceptname]
         * 
	 * Create a new relation/concept
	 * 
	 * @param concept - the new concept
	 * @param grouping - grouping entity
	 * @param groupingName - the grouping name
	 * @return the name of the superconcept-tag, note: if a concept already exists with the given name
	 * it will be replaced
	 * @author sts
	 */
	public function createConcept($concept, $grouping, $groupingName);

	/**
         * PUT /users/[username]/concepts/[conceptname]
         * 
	 * Update an existing relation/concept
	 * 
	 * @param concept - the concept to update
	 * @param grouping - grouping entity
	 * @param groupingName - the grouping name	
	 * @param operation
	 * @return the name of the superconcept-tag  
	 * @author sts
	 */
	public function updateConcept($concept, $grouping, $groupingName, $operation);

	/**
         * 
         * DELETE /users/[username]/concepts/[conceptname]
         * 
	 * Delete an existing concept
	 * 
	 * @param concept - the concept to delete
	 * @param grouping - grouping entity
	 * @param groupingName - the grouping name	 
         * @author sts
	 */
	public function deleteConcept($concept, $grouping, $groupingName);

	
	/**
         * /concepts
         * 
	 * Retrieve relations
	 * 
	 * @param resourceType - the reqtested resourcetype
	 * @param grouping - grouping entity
	 * @param groupingName - the grouping name
	 * @param regex - a regex to possibly filter the relatons retrieved
	 * @param tags - a list of tags which shall be part of the relations
	 * @param status - the conceptstatus, i.e. all, picked or unpicked
	 * @param start - start index
	 * @param end - end index
	 * @return a list of concepts, i.e. tags containing their assigned subtags
	 */
	public function getConcepts($resourceType, $grouping, $groupingName, $regex, $tags, $status, $start, $end);
	

	/** 
         * 
         * Unsupported Operation
         * 
	 * We return all Users that are in (the) relation with the sourceUser
	 * as targets.
	 * @param sourceUser - leftHandSide of the relation
	 * @param relation - the User relation
	 * @param tag - relationships can also be tagged (e.g. for customized friendship lists or external friends from facebook etc)
	 * @return all rightHandsides, that is all Users u with
	 * (sourceUser, u)\in relation
	 */
	public function getUserRelationship($sourceUser, $relation, $tag);
	
	/**
         * Unsupported Operation
         * 
	 * We delete a UserRelation of the form (sourceUser, targetUser)\in relation
	 * sourceUser should be logged in to have access to this
	 * 
	 * @param sourceUser - leftHandSide of the relation
	 * @param targetUser - rightHandSie of the relation 
	 * @param relation - the type of the relation
	 * @param tag - relations can also be tagged
	 * 
	 */
	public function deleteUserRelationship($sourceUser, $targetUser, $relation, $tag);
	
	/**
         * 
         * Unsupported Operation
         * 
	 * We create a UserRelation of the form (sourceUser, targetUser)\in relation
	 * sourceUser should be logged in for this
	 * 
	 * @param sourceUser - leftHandSide of the relation
	 * @param targetUser - rightHandSie of the relation 
	 * @param relation - the type of the relation
	 * @param tag - relations can also be tagged
	 */
	public function createUserRelationship($sourceUser, $targetUser, $relation, $tag);
	

		
}
?>
