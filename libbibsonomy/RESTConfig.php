<?php

/**
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
 * DO NOT CHANGE any constant values after a release
 * 
 * @package BibSonomyAPI - PHP REST-client for BibSonomy API and PUMA API.
 * 
 * @author Sebastian Böttger <boettger@cs.uni-kassel.de>
 */

class RESTConfig {
    
    const POSTS_URL = "posts";

    const POSTS_ADDED_SUB_PATH = "added";

    const POSTS_ADDED_URL = "posts/added";

    const POSTS_POPULAR_SUB_PATH = "popular";

    const POSTS_POPULAR_URL = "posts/popular";

    const COMMUNITY_SUB_PATH = "community";

    const API_USER_AGENT = "BibSonomyWebServiceClient";

    const SYNC_URL = "sync";

    const CONCEPTS_URL = "concepts";

    const TAGS_URL = "tags";

    const REFERENCES_SUB_PATH = "references";

    const USERS_URL = "users";

    const DOCUMENTS_SUB_PATH = "documents";

    const FRIENDS_SUB_PATH = "friends";

    const FOLLOWERS_SUB_PATH = "followers";

    const GROUPS_URL = "groups";

    const RESOURCE_TYPE_PARAM = "resourcetype";

    const RESOURCE_PARAM = "resource";

    const TAGS_PARAM = "tags";

    const FILTER_PARAM = "filter";

    const ORDER_PARAM = "order";

    const CONCEPT_STATUS_PARAM = "status";

    const SEARCH_PARAM = "search";

    const SUB_TAG_PARAM = "subtag";

    const REGEX_PARAM = self::FILTER_PARAM;

    const START_PARAM = "start";

    const END_PARAM = "end";

    const SYNC_STRATEGY_PARAM = "strategy";

    const SYNC_DIRECTION_PARAM = "direction";

    const SYNC_DATE_PARAM = "date";

    const SYNC_STATUS = "status";

    const CLIPBOARD_SUBSTRING = "clipboard";

    const CLIPBOARD_CLEAR = "clear";

    
    const TAG_REL_PARAM = "relation=related";
    
    /**
     * Request Attribute ?relation="incoming/outgoing"
     */
    const ATTRIBUTE_KEY_RELATION = "relation";

    /** value for "incoming" */
    const INCOMING_ATTRIBUTE_VALUE_RELATION = "incoming";

    /** value for "outgoing" */
    const OUTGOING_ATTRIBUTE_VALUE_RELATION = "outgoing";

    /** default value */
    const DEFAULT_ATTRIBUTE_VALUE_RELATION = self::INCOMING_ATTRIBUTE_VALUE_RELATION;

    /** place holder for the login user - used e.g. for OAuth requests */
    const USER_ME = "@me";

}

/**
 * 
 * @author Sebastian Böttger <boettger@cs.uni-kassel.de>
 */
class Grouping {    
        
    const ALL = 'ALL';
    
    const USER = 'USER';
    
    const GROUP = 'GROUP';
    
    const VIEWABLE = "VIEWABLE";
    
    const FRIEND = "FRIEND";
    
    const CLIPBOARD = "CLIPBOARD";
    
}


/**
 * Contains constant values of all BibTeX Entry types.
 * 
 * @author Sebastian Böttger <boettger@cs.uni-kassel.de>
 */
class Entrytype {
    
    /**
     * An article from a journal or magazine. 
     * Required fields: author, title, journal, year
     * Optional fields: volume, number, pages, month, note, key
     * @var string
     */
    const ARTICLE = 'article';

    /**
     * A book with an explicit publisher.
     * Required fields: author/editor, title, publisher, year
     * Optional fields: volume/number, series, address, edition, month, note, key
     * @var string
     */
    const BOOK = 'book';

    /**
     * A work that is printed and bound, but without a named publisher or sponsoring institution.
     * Required fields: title
     * Optional fields: author, howpublished, address, month, year, note, key
     * @var string
     */
    const BOOKLET = 'booklet';
    
    /**
     * The same as inproceedings, included for Scribe compatibility.
     * @var string
     */
    const CONFERENCE = 'conference';
 
    /**
     * A part of a book, usually untitled. May be a chapter (or section or whatever) and/or a range of pages.
     * Required fields: author/editor, title, chapter/pages, publisher, year
     * Optional fields: volume/number, series, type, address, edition, month, note, key
     * @var string
     */
    const INBOOK = 'inbook';

    /**
     * A part of a book having its own title. 
     * Required fields: author, title, booktitle, publisher, year 
     * Optional fields: editor, volume/number, series, type, chapter, pages, address, edition, month, note, key 
     * @var string
     */
    const INCOLLECTION = 'incollection';
    
    /**
     * An article in a conference proceedings.
     * Required fields: author, title, booktitle, year
     * Optional fields: editor, volume/number, series, pages, address, month, organization, publisher, note, key
     * @var string
     */ 
    const INPROCEEDINGS = 'inproceedings';

    /**
     * Technical documentation.
     * Required fields: title
     * Optional fields: author, organization, address, edition, month, year, note, key
     * @var string
     */
    const MANUAL = 'manual';

    /**
     * A Master's thesis.
     * Required fields: author, title, school, year
     * Optional fields: type, address, month, note, key
     * @var string
     */
    const MASTERTHESIS = 'mastersthesis';

    /**
     * For use when nothing else fits.
     * Required fields: none
     * Optional fields: author, title, howpublished, month, year, note, key
     * @var string
     */
    const MISC = 'misc';
    
    /** 
     * A Ph.D. thesis.
     * Required fields: author, title, school, year
     * Optional fields: type, address, month, note, key
     * @var string
     */
    const PHDTHESIS = 'phdthesis';

    /**
     * The proceedings of a conference.
     * Required fields: title, year
     * Optional fields: editor, volume/number, series, address, month, publisher, organization, note, key
     * @var string
     */
    const PROCEEDINGS = 'proceedings';
    
    /**
     * A report published by a school or other institution, usually numbered within a series.
     * Required fields: author, title, institution, year
     * Optional fields: type, number, address, month, note, key
     * @var string
     */
    const TECHREPORT = 'techreport';

    /**
     * A document having an author and title, but not formally published.
     * Required fields: author, title, note
     * Optional fields: month, year, key
     * @var string
     */
    const UNPUBLISHED = 'unpublished';

}
