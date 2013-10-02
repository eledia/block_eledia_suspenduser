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
 * Settings page.
 *
 * @package    block
 * @subpackage eledia_suspenduser
 * @author     Benjamin Wolf <support@eledia.de>
 * @copyright  2013 eLeDia GmbH
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {

    if (!isset($CFG->eledia_suspenduserpath)) {
        set_config('eledia_suspenduserpath', '/temp/');
    }
    $settings->add(new admin_setting_configtext('eledia_suspenduserpath',
            get_string('eledia_suspenduserpath', 'block_eledia_suspenduser'),
            get_string('eledia_suspenduserpath', 'block_eledia_suspenduser'),
            '/temp/',
            PARAM_URL));

    if (!isset($CFG->eledia_suspenduserfile)) {
        set_config('eledia_suspenduserfile', 'suspend_users.csv');
    }
    $settings->add(new admin_setting_configtext('eledia_suspenduserfile',
            get_string('eledia_suspenduserfile', 'block_eledia_suspenduser'),
            get_string('eledia_suspenduserfile', 'block_eledia_suspenduser'),
            'suspend_users.csv',
            PARAM_FILE));

}