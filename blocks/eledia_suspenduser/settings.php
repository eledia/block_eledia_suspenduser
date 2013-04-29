<?php

defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {


    if(!isset($CFG->eledia_suspenduserpath)){
        set_config('eledia_suspenduserpath', '/temp/');
    }
    $settings->add(new admin_setting_configtext('eledia_suspenduserpath', get_string('eledia_suspenduserpath','block_eledia_suspenduser'),
                       get_string('eledia_suspenduserpath','block_eledia_suspenduser'), '/temp/', PARAM_URL));

    if(!isset($CFG->eledia_suspenduserfile)){
        set_config('eledia_suspenduserfile', 'suspend_users.csv');
    }
    $settings->add(new admin_setting_configtext('eledia_suspenduserfile', get_string('eledia_suspenduserfile','block_eledia_suspenduser'),
                       get_string('eledia_suspenduserfile','block_eledia_suspenduser'), 'suspend_users.csv', PARAM_FILE));

}