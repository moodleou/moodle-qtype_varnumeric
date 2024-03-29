@ou @ou_vle @qtype @qtype_varnumeric @javascript
Feature: Preview a Variable numeric question
  As a teacher
  In order to check my Variable numeric  questions will work for students
  I need to preview them

  Background:
    Given the following "users" exist:
      | username |
      | teacher  |
    And the following "courses" exist:
      | fullname | shortname | category |
      | Course 1 | C1        | 0        |
    And the following "course enrolments" exist:
      | user    | course | role           |
      | teacher | C1     | editingteacher |
    And the following "question categories" exist:
      | contextlevel | reference | name           |
      | Course       | C1        | Test questions |
    And the following "questions" exist:
      | questioncategory | qtype      | name                 | template       |
      | Test questions   | varnumeric | Variable numeric 001 | with_variables |

  @javascript @_switch_window
  Scenario: Preview a a Variable numeric question and submit a correct response.
    When I am on the "Variable numeric 001" "core_question > preview" page logged in as teacher
    And I set the following fields to these values:
      | How questions behave | Interactive with multiple tries |
      | Marked out of        | 3                               |
      | Question variant     | 1                               |
      | Marks                | Show mark and max               |
    And I press "id_saverestart"
    Then I should see "What is 2 + 8?"
    And the state of "What is 2 + 8?" question is shown as "Tries remaining: 3"
    When I set the field "Answer:" to "2"
    And I press "Check"
    Then I should see "Sorry, no."
    And I should see "Please try again."
    When I press "Try again"
    Then the state of "What is 2 + 8?" question is shown as "Tries remaining: 2"
    When I set the field "Answer:" to "10"
    And I press "Check"
    Then I should see "Well done!"
    And the state of "What is 2 + 8?" question is shown as "Correct"
    And I should see "Mark 2.00 out of 3.00"
