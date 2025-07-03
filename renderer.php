<?php
defined('MOODLE_INTERNAL') || die();

class block_olympics_renderer extends plugin_renderer_base {

    /* ---------- Сетка карточек (Dashboard) ---------- */
    public function olympics_grid(array $records): string {
        $placeholder = (new moodle_url('/blocks/olympics/pix/placeholder.png'))->out(false);

        $ctx = ['placeholder' => $placeholder, 'olympics' => []];
        foreach ($records as $o) {
            $ctx['olympics'][] = [
                'name'  => format_string($o->name),
                'url'   => (new moodle_url('/blocks/olympics/view.php', ['id'=>$o->id]))->out(false),
                'image' => $o->image ?? null,
            ];
        }
        return $this->render_from_template('block_olympics/olympics_grid', $ctx);
    }

    /* ---------- Страница отдельной олимпиады ---------- */
    public function olympics_view(stdClass $rec): string {
        global $USER, $DB;

        $sysctx     = context_system::instance();
        $placeholder = (new moodle_url('/blocks/olympics/pix/placeholder.png'))->out(false);
        $image       = $rec->image ?: $placeholder;

        /* -- записан ли пользователь? -- */
        $enrolled = $DB->record_exists('block_olympics_enrol',
            ['olympiadid'=>$rec->id, 'userid'=>$USER->id]);

        /* -- имеет ли пользователь роль admissions? -- */
        static $admissionsroleid = null;
        if ($admissionsroleid === null) {
            $role = $DB->get_record('role', ['shortname' => 'admissions'], 'id', IGNORE_MISSING);
            $admissionsroleid = $role->id ?? 0;
        }
        $hasadmissions = $admissionsroleid
            ? user_has_role_assignment($USER->id, $admissionsroleid, $sysctx->id)
            : false;

        $ctx = [
            'name'        => format_string($rec->name),
            'image'       => $image,
            'start'       => userdate($rec->startdate, '%d.%m.%Y'),
            'end'         => userdate($rec->enddate,   '%d.%m.%Y'),
            'description' => format_text($rec->description, FORMAT_HTML),

            /* -- кнопка «Записаться» -- */
            'canenrol'    => has_capability('block/olympics:enrol', $sysctx) && !$enrolled,
            'enrolled'    => $enrolled,
            'enrolurl'    => (new moodle_url('/blocks/olympics/enrol.php',
                               ['id'=>$rec->id, 'sesskey'=>sesskey()]))->out(false),

            /* -- ссылка «Список записавшихся» -- */
            'canviewenrol'=> is_siteadmin() || $hasadmissions,
            'enrolledurl' => (new moodle_url('/blocks/olympics/enrolled.php',
                               ['id'=>$rec->id]))->out(false),
        ];

        return $this->render_from_template('block_olympics/olympics_view', $ctx);
    }
}
