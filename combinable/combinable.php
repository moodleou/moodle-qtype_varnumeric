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
 * Defines the hooks necessary to make the numerical question type combinable
 *
 * @package    qtype_varnumeric
 * @copyright  2013 The Open University
 * @author     Jamie Pratt <me@jamiep.org>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot.'/question/type/varnumericset/number_interpreter.php');

/**
 * Class qtype_combined_combinable_type_varnumeric. Collects methods for the varnumeric wiget.
 */
class qtype_combined_combinable_type_varnumeric extends qtype_combined_combinable_type_base {

    /**
     * @var null|string string used to identify this question type in the combined question type plugin.
     */
    protected $identifier = 'numeric';

    #[\Override]
    protected function extra_question_properties() {
        return ['randomseed' => '', 'vartype' => [0], 'varname' => [''], 'variant' => [''], 'novars' => 1];
    }

    #[\Override]
    protected function extra_answer_properties() {
        return ['sigfigs' => 0, 'fraction' => '1.0', 'checknumerical' => 0, 'checkscinotation' => 0,
            'checkpowerof10' => 0, 'checkrounding' => 0, 'syserrorpenalty' => '0.0', 'checkscinotationformat' => 0];
    }

    #[\Override]
    public function subq_form_fragment_question_option_fields() {
        return ['requirescinotation' => null];
    }

    #[\Override]
    protected function third_param_for_default_question_text() {
        return '__10__';
    }

    #[\Override]
    public function render_feedback(question_attempt $qa, qtype_combined_combinable_base $subq): string {
        [, $state] = $subq->question->grade_response(['answer' => $qa->get_last_qt_var($subq->step_data_name('answer'))]);
        if ($state === question_state::$gradedright) {
            $answer = reset($subq->question->answers);
            $feedback = $subq->question->format_text($answer->feedback, $answer->feedbackformat,
                $qa, 'question', 'answerfeedback', $answer->id);
        } else {
            $feedback = $subq->question->format_generalfeedback($qa);
        }
        return $feedback;
    }

}

/**
 * Class qtype_combined_combinable_varnumeric.
 */
class qtype_combined_combinable_varnumeric extends qtype_combined_combinable_text_entry {

    /**
     * Adds a fragment of form elements specific to this question type to the combined form.
     *
     * This method creates and adds answer and error input fields, a scientific notation selector,
     * and a feedback editor to the provided MoodleQuickForm instance. It also sets the appropriate
     * types for the form fields.
     *
     * @param moodleform $combinedform The combined form object to which this fragment is being added.
     * @param MoodleQuickForm $mform The MoodleQuickForm instance to add elements to.
     * @param bool $repeatenabled Indicates whether repeating elements are enabled.
     */
    public function add_form_fragment(moodleform $combinedform, MoodleQuickForm $mform, $repeatenabled) {

        $answergroupels = [];
        $answergroupels[] = $mform->createElement('text', $this->form_field_name('answer[0]'),
                                                  get_string('answer', 'question'), ['size' => 25]);
        $answergroupels[] = $mform->createElement('text',
                                                 $this->form_field_name('error[0]'),
                                                 get_string('error', 'qtype_varnumericset'),
                                                 ['size' => 16]);
        $mform->setType($this->form_field_name('answer'), PARAM_RAW);
        $mform->setType($this->form_field_name('error'), PARAM_RAW);
        $mform->addElement('group',
                           $this->form_field_name('answergroup'),
                           get_string('answer', 'question'),
                           $answergroupels,
                           '',
                           false);
        $mform->addElement('selectyesno', $this->form_field_name('requirescinotation'),
            get_string('scinotation', 'qtype_varnumeric'));

        $mform->addElement('editor', $this->form_field_name('feedback[0]'),
            get_string('correctfeedback', 'qtype_combined'), ['rows' => 5], $combinedform->editoroptions);
        $mform->setType('feedback[0]', PARAM_RAW);
    }

