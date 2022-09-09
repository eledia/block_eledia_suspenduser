<?php

// This program is free software; you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 3 of the License, or
// (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with this program.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Usercleanup Testcase.
 *
 * @package    block
 * @subpackage eledia_suspenduser
 * @author     Benjamin Wolf <support@eledia.de>
 * @copyright  2020 eLeDia GmbH
 * @category   test
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL
 */

defined('MOODLE_INTERNAL') || die();

class block_eledia_suspenduser_testcase extends advanced_testcase {
    public function test_generator() {
        global $DB, $CFG;
        require_once("$CFG->libdir/cronlib.php");

        $this->resetAfterTest(true);
        $generator = $this->getDataGenerator();

        $config = get_config('block_eledia_suspenduser');

        // Generate Testuser.
        $user1 = $generator->create_user(array('username' => 'test1', 'email' => 'a.test1@eledia.de'));// To suspend.
        $user2 = $generator->create_user(array('username' => 'test2', 'email' => 'a.test2@eledia.de'));// To stay.

        // Create test file.
        $userlist = 'a.test1@eledia.de'."\n".'a.test3@eledia.de';
        file_put_contents($CFG->dataroot."/temp/suspend_users.csv", $userlist);

        // Run cron.
        require_once("$CFG->dirroot/blocks/moodleblock.class.php");
        require_once("$CFG->dirroot/blocks/eledia_suspenduser/block_eledia_suspenduser.php");
        $block = new block_eledia_suspenduser();
        $block->cron();

        // Check outcome.
        $user1 =  $DB->get_record('user', array('id' => $user1->id));
        $user2 =  $DB->get_record('user', array('id' => $user2->id));
        $this->assertEquals(1, $user1->suspended, 'User a.test1@eledia.de should be suspended.');
        $this->assertEquals(0, $user2->suspended, 'User a.test2@eledia.de should not be suspended.');
    }
}
