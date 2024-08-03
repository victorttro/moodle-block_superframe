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
 * TODO describe file renderer
 *
 * @package    block_superframe
 * @copyright  2024 Victor Correia
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

 class block_superframe_renderer extends plugin_renderer_base {

    function display_view_page($url, $width, $height) {
           global $USER;

           $data = new stdClass();

           // Page heading and iframe data.
           $data->heading = get_string('pluginname', 'block_superframe');
           $data->url = $url;
           $data->height = $height;
           $data->width = $width;

           // Add the user data.
           $data->fullname = fullname($USER);

           // Start output to browser.
           echo $this->output->header();

           // Render the data in a Mustache template.
           echo $this->render_from_template('block_superframe/frame', $data);

           // Finish the page.
           echo $this->output->footer();
       }

    function fetch_block_content($blockid, $courseid) {
        global $USER;

        $data = new stdClass();

        $data->welcome = get_string('welcomeuser','block_superframe',$USER);

        $context = \context_block::instance($blockid);

        //Check capability
        if (has_capability('block/superframe:seeviewpagelink', $context)) {
            $data->url = new moodle_url('/blocks/superframe/view.php', ['blockid' => $blockid,'courseid' => $courseid]);
            $data->text = get_string('viewlink', 'block_superframe');
        }

        // Add a link to the popup page.
        $data->popurl = new moodle_url('/blocks/superframe/block_data.php');
        $data->poptext = get_string('poptext', 'block_superframe');

        //Add url to tablemanager
        $data->tableurl = new moodle_url('/blocks/superframe/tablemanager.php',['courseid' => $courseid]);
        $data->tabletext = get_string('tabletext', 'block_superframe');

         // List of course students.
         $data->students = [];
         $users = self::get_course_users($courseid);
         foreach ($users as $user) {
             $data->students[] = ''.$user->lastname.', '.$user->firstname;
         }

        // Render data in a Mustache template
        return $this->render_from_template('block_superframe/block', $data);

        }

         /**
         * Function to display a table of records
         * @param array the records to display.
         * @return none.
         */
        public function display_block_table($records) {
            // Prepare the data for the template.
            $table = new stdClass();

            // Table headers.
            $table->tableheaders = [
                get_string('blockid', 'block_superframe'),
                get_string('blockname', 'block_superframe'),
                get_string('course', 'block_superframe'),
                get_string('catname', 'block_superframe'),
            ];

            // Build the data rows.
            foreach ($records as $record) {
                $data = array();
                $data['id'] = $record->id;
                $data['blockname'] = $record->blockname;
                $data['shortname'] = $record->shortname;
                $data['catname'] = $record->catname;
                $table->tabledata[] = $data;
            }

            // Start output to browser.
            echo $this->output->header();

            // Call our template to render the data.
            echo $this->render_from_template('block_superframe/block_data', $table);

            // Finish the page.
            echo $this->output->footer();
        }

    private static function get_course_users($courseid) {
        global $DB;

        $sql = "SELECT u.id, u.firstname, u.lastname ";
        $sql .= "FROM {course} c ";
        $sql .= "JOIN {context} x ON c.id = x.instanceid ";
        $sql .= "JOIN {role_assignments} r ON r.contextid = x.id ";
        $sql .= "JOIN {user} u ON u.id = r.userid ";
        $sql .= "WHERE c.id = :courseid ";
        $sql .= "AND r.roleid = :roleid";

        // In real world query should check users are not deleted/suspended.
        $records = $DB->get_records_sql($sql, ['courseid' => $courseid, 'roleid' => 5]);

        return $records;
    }
   }

