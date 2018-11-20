# Variable numeric question type [![Build Status](https://travis-ci.org/moodleou/moodle-qtype_varnumeric.svg?branch=master)](https://travis-ci.org/moodleou/moodle-qtype_varnumeric)

https://moodle.org/plugins/qtype_varnumeric

A numerical question type for Moodle where one question can have
several variants with different numerical values. These variants
are generated completely randomly when teh question is started.

If the [Superscript/subscript editor](https://moodle.org/plugins/editor_ousupsub) is installed
then it can be used to let students enter their answer in scientific notation,
which can be checked in the grading. However, this is optional.


## Acknowledgements

The question type was created by Jamie Pratt (http://jamiep.org/) for
the Open University (http://www.open.ac.uk/).


## Installation and set-up

This plugin should be compatible with Moodle 3.4+. It requires that
the Variable numeric set question type is also installed.

### Install from the plugins database

Install from the Moodle plugins database
* https://moodle.org/plugins/qtype_varnumericset
* https://moodle.org/plugins/qtype_varnumeric
* https://moodle.org/plugins/editor_ousupsub

### Install using git

Or you can install using git. Type this commands in the root of your Moodle install

    git clone https://github.com/moodleou/moodle-qtype_varnumericset.git question/type/varnumericset
    echo /question/type/varnumericset/ >> .git/info/exclude
    git clone https://github.com/moodleou/moodle-qtype_varnumeric.git question/type/varnumeric
    echo /question/type/varnumeric/ >> .git/info/exclude
    git clone https://github.com/moodleou/moodle-editor_ousupsub.git lib/editor/ousupsub
    echo /lib/editor/ousupsub/ >> .git/info/exclude

Then run the moodle update process
Site administration > Notifications
