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
 * Provides the information to back up varnumeric questions.
 * @package   qtype_varnumeric
 * @copyright 2011 The Open University
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Provides the information to back up varnumeric questions.
 *
 * @copyright 2011 The Open University
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class backup_qtype_varnumeric_plugin extends backup_qtype_plugin {

    /**
     * Returns the qtype information to attach to question element.
     */
    protected function define_question_plugin_structure() {

        // Define the virtual plugin element with the condition to fulfill.
        $plugin = $this->get_plugin_element(null, '../../qtype', 'varnumeric');

        // Create one standard named plugin element (the visible container).
        $pluginwrapper = new backup_nested_element($this->get_recommended_name());

        // Connect the visible container ASAP.
        $plugin->add_child($pluginwrapper);

        // This qtype uses standard question_answers, add them here
        // to the tree before any other information that will use them.
        $this->add_question_question_answers($pluginwrapper);

        // Extra answer fields for varnumeric question type.
        $this->add_question_qtype_varnumeric_answers($pluginwrapper);

        $this->add_question_qtype_varnumeric_vars($pluginwrapper);

        // Now create the qtype own structures.
        $varnumeric = new backup_nested_element('varnumeric', ['id'], [
            'randomseed', 'recalculateeverytime', 'requirescinotation']);

        // Now the own qtype tree.
        $pluginwrapper->add_child($varnumeric);

        // Set source to populate the data.
        $varnumeric->set_source_table('qtype_varnumeric',
                ['questionid' => backup::VAR_PARENTID]);

        // Don't need to annotate ids nor files.

        return $plugin;
    }

    /**
     * Adds the `varnumeric_vars` structure to the backup element.
     *
     * This function defines the structure for backing up the `varnumeric_vars` data
     * associated with a question. It ensures the correct hierarchy and sources are set
     * for the backup process.
     *
     * @param backup_nested_element $element The parent backup element to which the vars structure will be added.
     */
    protected function add_question_qtype_varnumeric_vars($element) {
        // Check $element is one nested_backup_element.
        if (! $element instanceof backup_nested_element) {
            throw new backup_step_exception('qtype_varnumeric_vars_bad_parent_element', $element);
        }

        // Define the elements.
        $vars = new backup_nested_element('vars');
        $var = new backup_nested_element('var', ['id'],
                                                ['varno', 'nameorassignment']);

        $this->add_question_qtype_varnumeric_variants($var);

        // Build the tree.
        $element->add_child($vars);
        $vars->add_child($var);

        // Set source to populate the data.
        $var->set_source_table('qtype_varnumeric_vars',
                                                ['questionid' => backup::VAR_PARENTID]);
    }

    /**
     * Adds the `varnumeric_variants` structure to the backup element.
     *
     * This function defines the structure for backing up the `varnumeric_variants` data
     * associated with a question. It ensures the correct hierarchy and sources are set
     * for the backup process.
     *
     * @param backup_nested_element $element The parent backup element to which the variants structure will be added.
     */
    protected function add_question_qtype_varnumeric_variants($element) {
        // Check $element is one nested_backup_element.
        if (! $element instanceof backup_nested_element) {
            throw new backup_step_exception('qtype_varnumeric_variants_bad_parent_element',
                                                                                        $element);
        }

        // Define the elements.
        $variants = new backup_nested_element('variants');
        $variant = new backup_nested_element('variant', ['id'],
                                                ['varid', 'variantno', 'value']);

        // Build the tree.
        $element->add_child($variants);
        $variants->add_child($variant);

        // Set source to populate the data.
        $variant->set_source_table('qtype_varnumeric_variants',
                                                ['varid' => backup::VAR_PARENTID]);
    }

    /**
     * Adds the `varnumeric_answers` structure to the backup element.
     *
     * This function defines the structure for backing up the `varnumeric_answers` data
     * associated with a question. It ensures the correct hierarchy and sources are set
     * for the backup process.
     *
     * @param backup_nested_element $element The parent backup element to which the answers structure will be added.
     */
    protected function add_question_qtype_varnumeric_answers($element) {
        // Check $element is one nested_backup_element.
        if (! $element instanceof backup_nested_element) {
            throw new backup_step_exception('question_varnumeric_answers_bad_parent_element',
                                                $element);
        }

        // Define the elements.
        $answers = new backup_nested_element('varnumeric_answers');
        $answer = new backup_nested_element('varnumeric_answer', ['id'], [
            'answerid', 'error', 'sigfigs', 'checknumerical', 'checkscinotation',
            'checkpowerof10', 'checkrounding', 'syserrorpenalty', 'checkscinotationformat']);

        // Build the tree.
        $element->add_child($answers);
        $answers->add_child($answer);

        // Set the sources.
        $answer->set_source_sql('
                SELECT vans.*
                  FROM {qtype_varnumeric_answers} vans
                  JOIN {question_answers} ans ON  ans.id = vans.answerid
                 WHERE ans.question = :question
              ORDER BY id',
                ['question' => backup::VAR_PARENTID]);
        // Don't need to annotate ids or files.
    }
}