    /**
     * Prepares and returns form data for the numeric question type, including answers, errors, and feedback.
     *
     * Iterates through the answers in the question record, prepares draft areas for feedback,
     * and collects answer values, error margins, and feedback information into the $numericoptions array.
     * Merges these options with the parent form data and returns the combined result.
     *
     * @param \context $context The context in which the form is being prepared.
     * @param array $fileoptions Options for file handling in draft areas.
     *
     * @return array The combined form data including numeric options and parent data.
     */
    public function data_to_form($context, $fileoptions): array {
        $numericoptions = ['answer' => [], 'error' => []];

        if ($this->questionrec !== null) {
            foreach ($this->questionrec->options->answers as $answer) {
                $draftid = file_get_submitted_draft_itemid($this->form_field_name('answerfeedback'));
                $text = file_prepare_draft_area($draftid, $context->id,
                    'question', 'answerfeedback', $answer->id, $fileoptions, $answer->feedback);

                $numericoptions['answer'][] = $answer->answer;
                $numericoptions['error'][] = $answer->error;
                $numericoptions['feedback'][] = [
                    'text' => $text,
                    'format' => $answer->feedbackformat,
                ];
            }
        }
        return parent::data_to_form($context, $fileoptions) + $numericoptions;
    }

    /**
     * Validates the answer and error tolerance fields in the form data.
     *
     * This method checks for the following:
     * - Ensures that the answer does not contain any HTML tags.
     * - Validates that the error tolerance, if provided, is a valid number in the expected format.
     * - Validates that the answer is a valid number in the expected format.
     *
     * @return array An associative array of errors, where the keys are form field names and the values are error messages.
     */
    public function validate(): array {
        $errors = [];
        $interpret = new qtype_varnumericset_number_interpreter_number_with_optional_sci_notation(false);
        if (strip_tags($this->formdata->answer[0]) !== $this->formdata->answer[0]) {
            // Check there is not HTML in the answer. (Numbers must be 3.e8, not 3 x 10<sup>8</sup>.).
            $errors[$this->form_field_name('answergroup')] = get_string('errorvalidationinvalidanswer', 'qtype_varnumericset');
        }

        if ('' !== trim($this->formdata->error[0])) {
            if (!$interpret->match($this->formdata->error[0])) {
                $errors[$this->form_field_name('answergroup')] =
                                                    get_string('err_notavalidnumberinerrortolerance', 'qtype_varnumeric');
            }
        }
        if (!$interpret->match($this->formdata->answer[0])) {
            $errors[$this->form_field_name('answergroup')] = get_string('err_notavalidnumberinanswer', 'qtype_varnumeric');
        }

        return $errors;
    }

    /**
     * Returns the editor option for superscript or subscript based on the question settings.
     *
     * Checks if the question uses the superscript editor and returns 'sup' if true.
     * Returns null if the superscript editor is not used.
     *
     * @return string|null 'sup' if superscript editor is used, otherwise null.
     */
    public function get_sup_sub_editor_option(): string|null {
        if ($this->question->usesupeditor) {
            return 'sup';
        } else {
            return null;
        }
    }

    /**
     * Checks if there is any submitted data for this combinable question type.
     *
     * This method determines whether the user has submitted any data by checking
     * if the 'answer' or 'error' data arrays are not empty, or if the parent class
     * has any submitted data.
     *
     * @return bool True if any submitted data is present, false otherwise.
     */
    public function has_submitted_data(): bool {
        return $this->submitted_data_array_not_empty('answer') ||
            $this->submitted_data_array_not_empty('error') || parent::has_submitted_data();
    }

    /**
     * Initializes the question object for the varnumeric sub-question type.
     * Ensures that scientific notation is always disabled, even when the sup/sub editor is enabled.
     */
    public function make(): void {
        parent::make();
        // Require scientific notation is always off for this question type even when the sup sub editor is on.
        $this->question->requirescinotation = false;
    }

    /**
     * Over-ride parent function for varnumeric subq type to allow answers of '0' to be valid.
     * @param string $fieldname The name of the field to check in the submitted data.
     * @return bool is the submitted data in array with index $fieldname for this subq empty?
     */
    protected function submitted_data_array_not_empty($fieldname) {
        foreach ($this->get_submitted_param_array($fieldname) as $value) {
            if (!empty($value) || ($fieldname == 'answer' && $value === '0')) {
                return true;
            }
        }
        return false;
    }
}
