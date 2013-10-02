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
 * Block base class.
 *
 * @package    block
 * @subpackage eledia_suspenduser
 * @author     Benjamin Wolf <support@eledia.de>
 * @copyright  2013 eLeDia GmbH
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class block_eledia_suspenduser extends block_base {

    public function init() {
        $this->title   = get_string('title', 'block_eledia_suspenduser');
        $this->version = 2012051601; // Format yyyymmddvv.
        $this->cron    = 1;
    }

    public function applicable_formats() {
        return array('site' => true);
    }

    public function get_content() {
        global $USER, $CFG, $COURSE;
        if ($this->content !== null) {
            return $this->content;
        }

        $this->content = new object();
        $this->content->text = '';
        $this->content->footer = '';

        if (has_capability('moodle/site:config', get_context_instance(CONTEXT_SYSTEM))) {

            $this->content->text .= '<ul>';
            $this->content->text .= '<li>';
            $this->content->text .= '<a href="'.$CFG->wwwroot.'/blocks/eledia_suspenduser/config_suspenduser.php" >';
            $this->content->text .= get_string('el_header', 'block_eledia_suspenduser');
            $this->content->text .= '</a>';
            $this->content->text .= '</li>';
            $this->content->text .= '</ul>';
        }
        return $this->content;
    }

    public function has_config() {
        return true;
    }

    public function cron() {

        global $CFG;
        error_reporting(E_ALL);

        require_once("$CFG->dirroot/local/eledialib/lib.php");
        $eledia = new eledia_lib();

        // Get filepath & name.
        if (!isset($CFG->eledia_suspenduserpath)) {
            set_config('eledia_suspenduserpath', '/temp/');
        }
        $path = $CFG->eledia_suspenduserpath;

        if (!isset($CFG->eledia_suspenduserfile)) {
            set_config('eledia_suspenduserfile', 'suspend_users.csv');
        }
        $name = $CFG->eledia_suspenduserfile;

        // Read file.
        $user_mails = $eledia->get_csv_content_as_array($CFG->dataroot.$path.$name, ';');

        // Get user and suspend user.
        if ($user_mails) {
            $this->suspend_user_in_list($user_mails);
        }
    }

    public function suspend_user_in_list(array $users_mails) {
        global $CFG, $DB;
        foreach ($users_mails as $user_mail) {
            // Get user.
            if (!$u = $DB->get_record('user', array('email' => $user_mail[0],
                'deleted' => 0,
                'mnethostid' => $CFG->mnet_localhost_id))) {
                continue;
            }
            // Suspend user.
            $DB->set_field('user', 'suspended', '1', array('id' => $u->id));
        }
    }
}
