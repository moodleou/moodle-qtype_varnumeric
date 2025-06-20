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

use basic_testcase;
use qtype_varnumeric_question;

defined('MOODLE_INTERNAL') || die();
global $CFG;

require_once($CFG->dirroot . '/question/type/varnumeric/question.php');
require_once($CFG->dirroot . '/question/engine/tests/helpers.php');


/**
 * Unit tests for the varnumeric question definition class.
 *
 * @package   qtype_varnumeric
 * @copyright 2012 The Open University
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @covers    \qtype_varnumeric_question
 */
final class question_test extends basic_testcase {
    public function test_wrong_by_a_factor_of_ten(): void {
        $this->assertTrue(
            qtype_varnumeric_question::wrong_by_a_factor_of_ten('1.23e4', 1.23e5, '', 1));
        $this->assertFalse(
            qtype_varnumeric_question::wrong_by_a_factor_of_ten('1.23e4', 1.23e6, '', 1));
        $this->assertTrue(
            qtype_varnumeric_question::wrong_by_a_factor_of_ten('1.231', 12.3, 0.01, 1));
        $this->assertFalse(
            qtype_varnumeric_question::wrong_by_a_factor_of_ten('1.232', 12.3, 0.01, 1));
        $this->assertTrue(
            qtype_varnumeric_question::wrong_by_a_factor_of_ten('151000', 150, 1, 3));
        $this->assertFalse(
            qtype_varnumeric_question::wrong_by_a_factor_of_ten('152000', 150, 1, 3));
    }

    public function test_has_number_of_sig_figs(): void {
        $this->assertTrue(
            qtype_varnumeric_question::has_number_of_sig_figs('1.23e4', 3));
        $this->assertTrue(
            qtype_varnumeric_question::has_number_of_sig_figs('1.23456e4', 6));
         $this->assertFalse(
            qtype_varnumeric_question::has_number_of_sig_figs('1.2345e4', 6));
        $this->assertTrue(
            qtype_varnumeric_question::has_number_of_sig_figs('1.231', 4));
        $this->assertFalse(
            qtype_varnumeric_question::has_number_of_sig_figs('1.231', 3));
        $this->assertTrue(
            qtype_varnumeric_question::has_number_of_sig_figs('1232', 4));
        $this->assertTrue(
            qtype_varnumeric_question::has_number_of_sig_figs('1230', 3));
        $this->assertFalse(
            qtype_varnumeric_question::has_number_of_sig_figs('1232', 3));
        $this->assertTrue(
            qtype_varnumeric_question::has_number_of_sig_figs('151000', 3));
        $this->assertFalse(
            qtype_varnumeric_question::has_number_of_sig_figs('152000', 2));
    }

    public function test_has_too_many_sig_figs(): void {
        $this->assertTrue(
            qtype_varnumeric_question::has_too_many_sig_figs('1.23456', 1.23456, 2));
        $this->assertTrue(
            qtype_varnumeric_question::has_too_many_sig_figs('1.2346', 1.23456, 2));
        $this->assertFalse(
            qtype_varnumeric_question::has_too_many_sig_figs('1.2345', 1.23456, 2));
        $this->assertTrue(
            qtype_varnumeric_question::has_too_many_sig_figs('1.23', 1.23456, 2));
        $this->assertFalse(
            qtype_varnumeric_question::has_too_many_sig_figs('1.24', 1.23456, 2));
        $this->assertFalse(
            qtype_varnumeric_question::has_too_many_sig_figs('1.23457', 1.23456, 2));
        $this->assertTrue(
            qtype_varnumeric_question::has_too_many_sig_figs('1.23456e4', 1.23456e4, 2));
        $this->assertFalse(
            qtype_varnumeric_question::has_too_many_sig_figs('1.23456e4', 1.33456e4, 2));
        $this->assertTrue(
            qtype_varnumeric_question::has_too_many_sig_figs('7.89e-4', 7.890123e-4, 2));
        $this->assertFalse(
            qtype_varnumeric_question::has_too_many_sig_figs('-1.23456e-12', -1.2346e-12, 4));
    }

    public function test_rounding_incorrect(): void {
        $this->assertTrue(
            qtype_varnumeric_question::rounding_incorrect('1.234', 1.2345, 4));
        $this->assertTrue(
            qtype_varnumeric_question::rounding_incorrect('1.2345', 1.23456, 5));
        // This routine is not meant to catch incorrect rounding up.
        $this->assertFalse(
            qtype_varnumeric_question::rounding_incorrect('1.3', 1.23, 2));
        $this->assertFalse(
            qtype_varnumeric_question::rounding_incorrect('1.23', 1.23456, 2));
    }
}
