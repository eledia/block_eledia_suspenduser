<?php  // $Id: config_suspenduser_form.php,v 1.6 2012-02-14 10:30:04 bwolf Exp $

if (!defined('MOODLE_INTERNAL')) {
    die('Direct access to this script is forbidden.');    ///  It must be included from a Moodle page
}

require_once($CFG->libdir.'/formslib.php');

class config_suspenduser_form extends moodleform {

    function definition() {
    global $CFG;

        $mform =& $this->_form;

        $mform->addElement('header', '', get_string('el_config_header', 'block_eledia_suspenduser'), 'config_suspenduser');
        //add config fields here

        if(!isset($CFG->eledia_suspenduserpath)){
            set_config('eledia_suspenduserpath', '/temp/');
        }
        $mform->addElement('text', 'eledia_suspenduserpath',  get_string('eledia_suspenduserpath','block_eledia_suspenduser'),  'maxlength="30" size="30"');
        $mform->setDefault('eledia_suspenduserpath', $CFG->eledia_suspenduserpath);
        $mform->setType('eledia_suspenduserpath', PARAM_URL);

        if(!isset($CFG->eledia_suspenduserfile)){
            set_config('eledia_suspenduserfile', 'suspend_users.csv');
        }
        $mform->addElement('text', 'eledia_suspenduserfile',  get_string('eledia_suspenduserfile','block_eledia_suspenduser'),  'maxlength="30" size="30"');
        $mform->setDefault('eledia_suspenduserfile', $CFG->eledia_suspenduserfile);
        $mform->setType('eledia_suspenduserfile', PARAM_FILE);

        $mform->addElement('submit', 'submitbutton', get_string('save_changes', 'block_eledia_suspenduser'));
        $mform->addElement('cancel', 'cancelbutton', get_string('back', 'block_eledia_suspenduser'));
    }

    function definition_after_data(){
        global $CFG;
        $mform =& $this->_form;

        if($mform->isSubmitted()){
            //save config here
            set_config('eledia_suspenduserpath', $mform->_submitValues['eledia_suspenduserpath']);
            set_config('eledia_suspenduserfile', $mform->_submitValues['eledia_suspenduserfile']);

            $mform->addElement('static', 'saved', '', get_string('saved', 'block_eledia_suspenduser'));
        }
    }
}
