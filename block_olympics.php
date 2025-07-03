<?php
defined('MOODLE_INTERNAL') || die();

/**
 * Блок «Олимпиады» — выводит карточки доступных олимпиад
 * на личной странице пользователя (/my/).
 */
class block_olympics extends block_base {

    public function init(): void {
        $this->title = get_string('pluginname', 'block_olympics');
    }

    /** Отображаем только на Dashboard (personal page) */
    public function applicable_formats(): array {
        return [
            'my' => true,   // личный кабинет
            'site' => false,
            'course-view' => false,
            'mod' => false,
        ];
    }

    public function get_content(): stdClass {
        if ($this->content !== null) {
            return $this->content;
        }

        global $DB;

        // Берём все олимпиады (фильтрацию дат можно добавить позже).
        $records = $DB->get_records('block_olympics', null, 'startdate DESC');

        // Рендерим сетку через наш renderer.
        $renderer     = $this->page->get_renderer('block_olympics');
        $html         = $renderer->olympics_grid($records);

        $this->content             = new stdClass();
        $this->content->text       = $html;
        $this->content->footer     = '';      // ничего в футере
        return $this->content;
    }
}
