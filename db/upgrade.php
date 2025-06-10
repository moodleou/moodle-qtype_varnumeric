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
 * Varnumeric question type upgrade code.
 *
 * @package    qtype_varnumeric
 * @subpackage varnumeric
 * @copyright  2023 The Open University
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Upgrade code for the varnumeric question type.
 *
 * @param int $oldversion the version we are upgrading from.
 */
function xmldb_qtype_varnumeric_upgrade($oldversion) {
    global $DB;

    $dbman = $DB->get_manager();

    if ($oldversion < 2023120800) {

        // Define field checkscinotationformat to be added to qtype_varnumeric_answers.
        $table = new xmldb_table('qtype_varnumeric_answers');
        $field = new xmldb_field('checkscinotationformat', XMLDB_TYPE_INTEGER, '4', null, XMLDB_NOTNULL, null, '0',
            'checkscinotation');

        // Conditionally launch add field checkscinotationformat.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Varnumeric savepoint reached.
        upgrade_plugin_savepoint(true, 2023120800, 'qtype', 'varnumeric');
    }

    return true;
}
