This plugin suspends user accounts based on a csv file with email adresses.

Installation:
To install the plugin just copy the folder "eledia_suspenduser" into moodle/blocks/.

Afterwards you have to go to http://your-moodle/admin (Site administration -> Notifications) to trigger the installation process.

Usage:
Configurate the block with the configuration page it links to. Set the path an filename for the input file.
It must be within the moodledata. The path should be given relative to the moodledata.

The plugin will run once a day with the moodle cron, reading the configured file and sets all users with the mail given in the file as suspended.

copyright  2013 eLeDia GmbH http://eledia.de
license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
You can receive a copy of the GNU General Public License at <http:www.gnu.org/licenses/>.
