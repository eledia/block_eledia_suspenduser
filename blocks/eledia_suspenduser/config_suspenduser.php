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
 * Configuration page.
 *
 * @package    block
 * @subpackage eledia_suspenduser
 * @author     Benjamin Wolf <support@eledia.de>
 * @copyright  2020 eLeDia GmbH
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');
require_once('config_suspenduser_form.php');

// Check for valid admin user - no guest autologin.
require_login(0, false);
$PAGE->set_url('/blocks/eledia_suspenduser/config_suspenduser.php');
$context = CONTEXT_SYSTEM::instance();
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');

require_capability('moodle/site:config', $context);

$mform = new config_suspenduser_form();

if ($mform->is_cancelled()) {
    redirect($CFG->httpswwwroot);
}

$header = get_string('el_header', 'block_eledia_suspenduser');
$PAGE->set_heading($header);

echo $OUTPUT->header();
$mform->display();
echo $OUTPUT->footer();
