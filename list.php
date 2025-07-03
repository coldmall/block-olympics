<?php
require(__DIR__.'/../../config.php');
require_login();

$PAGE->set_url(new moodle_url('/blocks/olympics/list.php'));
$PAGE->set_context(context_system::instance());
$PAGE->set_title('Олимпиады для абитуриентов');
$PAGE->set_heading($PAGE->title);

global $DB, $OUTPUT;

$records = $DB->get_records('block_olympics', null, 'startdate DESC');

echo $OUTPUT->header();
echo $PAGE->get_renderer('block_olympics')->olympics_grid($records);
echo $OUTPUT->footer();
