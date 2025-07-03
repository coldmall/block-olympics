<?php

class block_olympics extends block_base {
    public function init() {
        $this->title = get_string('pluginname', 'block_olympics');
    }

    public function get_content() {
        if ($this->content !== null) {
            return $this->content;
        }

        $this->content = new stdClass;
        $this->content->text = get_string('contenttext', 'block_olympics');
        $this->content->footer = '';

        return $this->content;
    }
}