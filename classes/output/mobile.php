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

namespace qtype_varnumeric\output;

/**
 * Mobile output class for question type varnumeric.
 *
 * @package qtype_varnumeric
 * @copyright 2019 The Open University
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class mobile {

    /**
     * Returns the mobile view for the varnumeric question type.
     *
     * @return array An array containing templates and JavaScript for the mobile view.
     */
    public static function varnum_view(): array {
        global $CFG;
        // General notes:
        // If you have worked on mobile activities, there is no cmid or courseid in $args here.
        // This is not equivalent to mod/quiz/attempt.php?attempt=57&cmid=147, rather
        // this is just a section of that page, with all the access checking already done for us.
        // The full file path is required even though file_get_contents should work with relative paths.
        return [
            'templates' => [
                [
                    'id' => 'main',
                    'html' => file_get_contents($CFG->dirroot . '/question/type/varnumeric/mobile/varnum.html'),
                ],
            ],
            'javascript' => file_get_contents($CFG->dirroot . '/question/type/varnumeric/mobile/varnum.js'),
        ];
    }
}
