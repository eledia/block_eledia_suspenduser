<?php

    require_once('../../config.php');
    require_once('config_suspenduser_form.php');

 /// Check for valid admin user - no guest autologin
    require_login(0, false);
    $PAGE->set_url('/blocks/eledia_suspenduser/config_suspenduser.php');
    $PAGE->set_context(get_context_instance(CONTEXT_SYSTEM));
    $PAGE->set_pagelayout('standard');

    $context = get_context_instance(CONTEXT_SYSTEM);

    require_capability('moodle/site:config', $context);

    $mform = new config_suspenduser_form();

    if ($mform->is_cancelled()) {
        redirect($CFG->httpswwwroot);

    } else if ($genparams = $mform->get_data()) {
//print_object($genparams);
    }

    $header = get_string('el_header', 'block_eledia_suspenduser');
    $PAGE->set_heading($header);

    echo $OUTPUT->header();
    $mform->display();
    echo $OUTPUT->footer();

