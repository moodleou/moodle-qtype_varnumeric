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

global $CFG;
require_once($CFG->dirroot . '/question/engine/tests/helpers.php');

/**
 * Test helper class for the varnumeric question type.
 *
 * @copyright  2013 The Open University
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class qtype_varnumeric_test_helper extends question_test_helper {
    public function get_test_questions() {
        return ['no_accepted_error', 'with_variables'];
    }

    /**
     * @return qtype_varnumeric_question
     */
    public function get_varnumeric_question_form_data_no_accepted_error() {
        $form = new stdClass();
        $form->name = 'Pi to two d.p.';
        $form->questiontext = [];
        $form->questiontext['format'] = '1';
        $form->questiontext['text'] = 'What is pi to two d.p.?';
        $form->defaultmark = 1;
        $form->generalfeedback = [];
        $form->generalfeedback['format'] = '1';
        $form->generalfeedback['text'] = 'Generalfeedback: 3.14 is the right answer.';
        $form->randomseed = '';
        $form->novars = 5;
        $form->vartype = ['0' => 0, '1' => 0, '2' => 0, '3' => 0, '4' => 0];
        $form->varname = ['0' => '', '1' => '', '2' => '', '3' => '', '4' => ''];
        $form->variant_last = ['0' => '', '1' => '', '2' => '', '3' => '', '4' => ''];
        $form->requirescinotation = 0;
        $form->noanswers = 6;
        $form->answer = ['0' => '4.3', '1' => '', '2' => '', '3' => '', '4' => '', '5' => ''];
        $form->sigfigs = ['0' => 2, '1' => 0, '2' => 0, '3' => 0, '4' => 0, '5' => 0];
        $form->error = ['0' => 0, '1' => 0, '2' => 0, '3' => 0, '4' => 0, '5' => 0];
        $form->checknumerical = ['0' => 0, '1' => 0, '2' => 0, '3' => 0, '4' => 0, '5' => 0];
        $form->checkscinotation = ['0' => 0, '1' => 0, '2' => 0, '3' => 0, '4' => 0, '5' => 0];
        $form->checkpowerof10 = ['0' => 0, '1' => 0, '2' => 0, '3' => 0, '4' => 0, '5' => 0];
        $form->checkrounding = ['0' => 0, '1' => 0, '2' => 0, '3' => 0, '4' => 0, '5' => 0];
        $form->checkscinotationformat = ['0' => 0, '1' => 0, '2' => 0, '3' => 0, '4' => 0, '5' => 0];
        $form->syserrorpenalty = ['0' => 0.0, '1' => 0.0, '2' => 0.0, '3' => 0.0, '4' => 0.0, '5' => 0.0];
        $form->fraction = ['0' => 1.0, '1' => 0.0, '2' => 0.0, '3' => 0.0, '4' => 0.0, '5' => 0.0];
        $form->feedback = [
                '0' => ['format' => FORMAT_HTML, 'text' => 'Very good.'],
                '1' => ['format' => FORMAT_HTML, 'text' => ''],
                '2' => ['format' => FORMAT_HTML, 'text' => ''],
                '3' => ['format' => FORMAT_HTML, 'text' => ''],
                '4' => ['format' => FORMAT_HTML, 'text' => ''],
                '5' => ['format' => FORMAT_HTML, 'text' => ''],
        ];
        return $form;
    }
    /**
     * @return qtype_varnumeric_question
     */
    public function make_varnumeric_question_with_variables() {
        $vn = $this->make_varnumeric_question_no_accepted_error();

        $vn->questiontext = '<p>What is [[a]] + [[b]]?</p>';
        $vn->generalfeedback = '<p>General feedback 1e9.</p>';
        $vn->requirescinotation = 1;
        $vn->answers[1]->answer = 'a + b';
        $vn->answers[1]->sigfigs = 1;
        $vn->answers[1]->checknumerical = 1;
        $vn->answers[1]->checkscinotation = 1;

        $vn->calculator->add_variable(0, 'a');
        $vn->calculator->add_variable(1, 'b');
        $vn->calculator->add_defined_variant(0, 0, 2);
        $vn->calculator->add_defined_variant(1, 0, 3);
        $vn->calculator->evaluate_variant(0);

        return$vn;
    }

    public function get_varnumeric_question_form_data_with_variables() {
        $form = new stdClass();
        $form->name = 'Pi to two d.p.';
        $form->questiontext = ['text' => '<p>What is [[a]] + [[b]]?</p>', 'format' => FORMAT_HTML];
        $form->defaultmark = 1;
        $form->generalfeedback = ['text' => '<p>General feedback 1e9.</p>', 'format' => FORMAT_HTML];
        $form->requirescinotation = 0;
        $form->randomseed = '';
        $form->vartype = ['0' => 1, '1' => 1, '2' => 1]; // Set to 'Predefined variable'.
        $form->novars = 3;
        $form->noofvariants = 3;
        $form->varname[0] = 'a';
        $form->variant0[0] = 2;
        $form->variant1[0] = 3;
        $form->variant2[0] = 5;
        $form->varname[1] = 'b';
        $form->variant0[1] = 8;
        $form->variant1[1] = 5;
        $form->variant2[1] = 3;
        $form->varname[2] = 'c = a + b';
        $form->variant_last = ['0' => '', '1' => ''];
        $form->requirescinotation = 0;
        $form->answer = ['0' => 'c', '1' => '*'];
        $form->sigfigs = ['0' => 0, '1' => 0];
        $form->error = ['0' => '', '1' => ''];
        $form->checknumerical = ['0' => 0, '1' => 0, '2' => 0];
        $form->checkscinotation = ['0' => 0, '1' => 0, '2' => 0];
        $form->checkpowerof10 = ['0' => 0, '1' => 0, '2' => 0];
        $form->checkrounding = ['0' => 0, '1' => 0, '2' => 0];
        $form->checkscinotationformat = ['0' => 0, '1' => 0, '2' => 0, '3' => 0, '4' => 0, '5' => 0];
        $form->syserrorpenalty = ['0' => 0.0, '1' => 0.0, '2' => 0.0];
        $form->fraction = ['0' => '1.0', '1' => '0.0', '2' => '0.0'];
        $form->feedback = [
                '0' => ['format' => FORMAT_HTML, 'text' => 'Well done!'],
                '1' => ['format' => FORMAT_HTML, 'text' => 'Sorry, no.'],
        ];
        $form->penalty = '0.3333333';
        $form->hint = [
                ['text' => 'Please try again.', 'format' => FORMAT_HTML],
                ['text' => 'You may use a calculator if necessary.', 'format' => FORMAT_HTML],
        ];

        return $form;
    }

    public function make_varnumeric_question_no_accepted_error() {
        question_bank::load_question_definition_classes('varnumeric');
        $vn = new qtype_varnumeric_question();
        test_question_maker::initialise_a_question($vn);
        $vn->name = 'test question 1';
        $vn->questiontext = '<p>The correct answer is -4.2.</p>';
        $vn->generalfeedback = '<p>General feedback -4.2.</p>';
        $vn->penalty = 0.3333333;
        $vn->requirescinotation = false;
        $vn->usesupeditor = false;
        $vn->qtype = question_bank::get_qtype('varnumeric');
        $vn->answers = [
                1 => new qtype_varnumericset_answer('1', // Id.
                '-4.2',  // Answer.
                '1',     // Fraction.
                '<p>Your answer is correct.</p>', // Feedback.
                FORMAT_HTML,  // Feedbackformat.
                '0',     // Sigfigs.
                '',      // Error.
                '0.1',   // Syserrorpenalty.
                '0',     // Checknumerical.
                '0',     // Checkscinotation.
                '0',     // Checkpowerof10.
                '0',     // Checkrounding.
                '0'),    // Checkscinotationformat.
                2 => new qtype_varnumericset_answer('2', // Id.
                        '*',     // Answer.
                        '0',     // Fraction.
                        '<p>Your answer is incorrect.</p>', // Feedback.
                        FORMAT_HTML,  // Feedbackformat.
                        '0',     // Sigfigs.
                        '',      // Error.
                        '0.1000000', // Syserrorpenalty.
                        '0',     // Checknumerical.
                        '0',     // Checkscinotation.
                        '0',     // Checkpowerof10.
                        '0',     // Checkrounding.
                        '0'),    // Checkscinotationformat.
            ];
        $calculatorname = $vn->qtype->calculator_name();
        $vn->calculator = new $calculatorname();
        $vn->calculator->evaluate_variant(0);
        return$vn;
    }

    /**
     * Checks if given plugin is installed.
     *
     * @param string $plugin frankenstyle plugin name, e.g. 'mod_qbank'.
     * @return bool
     */
    public static function plugin_is_installed(string $plugin): bool {
        $path = core_component::get_component_directory($plugin);
        if (!is_readable($path . '/version.php')) {
            return false;
        }
        return true;
    }

    /**
     * Retrieve the context object.
     * @param \context $context the current context.
     *
     * @return question_edit_contexts The context object.
     */
    public static function question_edit_contexts(\context $context): object {
        if (class_exists('\core_question\local\bank\question_edit_contexts')) {
            $contexts = new \core_question\local\bank\question_edit_contexts($context);
        } else {
            $contexts = new \question_edit_contexts($context);
        }
        return $contexts;
    }
}
