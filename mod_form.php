<?php

if (!defined('MOODLE_INTERNAL')) {
	die('Direct access to this script is forbidden.');    ///  It must be included from a Moodle page
}

require_once($CFG->dirroot.'/course/moodleform_mod.php');

class mod_poodle_mod_form extends moodleform_mod {
	
	function definition() {
		global $CFG, $DB, $OUTPUT;
		$mform = &$this->_form;

		$name = get_string('modulename', 'poodle');

		//$mform->addElement($element);

                $mform->addElement('text', 'name', 'Poodle-Test');
                $mform->setType('name', PARAM_TEXT);
                $mform->addRule('name', null, 'required', null, 'client');
                
		$mform->addElement('text', 'api_user', 'API-User');
		$mform->setType('api_user', PARAM_TEXT);
		$mform->addRule('api_user', null, 'required', null, 'client');
		
		$mform->addElement('text', 'api_key', 'API-Key');
		$mform->setType('api_key', PARAM_TEXT);
		$mform->addRule('api_key', null, 'required', null, 'client');
                
                $mform->addElement('text', 'user', 'User');
                $mform->setType('user', PARAM_TEXT);
                $mform->addRule('user', null, 'required', null, 'client');
                
                $hint_tags = get_string('hint_form_tags', 'poodle');
                
                $mform->addElement('text', 'tags', 'Tags');
                $mform->setType('tags', PARAM_TAGLIST);
                $mform->addRule('tags', $hint_tags, 'optional', null, 'client');

		//$ynoptions = array(0 => get_string('no'),
		//		1 => get_string('yes'));
		$this->standard_coursemodule_elements();

		$this->add_action_buttons();
	}
}
