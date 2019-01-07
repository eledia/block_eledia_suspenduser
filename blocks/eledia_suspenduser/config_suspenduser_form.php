<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Configuration form.
 *
 * @package    block
 * @subpackage eledia_suspenduser
 * @author     Benjamin Wolf <support@eledia.de>
 * @copyright  2013 eLeDia GmbH
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

if (!defined('MOODLE_INTERNAL')) {
    die('Direct access to this script is forbidden.');    //  It must be included from a Moodle page.
}

require_once($CFG->libdir.'/formslib.php');

class config_suspenduser_form extends moodleform {

    public function definition() {
        global $CFG;

        $mform =& $this->_form;
        $mform->addElement('header', '', get_string('el_config_header', 'block_eledia_suspenduser'), 'config_suspenduser');

        if (!isset($CFG->eledia_suspenduserpath)) {
            set_config('eledia_suspenduserpath', '/temp/');
        }
        $mform->addElement('text', 'eledia_suspenduserpath',
                get_string('eledia_suspenduserpath', 'block_eledia_suspenduser'),
                'maxlength="30" size="30"');
        $mform->setDefault('eledia_suspenduserpath', $CFG->eledia_suspenduserpath);
        $mform->setType('eledia_suspenduserpath', PARAM_RAW);

        if (!isset($CFG->eledia_suspenduserfile)) {
            set_config('eledia_suspenduserfile', 'suspend_users.csv');
        }
        $mform->addElement('text', 'eledia_suspenduserfile',
                get_string('eledia_suspenduserfile', 'block_eledia_suspenduser'),
                'maxlength="30" size="30"');
        $mform->setDefault('eledia_suspenduserfile', $CFG->eledia_suspenduserfile);
        $mform->setType('eledia_suspenduserfile', PARAM_FILE);

        $mform->addElement('submit', 'submitbutton', get_string('save_changes', 'block_eledia_suspenduser'));
        $mform->addElement('cancel', 'cancelbutton', get_string('back', 'block_eledia_suspenduser'));
    }

    public function definition_after_data() {
        global $CFG;
        $mform =& $this->_form;

        if ($mform->isSubmitted()) {
            // Save config here.
            set_config('eledia_suspenduserpath', $mform->_submitValues['eledia_suspenduserpath']);
            set_config('eledia_suspenduserfile', $mform->_submitValues['eledia_suspenduserfile']);

            $mform->addElement('static', 'saved', '', get_string('saved', 'block_eledia_suspenduser'));
        }
    }
}
