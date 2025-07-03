<?php
/**
 * Удаление олимпиады с подтверждением sesskey
 */
require(__DIR__ . '/../../config.php');
require_login();
require_sesskey();

global $DB;

$id = required_param('id', PARAM_INT);

// Проверяем существование
$olymp = $DB->get_record('block_olympics', ['id' => $id], '*', MUST_EXIST);

$DB->delete_records('block_olympics', ['id' => $id]);

redirect(
    new moodle_url('/blocks/olympics/manage.php'),
    'Олимпиада «'.$olymp->name.'» удалена',
    null,
    \core\output\notification::NOTIFY_SUCCESS
);
