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
 * Form for editing block_superframe instances
 *
 * @package    block_superframe
 * @copyright  2024 Victor Correia
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_superframe_edit_form extends block_edit_form {

    /**
     * Form fields specific to this type of block
     * Added by MDL Code Extention
     *
     * @param MoodleQuickForm $mform
     */
    protected function specific_definition($mform) {

        //Section Header title according to language file
        $mform->addElement('header', 'configheader',
            get_string('blocksettings', 'block'));

        // URL element - use admin settings for default.
        $config = get_config('block_superframe');
        // Adding text field with the name config_url and adding local string
        $mform->addElement('text', 'config_url',
            get_string('url', 'block_superframe'));

        // Adds default value of config_url as specified in blocks config settings
        $mform->setDefault('config_url', $config->url);

        // Checks that value of config_url is valid URL (Data validation)
        $mform->setType('config_url', PARAM_URL);

        // Add size element. Custom will be default setting in admin settings
        $sizes = [
            'custom' => get_string('custom', 'block_superframe'),
            'small' => get_string('small', 'block_superframe'),
            'medium' => get_string('medium', 'block_superframe'),
            'large' => get_string('large', 'block_superframe')
        ];

        // Add select element selecting size from sizes array
        $mform-> addElement('select', 'config_size',
            get_string('size', 'block_superframe'), $sizes);

        //set default size to custom
        $mform->setDefault('config_size','custom');
    }
}
