<?php
/**
 * Создать или отредактировать олимпиаду
 */
require(__DIR__ . '/../../config.php');
require_login();
require_capability('block/olympics:manage', context_system::instance());  // ← ДОСТАВЛЕНО


global $DB, $OUTPUT;

$id = optional_param('id', 0, PARAM_INT);   // =0 → добавление

$PAGE->set_url(new moodle_url('/blocks/olympics/add.php', ['id' => $id]));
$PAGE->set_context(context_system::instance());
$PAGE->set_title($id ? 'Редактировать олимпиаду' : 'Создать олимпиаду');
$PAGE->set_heading($PAGE->title);

// --- готовим объект для формы ---
if ($id) {
    // редактирование
    $record = $DB->get_record('block_olympics', ['id' => $id], '*', MUST_EXIST);
} else {
    // новая запись
    $record = (object)[
        'id'          => 0,
        'name'        => '',
        'description' => '',
        'startdate'   => time(),
        'enddate'     => time(),
    ];
}

$form = new \block_olympics\form\olympics_form();
$form->set_data($record);

// --- обработка ---
if ($form->is_cancelled()) {
    redirect(new moodle_url('/blocks/olympics/manage.php'));

} elseif ($data = $form->get_data()) {

    if ($data->id) {                      // UPDATE
        $DB->update_record('block_olympics', $data);
        $msg = 'Олимпиада обновлена';
    } else {                              // INSERT
        $data->id = $DB->insert_record('block_olympics', $data);
        $msg = 'Олимпиада создана';
    }

    redirect(
        new moodle_url('/blocks/olympics/manage.php'),
        $msg,
        null,
        \core\output\notification::NOTIFY_SUCCESS
    );
}

// --- вывод формы ---
echo $OUTPUT->header();
$form->display();
echo $OUTPUT->footer();
