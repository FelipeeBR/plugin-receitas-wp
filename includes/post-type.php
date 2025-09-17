<?php
if (!defined('ABSPATH')) exit;

class BoloReceitas_Post_Type {
    public function __construct() {
        add_action('init', [$this, 'register_post_type']);
        add_action('add_meta_boxes', [$this, 'add_meta_boxes']);
        add_action('save_post', [$this, 'save_meta_boxes']);

    }

    public function register_post_type() {
        register_post_type('receita', [
            'labels' => [
                'name' => 'Receitas',
                'singular_name' => 'Receita'
            ],
            'public' => true,
            'has_archive' => true,
            'rewrite' => ['slug' => 'receitas'],
            'supports' => ['title', 'editor', 'thumbnail'],
            'show_in_rest' => true
        ]);
    }

    public function add_meta_boxes() {
        add_meta_box(
            'bolo_dados',
            'Dados da Receita',
            [$this, 'render_meta_box'],
            'receita',
            'normal',
            'default'
        );
    }

    public function render_meta_box($post) {
        $tempo = get_post_meta($post->ID, '_tempo_preparo', true);
        $ingredientes = get_post_meta($post->ID, '_ingredientes', true);

        echo '<label for="tempo_preparo">Tempo de Preparo:</label>';
        echo '<input type="text" id="tempo_preparo" name="tempo_preparo" value="' . esc_attr($tempo) . '" style="width:100%;">';

        echo '<label for="ingredientes" style="margin-top:10px;display:block;">Ingredientes:</label>';
        echo '<textarea id="ingredientes" name="ingredientes" rows="5" style="width:100%;">' . esc_textarea($ingredientes) . '</textarea>';
    }

    public function save_meta_boxes($post_id) {
        if (array_key_exists('tempo_preparo', $_POST)) {
            update_post_meta($post_id, '_tempo_preparo', sanitize_text_field($_POST['tempo_preparo']));
        }
        if (array_key_exists('ingredientes', $_POST)) {
            update_post_meta($post_id, '_ingredientes', sanitize_textarea_field($_POST['ingredientes']));
        }
    }

}

