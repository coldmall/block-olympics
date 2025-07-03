<?php
/**
 * Форма создания / редактирования олимпиады
 */
namespace block_olympics\form;

defined('MOODLE_INTERNAL') || die();

global $CFG;
require_once($CFG->libdir . '/formslib.php');

class olympics_form extends \moodleform {

    public function definition() {
        $mform = $this->_form;

        // Скрытый ID — нужен для update.
        $mform->addElement('hidden', 'id', 0);
        $mform->setType('id', PARAM_INT);

        // Название
        $mform->addElement('text', 'name', 'Название олимпиады');
        $mform->setType('name', PARAM_TEXT);
        $mform->addRule('name', 'Обязательное поле', 'required', null, 'client');

        // Описание
        $mform->addElement(
            'textarea',
            'description',
            'Описание олимпиады',
            'wrap="virtual" rows="8" cols="60"'
        );
        $mform->setType('description', PARAM_TEXT);

        // Даты
        $mform->addElement('date_selector', 'startdate', 'Дата начала');
        $mform->addRule('startdate', 'Обязательное поле', 'required', null, 'client');

        $mform->addElement('date_selector', 'enddate', 'Дата окончания');
        $mform->addRule('enddate', 'Обязательное поле', 'required', null, 'client');

        // Кнопки
        $this->add_action_buttons(true, 'Сохранить');
    }
}
