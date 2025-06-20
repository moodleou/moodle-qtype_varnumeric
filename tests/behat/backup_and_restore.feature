@ou @ou_vle @qtype @qtype_varnumeric @javascript
Feature: Test duplicating a quiz containing a Variable numeric question
  As a teacher
  In order re-use my courses containing Variable numeric questions
  I need to be able to backup and restore them

  Background:
    Given the following "courses" exist:
      | fullname | shortname | format |
      | Course 1 | C1        | topics |
    And the following "question categories" exist:
      | contextlevel | reference | name           |
      | Course       | C1        | Test questions |
    And the following "questions" exist:
      | questioncategory | qtype      | name                 | template       |
      | Test questions   | varnumeric | Variable numeric 001 | with_variables |
    And the following "activities" exist:
      | activity   | name      | course | idnumber |
      | quiz       | Test quiz | C1     | quiz1    |
    And quiz "Test quiz" contains the following questions:
      | Variable numeric 001 | 1 |
    And the following config values are set as admin:
      | enableasyncbackup | 0 |

  @javascript
  Scenario: Backup and restore a course containing a Variable numeric question
    When I am on the "Course 1" course page logged in as "admin"
    And I backup "Course 1" course using this options:
      | Confirmation | Filename | test_backup.mbz |
    And I restore "test_backup.mbz" backup into a new course using this options:
      | Schema | Course name       | Course 2 |
      | Schema | Course short name | C2       |
    When I am on the "Course 2" "core_question > course question bank" page logged in as "admin"
    Then I should see "Variable numeric 001"
