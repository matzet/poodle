<?php

require_once('../../config.php');
require_once('lib.php');
require_once('BibsonomyFacade.php');
require_once('ViewDocuments.php');

global $DB;
global $PAGE;

$id   = optional_param('id', 0, PARAM_INT);
//error_log("view_poodle");
$PAGE->set_url('/mod/poodle/view.php');

if($id) {
    //$o = $DB->get_record('user', array('id'=>$id));
    $o = get_coursemodule_from_id('poodle', $id);
    $record = $DB->get_record('poodle', array('course' => $o->course, 'id' => $o->instance));
    if($record) {
        $facade = new BibsonomyFacade($record->api_user, $record->api_key);
        $docs = $facade->fetchPublications($record->user, explode(',',$record->tags));
        $view = new ViewDocuments($docs);
        $view->display();
        return;
    }
    print_error('');
}

?>