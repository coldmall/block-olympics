<?php
/**
 * Список записавшихся на олимпиаду
 * URL: /blocks/olympics/enrolled.php?id=<olympiadid>
 */
require(__DIR__ . '/../../config.php');
require_login();

$olympiadid = required_param('id', PARAM_INT);

global $DB, $OUTPUT, $PAGE;

// запись должна существовать
$olymp = $DB->get_record('block_olympics', ['id' => $olympiadid], '*', MUST_EXIST);

$PAGE->set_url(new moodle_url('/blocks/olympics/enrolled.php', ['id' => $olympiadid]));
$PAGE->set_context(context_system::instance());
$PAGE->set_title('Записавшиеся: '.format_string($olymp->name));
$PAGE->set_heading($PAGE->title);

// проверяем право
require_capability('block/olympics:viewenrol', context_system::instance());

// получаем список user-id
$sql = "SELECT u.id, u.firstname, u.lastname, u.email
          FROM {block_olympics_enrol} e
          JOIN {user} u ON u.id = e.userid
         WHERE e.olympiadid = ?
      ORDER BY u.lastname, u.firstname";
$users = $DB->get_records_sql($sql, [$olympiadid]);

// строим таблицу
$table           = new html_table();
$table->head     = ['ФИО', 'E-mail'];
$table->attributes['class'] = 'generaltable enrol-table';

foreach ($users as $u) {
    $fullname = fullname($u);
    $email    = obfuscate_mailto($u->email);    // Moodle-helper «скрывает» e-mail от ботов
    $table->data[] = [$fullname, $email];
}

echo $OUTPUT->header();
echo $OUTPUT->heading('Записавшиеся на олимпиаду');
echo html_writer::table($table);
echo $OUTPUT->footer();
