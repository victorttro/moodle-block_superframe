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
 * TODO describe file settings
 *
 * @package    blocks_superframe
 * @copyright  2024 Victor Correia
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();


if ($ADMIN->fulltree) {

    //default values
    $defaulturl = 'https://quizlet.com/132695231/scatter/embed';
    $defaultheight = '400';
    $defaultwidth = '600';

    //heading
    $settings->add(new admin_setting_heading('sampleheader',
             get_string('headerconfig', 'block_superframe'),
             get_string('headerconfigdesc', 'block_superframe')));

    // The url to be displayed.
    $settings->add(new admin_setting_configtext('block_superframe/url',
            get_string('url', 'block_superframe'),
            get_string('url_details', 'block_superframe'),
            $defaulturl, PARAM_RAW));

    // Height
    $settings->add(new admin_setting_configtext('block_superframe/height',
            get_string('height', 'block_superframe'),
            get_string('height_desc', 'block_superframe'),
            $defaultheight, PARAM_INT));

    //Width
    $settings->add(new admin_setting_configtext('block_superframe/width',
        get_string('width', 'block_superframe'),
        get_string('width_desc', 'block_superframe'),
        $defaultwidth, PARAM_INT));

    // Page layout
    $settings->add(new admin_setting_configselect('blocks/blocks_superframe',
            get_string('pagelayout','blocks_superframe'),
            get_string('pagelayout_desc','blocks_superframe')));
}



