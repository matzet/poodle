<?php

function poodle_add_instance($choice) {
	global $DB;
	return $DB->insert_record("poodle", $choice);
}

function poodle_update_instance($o) {
    global $DB;
    $o->id = $o->instance;
    $DB->update_record("poodle", $o);
    return true;
}

function poodle_delete_instance($id) {
    
}
