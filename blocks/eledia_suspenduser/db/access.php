<?php

defined('MOODLE_INTERNAL') || die();

$capabilities = array(

    'block/eledia_suspenduser:addinstance' => array(
        'captype' => 'write',
        'contextlevel' => CONTEXT_BLOCK,
        'archetypes' => array(),

        'clonepermissionsfrom' => 'moodle/site:manageblocks'
    ),
);
