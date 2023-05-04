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

namespace qtype_varnumeric;

/**
 * Unit tests for the varnumeric question edit form.
 *
 * @package qtype_varnumeric
 * @copyright 2023 The Open University
 * @license  https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();
global $CFG;

require_once($CFG->dirroot . '/question/type/varnumeric/question.php');
require_once($CFG->dirroot . '/question/type/varnumericset/tests/form_test.php');


/**
 * Unit tests for the qtype_varnumeric question edit form.
 *
 * @copyright 2023 The Open University
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @group qtype_varnumeric
 * @covers qtype_varnumeric_edit_form
 */
class form_test extends \qtype_varnumericset\form_test {

    /**
     * Test editing form validation with wrong variables format.
     *
     * @dataProvider form_validation_testcases
     * @param array $fromform Submitted responses.
     * @param array $expectederrors Expected result.
     */
    public function test_form_validation(array $fromform, array $expectederrors): void {
        $mform = $this->prepare_test_data('varnumeric');

        $defaults = [
                'category' => '6,21',
                'answer' => ['y', 'y'],
                'fraction' => ['1.0', '0.0'],
                'varname' => ['x', 'y = x * 299792458 * 86400 * 365.2422'],
                'vartype' => ['1.0', '0.0'],
                'noofvariants' => 5,
                'variant0' => ['1.0'],
                'variant1' => ['2.0'],
                'error' => ['0.05*y', '0.05*y'],
        ];
        $fromform = array_merge($defaults, $fromform);
        $this->assertEquals($expectederrors, $mform->validation($fromform, []));
    }

    /**
     * Data provider for {@see form_validation_testcases()}.
     *
     * @return array List of data sets (test cases).
     */
    public function form_validation_testcases(): array {
        return [
            '1 pre-defined variable' => [
                [
                    'varname' => [
                        'x = 4',
                        'y = 2',
                    ],
                    'vartype' => ['0.0', '0.0'],
                    'variant0' => [],
                    'variant1' => [],
                ],
                []
            ],
        ];
    }
}
