Variable Numeric Question Type
------------------------------

This question type is the work of Jamie Pratt (http://jamiep.org/).

This question type is compatible with Moodle 2.1+.

This question type requires the varnumericset question type to be installed. See :

    https://github.com/jamiepratt/moodle-qtype_varnumericset/

To install using git, type this command in the root of your Moodle install

    git clone git@github.com:jamiepratt/moodle-qtype_varnumeric.git question/type/varnumeric
    
Then add question/type/varnumeric to your git ignore.

Alternatively, download the zip from
    https://github.com/jamiepratt/moodle-qtype_varnumeric/zipball/master
unzip it into the question/type folder, and then rename the new folder to varnumeric.

You may want to install Tim's stripped down tinymce editor that only allows the use of 
superscript and subscript see (https://github.com/timhunt/moodle-editor_supsub). To install this
editor using git, type this command in the root of your Moodle install :

    git clone git://github.com/timhunt/moodle-editor_supsub.git lib/editor/supsub

Then add lib/editor/supsub to your git ignore.

If the editor is not installed the question type can still be used but if it is installed when 
you make a question that requires scientific notation then this editor will be shown and a 
student can either enter an answer with the notation 1x10^5 where the ^5 is expressed with super
script.
