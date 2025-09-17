<?php
if (!defined('ABSPATH')) {
    exit;
}

class BoloReceitas_Templates {

    public function __construct() {
        add_filter('archive_template', [$this, 'load_archive_template']);
        add_filter('single_template', [$this, 'load_single_template']);
    }

    public function load_archive_template($template) {
        if (is_post_type_archive('receita')) {
            $file = BOLO_RECEITAS_PATH . 'includes/archive-receita.php';
            if (file_exists($file)) {
                return $file;
            }
        }
        return $template;
    }

    public function load_single_template($template) {
        if (get_post_type() === 'receita') {
            $file = BOLO_RECEITAS_PATH . 'includes/single-receita.php';
            if (file_exists($file)) {
                return $file;
            }
        }
        return $template;
    }
}
