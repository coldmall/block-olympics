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
    // если нет картинки – берём заглушку из pix
    if (empty($rec->image)) {
        $rec->image = (new moodle_url('/blocks/olympics/pix/placeholder.png'))->out(false);
    }

    $ctx = [
        'name'        => format_string($rec->name),
        'image'       => $rec->image,
        'start'       => userdate($rec->startdate, '%d.%m.%Y'),
        'end'         => userdate($rec->enddate,   '%d.%m.%Y'),
        'description' => format_text($rec->description, FORMAT_HTML),
        'enrolurl'    => (new moodle_url('/blocks/olympics/enrol.php', ['id' => $rec->id]))->out(false),
    ];

    return $this->render_from_template('block_olympics/olympics_view', $ctx);
}
}
