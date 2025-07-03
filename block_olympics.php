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

    $records   = $DB->get_records('block_olympics', null, 'startdate DESC');
    $renderer  = $this->page->get_renderer('block_olympics');

    $this->content            = new stdClass();
    $this->content->text      = $renderer->olympics_grid($records);
    $this->content->footer    = '';

    /* ── ДОБАВЛЯЕМ ссылку «Управление олимпиадами» ───────────── */
    $sysctx     = context_system::instance();
    if (has_capability('block/olympics:manage', $sysctx)) {
        $url = new moodle_url('/blocks/olympics/manage.php');
        $link = html_writer::link($url, get_string('manageolympics', 'block_olympics'));
        // Добавим небольшим шрифтом под сеткой
        $this->content->text .= html_writer::tag('p', $link,
                                ['class' => 'text-end mt-2 olymp-manage-link']);
    }
    /* ─────────────────────────────────────────────────────────── */

    return $this->content;
}

}
