@ou @ou_vle @qtype @qtype_varnumeric @_switch_window @javascript
Feature: Test creating a Variable numeric question type
  In order evaluate students calculating ability
  As an teacher
  I need to create a Variable numeric questions.

  Background:
    Given the following "users" exist:
      | username | firstname |
      | teacher  | Teacher   |
    And the following "courses" exist:
      | fullname | shortname | format |
      | Course 1 | C1        | topics |
    And the following "course enrolments" exist:
      | user    | course | role           |
      | teacher | C1     | editingteacher |

  Scenario: Create a Variable numeric question.
    # Create a new question.
    When I am on the "Course 1" "core_question > course question bank" page logged in as teacher
    And I add a "Variable numeric" question filling the form with:
      | Question name | variable numeric question 001  |
      | Question text | What is [[a]] + [[b]]?         |
      | id_vartype_0  | Predefined variable            |
      | Variable 1    | a                              |
      | id_variant0_0 | 2                              |
      | Variable 2    | b = rand_int(1, 10)            |
      | Variable 3    | c = a + b                      |
      | id_answer_0   | c                              |
      | id_fraction_0 | 100%                           |
      | id_feedback_0 | Well done!                     |
      | id_answer_1   | *                              |
      | id_feedback_1 | Sorry, no.                     |
      | Hint 1        | Please try again.              |
      | Hint 2        | Use a calculator if necessary. |
    Then I should see "variable numeric question 001"
