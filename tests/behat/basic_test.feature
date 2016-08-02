@ou @ou_vle @qtype @qtype_varnumeric @_switch_window @javascript
Feature: Test all the basic functionality of this question type
  In order evaluate students calculating ability
  As an teacher
  I need to create and preview variable numeric questions.

  Background:
    Given the following "courses" exist:
      | fullname | shortname | format |
      | Course 1 | C1        | topics |
    And the following "users" exist:
      | username | firstname |
      | teacher  | Teacher   |
    And the following "course enrolments" exist:
      | user    | course | role           |
      | teacher | C1     | editingteacher |
    And I log in as "teacher"
    And I follow "Course 1"
    And I navigate to "Question bank" node in "Course administration"

  Scenario: Create, edit then preview a variable numeric question.
    # Create a new question.
    And I add a "Variable numeric" question filling the form with:
      | Question name | My first variable numeric question |
      | Question text | What is [[a]] + [[b]]?             |
      | id_vartype_0  | Predefined variable                |
      | Variable 1    | a                                  |
      | id_variant0_0 | 2                                  |
      | Variable 2    | b = rand_int(1, 10)                |
      | Variable 3    | c = a + b                          |
      | id_answer_0   | c                                  |
      | id_fraction_0 | 100%                               |
      | id_feedback_0 | Well done!                         |
      | id_answer_1   | *                                  |
      | id_feedback_1 | Sorry, no.                         |
      | Hint 1        | Please try again.                  |
      | Hint 2        | Use a calculator if necessary.     |
    Then I should see "My first variable numeric question"

    # Preview it. Cannot get it right because of the randomisation.
    When I click on "Preview" "link" in the "My first variable numeric question" "table_row"
    And I switch to "questionpreview" window
    And I set the following fields to these values:
      | How questions behave | Interactive with multiple tries |
      | Marked out of        | 3                               |
      | Question variant     | 12                              |
      | Marks                | Show mark and max               |
    And I press "Start again with these options"
    Then I should see "What is 2 +"
    And the state of "What is 2 +" question is shown as "Tries remaining: 3"
    When I set the field "Answer:" to "-6"
    And I press "Check"
    Then I should see "Sorry, no."
    And I should see "Please try again."
    When I press "Try again"
    Then the state of "What is 2 +" question is shown as "Tries remaining: 2"
    And I switch to the main window

    # Backup the course and restore it.
    When I log out
    And I log in as "admin"
    When I backup "Course 1" course using this options:
      | Confirmation | Filename | test_backup.mbz |
    When I restore "test_backup.mbz" backup into a new course using this options:
      | Schema | Course name | Course 2 |
    Then I should see "Course 2"
    When I navigate to "Question bank" node in "Course administration"
    Then I should see "My first variable numeric question"

    # Edit the copy and verify the form field contents.
    When I click on "Edit" "link" in the "My first variable numeric question" "table_row"
    Then the following fields match these values:
      | Question name | My first variable numeric question |
      | Question text | What is [[a]] + [[b]]?             |
      | id_vartype_0  | Predefined variable                |
      | Variable 1    | a                                  |
      | id_variant0_0 | 2                                  |
      | Variable 2    | b = rand_int(1, 10)                |
      | Variable 3    | c = a + b                          |
      | id_answer_0   | c                                  |
      | id_fraction_0 | 100%                               |
      | id_feedback_0 | Well done!                         |
      | id_answer_1   | *                                  |
      | id_feedback_1 | Sorry, no.                         |
      | Hint 1        | Please try again.                  |
      | Hint 2        | Use a calculator if necessary.     |
    And I set the following fields to these values:
      | Question name | Edited question name |
    And I press "id_submitbutton"
    Then I should see "Edited question name"
