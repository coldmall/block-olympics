<?php
require(__DIR__.'/../../config.php');
require_login();
require_sesskey();

$id = required_param('id', PARAM_INT);          // id олимпиады

$olymp = $DB->get_record('block_olympics', ['id'=>$id], '*', MUST_EXIST);

// проверяем право
require_capability('block/olympics:enrol', context_system::instance());

// уже записан?
$exists = $DB->record_exists('block_olympics_enrol',
    ['olympiadid'=>$id, 'userid'=>$USER->id]);

if (!$exists) {
    $rec = (object)[
        'olympiadid'   => $id,
        'userid'       => $USER->id,
        'timemodified' => time(),
    ];
    $DB->insert_record('block_olympics_enrol', $rec);
    $msg = 'Вы успешно подали заявку!';
    $type = \core\output\notification::NOTIFY_SUCCESS;
} else {
    $msg = 'Вы уже записаны на эту олимпиаду.';
    $type = \core\output\notification::NOTIFY_INFO;
}

redirect(new moodle_url('/blocks/olympics/view.php', ['id'=>$id]), $msg, null, $type);
