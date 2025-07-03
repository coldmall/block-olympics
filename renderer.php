<?php
defined('MOODLE_INTERNAL') || die();

class block_olympics_renderer extends plugin_renderer_base {

    public function olympics_grid(array $records): string {

        // URL заглушки (НЕ через theme/image.php)
        $placeholder = (new moodle_url('/blocks/olympics/pix/placeholder.png'))->out(false);

        $ctx = [
            'placeholder' => $placeholder,
            'olympics'    => [],
        ];

        foreach ($records as $o) {
            $ctx['olympics'][] = [
                'name'  => format_string($o->name),
                'url'   => (new moodle_url('/blocks/olympics/view.php', ['id' => $o->id]))->out(false),
                'image' => $o->image ?? null
            ];
        }
        return $this->render_from_template('block_olympics/olympics_grid', $ctx);
    }
	
public function olympics_view(stdClass $rec): string {
    global $USER, $DB;

    $placeholder = (new moodle_url('/blocks/olympics/pix/placeholder.png'))->out(false);
    $image = $rec->image ?: $placeholder;

    $enrolled = $DB->record_exists('block_olympics_enrol',
        ['olympiadid'=>$rec->id, 'userid'=>$USER->id]);

    $ctx = [
        'name'        => format_string($rec->name),
        'image'       => $image,
        'start'       => userdate($rec->startdate, '%d.%m.%Y'),
        'end'         => userdate($rec->enddate,   '%d.%m.%Y'),
        'description' => format_text($rec->description, FORMAT_HTML),
        'enrolurl'    => (new moodle_url('/blocks/olympics/enrol.php',
                          ['id'=>$rec->id, 'sesskey'=>sesskey()]))->out(false),
        'canenrol'    => has_capability('block/olympics:enrol', context_system::instance()) && !$enrolled,
        'enrolled'    => $enrolled,
    ];
    return $this->render_from_template('block_olympics/olympics_view', $ctx);
}

}
