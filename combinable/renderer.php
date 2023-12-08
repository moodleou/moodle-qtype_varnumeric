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
 * Combined question embedded sub question renderer class.
 *
 * @package    qtype_varnumeric
 * @copyright  2013 The Open University
 * @author     Jamie Pratt <me@jamiep.org>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class qtype_varnumeric_embedded_renderer extends qtype_combined_text_entry_renderer_base {

    public function subquestion(question_attempt $qa, question_display_options $options,
            qtype_combined_combinable_base $subq, $placeno) {
        $stateclass = '';
        if ($options->feedback) {
            $answer = reset($subq->question->answers);
            [, $state] = $subq->question->grade_response(['answer' => $qa->get_last_qt_var($subq->step_data_name('answer'))]);

            if ($state === question_state::$gradedright) {
                $stateclass = 'correct ';
                $feedback = $subq->question->format_text($answer->feedback, $answer->feedbackformat,
                    $qa, 'question', 'answerfeedback', $answer->id);
            } else {
                $stateclass = 'incorrect ';
                $feedback = $subq->question->format_generalfeedback($qa);
            }
            // We should set empty so it should not display in the feedback section.
            $subq->question->generalfeedback = '';
        }

        $centerclass = 'd-flex align-items-center ';
        $html = html_writer::start_div($stateclass . $centerclass . 'combined-varnumeric w-100 mb-1');
        $html .= html_writer::div(parent::subquestion($qa, $options, $subq, $placeno), $centerclass);

        if ($stateclass) {
            $html .= html_writer::start_div('feedback');
            $html .= html_writer::div($subq->question->make_html_inline($feedback), 'subqspecificfeedback');
            $html .= html_writer::end_div();
        }

        $html .= html_writer::end_div();
        return $html;
    }
}
