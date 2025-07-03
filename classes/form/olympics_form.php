<?php
namespace block_olympics\form;

defined('MOODLE_INTERNAL') || die();

global $CFG;
require_once($CFG->libdir . '/formslib.php');

class olympics_form extends \moodleform {

    public function definition() {
        $mform = $this->_form;

        $mform->addElement('text', 'name', 'Название олимпиады');
        $mform->setType('name', PARAM_TEXT);
        $mform->addRule('name', 'Обязательное поле', 'required', null, 'client');

        $mform->addElement('editor', 'description', 'Описание олимпиады');
        $mform->setType('description', PARAM_RAW);

        $mform->addElement('date_selector', 'startdate', 'Дата начала');
        $mform->addElement('date_selector', 'enddate',   'Дата окончания');

        $this->add_action_buttons(true, 'Сохранить олимпиаду');
    }
}
