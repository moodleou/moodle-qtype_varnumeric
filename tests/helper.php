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
 * Test helpers for the varnumeric question type.
 *
 * @package    qtype
 * @subpackage varnumeric
 * @copyright  2012 The Open University
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die();


/**
 * Test helper class for the varnumeric question type.
 *
 * @copyright  2013 The Open University
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class qtype_varnumeric_test_helper extends question_test_helper {
    public function get_test_questions() {
        return array('no_accepted_error');
    }

    /**
     * @return qtype_varnumeric_question
     */
    public function get_varnumeric_question_form_data_no_accepted_error() {
        $form = new stdClass();
        $form->name = 'Pi to two d.p.';
        $form->questiontext = array();
        $form->questiontext['format'] = '1';
        $form->questiontext['text'] = 'What is pi to two d.p.?';

        $form->defaultmark = 1;
        $form->generalfeedback = array();
        $form->generalfeedback['format'] = '1';
        $form->generalfeedback['text'] = 'Generalfeedback: 3.14 is the right answer.';
        $form->randomseed = '';
        $form->novars = 5;
        $form->vartype = array(
                '0' => 0,
                '1' => 0,
                '2' => 0,
                '3' => 0,
                '4' => 0);

        $form->varname = array(
                '0' => '',
                '1' => '',
                '2' => '',
                '3' => '',
                '4' => '');

        $form->variant_last = array(
                '0' => '',
                '1' => '',
                '2' => '',
                '3' => '',
                '4' => '');

        $form->requirescinotation = 0;

        $form->noanswers = 6;
        $form->answer = array();
        $form->answer[0] = '4.3';
        $form->answer[1] = '';
        $form->answer[2] = '';
        $form->answer[3] = '';
        $form->answer[4] = '';
        $form->answer[5] = '*';

        $form->sigfigs = array();
        $form->sigfigs[0] = 2;
        $form->sigfigs[1] = 0;
        $form->sigfigs[2] = 0;
        $form->sigfigs[3] = 0;
        $form->sigfigs[4] = 0;
        $form->sigfigs[5] = 0;

        $form->error = array();
        $form->error[0] = 0;
        $form->error[1] = 0;
        $form->error[2] = 0;
        $form->error[3] = 0;
        $form->error[4] = 0;
        $form->error[5] = 0;

        $form->checknumerical = array();
        $form->checknumerical[0] = 0;
        $form->checknumerical[1] = 0;
        $form->checknumerical[2] = 0;
        $form->checknumerical[3] = 0;
        $form->checknumerical[4] = 0;
        $form->checknumerical[5] = 0;


        $form->checkscinotation = array();
        $form->checkscinotation[0] = 0;
        $form->checkscinotation[1] = 0;
        $form->checkscinotation[2] = 0;
        $form->checkscinotation[3] = 0;
        $form->checkscinotation[4] = 0;
        $form->checkscinotation[5] = 0;


        $form->checkpowerof10 = array();
        $form->checkpowerof10[0] = 0;
        $form->checkpowerof10[1] = 0;
        $form->checkpowerof10[2] = 0;
        $form->checkpowerof10[3] = 0;
        $form->checkpowerof10[4] = 0;
        $form->checkpowerof10[5] = 0;


        $form->checkrounding = array();
        $form->checkrounding[0] = 0;
        $form->checkrounding[1] = 0;
        $form->checkrounding[2] = 0;
        $form->checkrounding[3] = 0;
        $form->checkrounding[4] = 0;
        $form->checkrounding[5] = 0;


        $form->syserrorpenalty = array();
        $form->syserrorpenalty[0] = 0.0;
        $form->syserrorpenalty[1] = 0.0;
        $form->syserrorpenalty[2] = 0.0;
        $form->syserrorpenalty[3] = 0.0;
        $form->syserrorpenalty[4] = 0.0;
        $form->syserrorpenalty[5] = 0.0;

        $form->fraction = array();
        $form->fraction[0] = '1.0';
        $form->fraction[1] = '0.0';
        $form->fraction[2] = '0.0';
        $form->fraction[3] = '0.0';
        $form->fraction[4] = '0.0';
        $form->fraction[5] = '0.0';

        $form->feedback = array();
        $form->feedback[0] = array();
        $form->feedback[0]['format'] = '1';
        $form->feedback[0]['text'] = 'Very good.';

        $form->feedback[1] = array();
        $form->feedback[1]['format'] = '1';
        $form->feedback[1]['text'] = '';

        $form->feedback[2] = array();
        $form->feedback[2]['format'] = '1';
        $form->feedback[2]['text'] = '';

        $form->feedback[3] = array();
        $form->feedback[3]['format'] = '1';
        $form->feedback[3]['text'] = '';

        $form->feedback[4] = array();
        $form->feedback[4]['format'] = '1';
        $form->feedback[4]['text'] = '';

        $form->feedback[5] = array();
        $form->feedback[5]['format'] = '1';
        $form->feedback[5]['text'] = '';

        return $form;
    }
}
