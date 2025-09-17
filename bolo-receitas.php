<?php
/**
 * Plugin Name: Receitas de Bolos
 * Description: Plugin para cadastro e exibição de receitas de bolos
 * Version: 1.0.0
 * Author: Felipe Mendes
 */

if (!defined('ABSPATH')) exit;

define('BOLO_RECEITAS_PATH', plugin_dir_path(__FILE__));
define('BOLO_RECEITAS_URL', plugin_dir_url(__FILE__));

require_once BOLO_RECEITAS_PATH . 'includes/post-type.php';
require_once BOLO_RECEITAS_PATH . 'includes/templates.php';
require_once BOLO_RECEITAS_PATH . 'includes/functions.php';

class BoloReceitas {
    public function __construct() {
        new BoloReceitas_Post_Type();
        new BoloReceitas_Templates();
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
    }

    public function enqueue_scripts() {
        wp_enqueue_style('bolo-receitas-style', BOLO_RECEITAS_URL . 'assets/css/style.css', [], '1.0.0');
        wp_enqueue_script('bolo-receitas-script', BOLO_RECEITAS_URL . 'assets/js/script.js', ['jquery'], '1.0.0', true);
    }
}

// ===== Flush automático =====
register_activation_hook(__FILE__, function () {
    $cpt = new BoloReceitas_Post_Type();
    $cpt->register_post_type(); 
    flush_rewrite_rules();
});
register_deactivation_hook(__FILE__, function () {
    flush_rewrite_rules();
});

new BoloReceitas();
