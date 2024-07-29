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
 * TODO describe file view
 *
 * @package    block_superframe
 * @copyright  2024 Victor Correia
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

 require('../../config.php');
 $blockid = required_param('blockid', PARAM_INT);
 $courseid = required_param('courseid', PARAM_INT);
 $def_config = get_config('block_superframe');


 if ($courseid == $SITE->id) {
    $context = context_system::instance();
    $PAGE->set_context($context);
 } else {
    $course = $DB->get_record('course',['id' => $courseid],'*',MUST_EXIST);
    $PAGE->set_course($course);
    $context = $PAGE->context;
 }

 $PAGE->set_url('/blocks/superframe/view.php',
    [
        'blockid' => $blockid,
        'courseid' => $courseid,
        'size' => $size
    ]);
 $PAGE->set_heading($SITE->fullname);
 $PAGE->set_pagelayout($def_config->pagelayout);
 $PAGE->set_title(get_string('pluginname', 'block_superframe'));
 $PAGE->navbar->add(get_string('pluginname', 'block_superframe'));
 require_login();

// check the users permissions to see the view page.
require_capability('block/superframe:seeviewpage', $context);

 /* Get the instance configuration data from the database.
   It's stored as a base 64 encoded serialized string. */
$configdata = $DB->get_field('block_instances', 'configdata', ['id' => $blockid]);

// If an entry exists, convert to an object.
if ($configdata) {
    $config = unserialize(base64_decode($configdata));
} else {
    // No instance data, use admin settings.
    // However, that only specifies height and width, not size.
   $config = $def_config;
   $config->size = 'custom';
}

// URL - comes either from instance or admin.
$url = $config->url;

// Let's set up the iframe attributes.
switch ($config->size) {
    case 'custom':
        $width = $def_config->width;
        $height = $def_config->height;
        break;
    case 'small' :
        $width = 360;
        $height = 240;
        break;
    case 'medium' :
        $width = 600;
        $height = 400;
        break;
    case 'large' :
        $width = 1024;
        $height = 720;
        break;
}

$renderer = $PAGE->get_renderer('block_superframe');
$renderer->display_view_page($url, $width, $height);