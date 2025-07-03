<?php
require(__DIR__.'/../../config.php');
require_login();

$id = required_param('id', PARAM_INT);

global $DB, $OUTPUT;

$rec = $DB->get_record('block_olympics', ['id' => $id], '*', MUST_EXIST);

$PAGE->set_url(new moodle_url('/blocks/olympics/view.php', ['id' => $id]));
$PAGE->set_context(context_system::instance());
$PAGE->set_title(format_string($rec->name));
$PAGE->set_heading('');               // ← убрали чёрный заголовок

echo $OUTPUT->header();
echo $PAGE->get_renderer('block_olympics')->olympics_view($rec);
echo $OUTPUT->footer();
