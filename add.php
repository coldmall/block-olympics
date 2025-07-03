<?php
require(__DIR__ . '/../../config.php');
require_login();

$PAGE->set_url(new moodle_url('/blocks/olympics/add.php'));
$PAGE->set_context(context_system::instance());
$PAGE->set_title('Создать олимпиаду');
$PAGE->set_heading('Создать олимпиаду');


require_once($CFG->dirroot . '/blocks/olympics/classes/form/olympics_form.php');

$form = new \block_olympics\form\olympics_form();

/* ------------------------ обработка формы ------------------------ */
if ($form->is_cancelled()) {
    redirect(new moodle_url('/my'));

} elseif ($data = $form->get_data()) {
    echo $OUTPUT->header();
    echo $OUTPUT->heading('Полученные данные');
    echo html_writer::tag('pre', print_r($data, true));
    echo $OUTPUT->continue_button(new moodle_url('/blocks/olympics/add.php'));
    echo $OUTPUT->footer();
    exit;
}

echo $OUTPUT->header();
echo $OUTPUT->heading('Создание олимпиады');
$form->display();
echo $OUTPUT->footer();
