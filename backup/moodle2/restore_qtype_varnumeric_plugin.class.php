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
 * Restore plugin class that provides the necessary information needed to restore one varnumeric qtype plugin.
 * @package   qtype_varnumeric
 * @copyright 2011 The Open University
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class restore_qtype_varnumeric_plugin extends restore_qtype_plugin {

    /**
     * Returns the paths to be handled by the plugin at question level.
     */
    protected function define_question_plugin_structure() {

        $paths = [];

        // This qtype uses question_answers, add them.
        $this->add_question_question_answers($paths);

        $elements = ['qtype_varnumeric' => '/varnumeric',
                            'qtype_varnumeric_answer' => '/varnumeric_answers/varnumeric_answer',
                            'qtype_varnumeric_var' => '/vars/var',
                            'qtype_varnumeric_variant' => '/vars/var/variants/variant'];
        foreach ($elements as $elename => $path) {
            $elepath = $this->get_pathfor($path);
            $paths[] = new restore_path_element($elename, $elepath);
        }

        return $paths; // And we return the interesting paths.
    }

    #[\Override]
    public static function convert_backup_to_questiondata(array $backupdata): \stdClass {
        $questiondata = parent::convert_backup_to_questiondata($backupdata);
        $qtype = $questiondata->qtype;
        if (isset($backupdata["plugin_qtype_{$qtype}_question"]['varnumeric'])) {
            $questiondata->options = (object) array_merge(
                (array) $questiondata->options,
                $backupdata["plugin_qtype_{$qtype}_question"]['varnumeric'][0],
            );
        }

        if (isset($backupdata["plugin_qtype_{$qtype}_question"]['varnumeric_answers']['varnumeric_answer'])) {
            $varnumericanswers = $backupdata["plugin_qtype_{$qtype}_question"]['varnumeric_answers']['varnumeric_answer'];
            foreach ($varnumericanswers as $varnumericanswer) {
                foreach ($questiondata->options->answers as &$answer) {
                    if ($answer->id == $varnumericanswer['answerid']) {
                        $answer->sigfigs = $varnumericanswer['sigfigs'];
                        $answer->error = $varnumericanswer['error'];
                        $answer->syserrorpenalty = $varnumericanswer['syserrorpenalty'];
                        $answer->checknumerical = $varnumericanswer['checknumerical'];
                        $answer->checkscinotation = $varnumericanswer['checkscinotation'];
                        $answer->checkpowerof10 = $varnumericanswer['checkpowerof10'];
                        $answer->checkrounding = $varnumericanswer['checkrounding'];
                        $answer->checkscinotationformat = $varnumericanswer['checkscinotationformat'];
                        continue 2;
                    }
                }
            }
        }
        return $questiondata;
    }

    #[\Override]
    public static function remove_excluded_question_data(stdClass $questiondata, array $excludefields = []): stdClass {
        // Option recalculateeverytime default is null, we need to remove it completely.
        unset($questiondata->options->recalculateeverytime);
        return parent::remove_excluded_question_data($questiondata, $excludefields);
    }

    /**
     * Process the qtype/varnumeric element.
     *
     * @param array $data The data to process.
     */
    public function process_qtype_varnumeric($data) {
        global $DB;

        $data = (object)$data;
        $oldid = $data->id;

        // Detect if the question is created or mapped.
        $oldquestionid   = $this->get_old_parentid('question');
        $newquestionid   = $this->get_new_parentid('question');
        $questioncreated = $this->get_mappingid('question_created', $oldquestionid) ? true : false;

        // If the question has been created by restore, we need to create its
        // question_varnumeric too.
        if ($questioncreated) {
            // Adjust some columns.
            $data->questionid = $newquestionid;

            // Insert record.
            $newitemid = $DB->insert_record('qtype_varnumeric', $data);
            // Create mapping.
            $this->set_mapping('qtype_varnumeric', $oldid, $newitemid);
        }
    }

    /**
     * Process the qtype/varnumeric_answer element.
     *
     * @param array $data The data to process.
     */
    public function process_qtype_varnumeric_answer($data) {
        global $DB;

        $data = (object)$data;

        $data->answerid = $this->get_mappingid('question_answer', $data->answerid);

        // Detect if the question is created.
        $oldquestionid   = $this->get_old_parentid('question');
        $questioncreated = $this->get_mappingid('question_created', $oldquestionid) ? true : false;
        if ($questioncreated) {
            // Insert record.
            $newitemid = $DB->insert_record('qtype_varnumeric_answers', $data);
            // Create mapping.
            $this->set_mapping('qtype_varnumeric_answer', $data->id, $newitemid);
        }
    }

    /**
     * Processes the varnumeric variable element.
     *
     * @param array $data The data for processing.
     */
    public function process_qtype_varnumeric_var($data) {
        global $DB;

        $data = (object)$data;

        // Detect if the question is created.
        $oldquestionid   = $this->get_old_parentid('question');
        $newquestionid   = $this->get_new_parentid('question');
        $questioncreated = $this->get_mappingid('question_created', $oldquestionid) ? true : false;
        if ($questioncreated) {
            $data->questionid = $newquestionid;
            // Insert record.
            $newitemid = $DB->insert_record('qtype_varnumeric_vars', $data);
            // Create mapping.
            $this->set_mapping('qtype_varnumeric_var', $data->id, $newitemid);
        }
    }

    /**
     * Processes the varnumeric variant element.
     *
     * @param array $data The data for processing.
     */
    public function process_qtype_varnumeric_variant($data) {
        global $DB;

        $data = (object)$data;

        $data->varid = $this->get_new_parentid('qtype_varnumeric_var');

        // Detect if the question is created.
        $oldquestionid   = $this->get_old_parentid('question');
        $questioncreated = $this->get_mappingid('question_created', $oldquestionid) ? true : false;
        if ($questioncreated) {

            // Insert record.
            $newitemid = $DB->insert_record('qtype_varnumeric_variants', $data);
            // Create mapping.
            $this->set_mapping('qtype_varnumeric_variant', $data->id, $newitemid);
        }
    }
}
