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

namespace block_superframe\local;

/**
 * Class block_data
 *
 * @package    block_superframe
 * @copyright  2024 Victor Correia
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_data {
    public static function fetch_block_data() {
        global $DB;
        $sql = "SELECT b.id, cat.id AS catid, cat.name AS catname, ";
        $sql .= "b.blockname, c.shortname ";
        $sql .= "FROM {context} x ";
        $sql .= "JOIN {block_instances} b ON b.parentcontextid = x.id ";
        $sql .= "JOIN {course} c ON c.id = x.instanceid ";
        $sql .= "JOIN {course_categories} cat ON cat.id = c.category ";
        $sql .= "WHERE x.contextlevel <= :clevel ";
        $sql .= "ORDER BY b.blockname DESC";

        return $DB->get_records_sql($sql, ['clevel' => CONTEXT_BLOCK]);
    }
}
