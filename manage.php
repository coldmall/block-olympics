<?php
/**
 * Список олимпиад + действия
 */
require(__DIR__ . '/../../config.php');
require_login();

global $DB, $OUTPUT;

$PAGE->set_url(new moodle_url('/blocks/olympics/manage.php'));
$PAGE->set_context(context_system::instance());
$PAGE->set_title('Олимпиады');
$PAGE->set_heading('Список олимпиад');

// --- читаем данные ---
$olympiads = $DB->get_records('block_olympics', null, 'startdate DESC');

// --- строим таблицу ---
$table                     = new html_table();
$table->head               = ['Название', 'Начало', 'Окончание', 'Действия'];
$table->colclasses         = ['name', 'start', 'end', 'actions'];
$table->attributes['class'] = 'generaltable olympics-table';

foreach ($olympiads as $o) {
    $start = userdate($o->startdate, '%d.%m.%Y');
    $end   = userdate($o->enddate,   '%d.%m.%Y');

    // ссылки-иконки
    $editurl   = new moodle_url('/blocks/olympics/add.php',    ['id' => $o->id]);
    $deleteurl = new moodle_url('/blocks/olympics/delete.php', [
        'id' => $o->id,
        'sesskey' => sesskey(),
    ]);

    $actions =
        html_writer::link(
            $editurl,
            $OUTPUT->pix_icon('t/edit', 'Редактировать')
        ) . ' ' .
        html_writer::link(
            $deleteurl,
            $OUTPUT->pix_icon('t/delete', 'Удалить'),
            ['onclick' => "return confirm('Удалить олимпиаду «{$o->name}»?');"]
        );

    $table->data[] = [$o->name, $start, $end, $actions];
}

// --- вывод ---
echo $OUTPUT->header();
echo $OUTPUT->heading('Олимпиады');
echo html_writer::table($table);
echo $OUTPUT->footer();
