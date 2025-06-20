# Change log for the Variable numeric question type

## Changes in 2.1

* This version is compatible with Moodle 5.0.
* Fixed coding style issues.
* Defined excluded hash fields and implemented conversion of legacy backup data
  to align with new question data format (per MDL-83541).
* Fixed bug where numeric subquestion feedback text was displayed inline in combined questions.
* Added new validation to the edit form to ensure teacher's answer is in the correct format.
* Fixed a bug where adding images to feedback resulted in errors for combined numeric subquestions.
* Removed incorrect line breaks from inputs and submitted answers in combined numeric subquestions.
* Adapt mobile app template to Ionic 5
* Automation test failures are fixed.
* Added a new option to the question editing form: “If scientific notation is not formatted correctly”,
  allowing users to choose whether to accept a space between the number and unit as a valid response.
* Combined\Numeric: Added "Feedback for correct response" field.
* Added checks for empty variables to prevent save errors on the edit form.


## Changes in 2.0

* This version works with Moodle 4.0.
* Switch from Travis to Github actions.

## Changes in 1.9

* Support for Moodle mobile app for questions that don't use the superscripts/subscript editor.
* Better grading when the allowed error is very small.
* Update Behat tests to pass with Moodle 3.8.


## Changes in 1.8

* Fix Behat tests to work with Moodle 3.6.


## Changes in 1.7

* Privacy API implementation.
* Update to use the newer editor_ousupsub, instead of editor_supsub.
* Setup Travis-CI automated testing integration.
* Fix a bug with grading a response of '0' in combined questions.
* Fix some automated tests to pass with newer versions of Moodle.
* Fix some coding style.
* Due to privacy API support, this version now only works in Moodle 3.4+
  For older Moodles, you will need to use a previous version of this plugin.


## 1.6 and before

Changes were not documented here.
