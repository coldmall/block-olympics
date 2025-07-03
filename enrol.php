<?php
require(__DIR__.'/../../config.php');
require_login();
require_sesskey();

$id = required_param('id', PARAM_INT);
// TODO: логика записи

redirect(new moodle_url('/blocks/olympics/view.php', ['id'=>$id]),
         'Вы записаны на олимпиаду!', null,
         \core\output\notification::NOTIFY_SUCCESS);
