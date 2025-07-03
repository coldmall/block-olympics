<?php
/**
 * Список всех олимпиад + управление
 * URL: /blocks/olympics/manage.php
 */
require(__DIR__.'/../../config.php');
require_login();

$sysctx = context_system::instance();
$canmanage = has_capability('block/olympics:manage', $sysctx);

if (!$canmanage) {
    // пусть даже если кто-то знает ссылку — доступ закрыт
    print_error('nopermissions', 'error', '', 'block/olympics:manage');
}

$PAGE->set_url(new moodle_url('/blocks/olympics/manage.php'));
$PAGE->set_context($sysctx);
$PAGE->set_title('Управление олимпиадами');
$PAGE->set_heading($PAGE->title);

global $DB, $OUTPUT;

// ── читаем данные
$olymps = $DB->get_records('block_olympics', null, 'startdate DESC');

// ── таблица
$table           = new html_table();
$table->head     = ['Название', 'Начало', 'Окончание', 'Действия'];
$table->attributes['class'] = 'generaltable olympics-admin';

foreach ($olymps as $o) {
    $start = userdate($o->startdate, '%d.%m.%Y');
    $end   = userdate($o->enddate,   '%d.%m.%Y');

    // ссылки действий (только если $canmanage, но мы уже проверили выше)
    $editurl   = new moodle_url('/blocks/olympics/add.php',    ['id'=>$o->id]);
    $deleteurl = new moodle_url('/blocks/olympics/delete.php', ['id'=>$o->id, 'sesskey'=>sesskey()]);

    $actions = html_writer::link($editurl,
                    $OUTPUT->pix_icon('t/edit',   'Редактировать')).' '.
               html_writer::link($deleteurl,
                    $OUTPUT->pix_icon('t/delete', 'Удалить'),
                    ['onclick'=>"return confirm('Удалить «{$o->name}»?');"]);

    $table->data[] = [$o->name, $start, $end, $actions];
}

// ── кнопка «Создать олимпиаду»
$addbutton = html_writer::link(
    new moodle_url('/blocks/olympics/add.php'),
    'Создать олимпиаду',
    ['class' => 'btn btn-primary olymp-add-btn']
);

echo $OUTPUT->header();
echo html_writer::div($addbutton, 'mb-3');      // кнопка сверху
echo html_writer::table($table);
echo $OUTPUT->footer();
