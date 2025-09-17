<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Registra metaboxes e hooks relacionados
 */
function bolo_receitas_register_meta_boxes() {
    add_action('add_meta_boxes', 'bolo_receitas_add_meta_boxes');
    add_action('save_post', 'bolo_receitas_save_meta', 10, 2);
}

function bolo_receitas_add_meta_boxes() {
    add_meta_box(
        'bolo_receitas_info',
        'Informações da Receita',
        'bolo_receitas_render_meta_box',
        'receita',
        'normal',
        'default'
    );
}

function bolo_receitas_render_meta_box($post) {
    wp_nonce_field('bolo_receitas_save_meta', 'bolo_receitas_meta_nonce');

    $tempo = get_post_meta($post->ID, '_bolo_tempo_preparo', true);
    $ingredientes = get_post_meta($post->ID, '_bolo_ingredientes', true);

    ?>
    <p>
        <label for="bolo_tempo_preparo"><strong>Tempo de preparo</strong></label><br>
        <input type="text" id="bolo_tempo_preparo" name="bolo_tempo_preparo" value="<?php echo esc_attr($tempo); ?>" style="width:100%;" placeholder="Ex: 40 minutos">
    </p>

    <p>
        <label for="bolo_ingredientes"><strong>Ingredientes</strong></label><br>
        <textarea id="bolo_ingredientes" name="bolo_ingredientes" rows="6" style="width:100%;" placeholder="Liste os ingredientes, um por linha"><?php echo esc_textarea($ingredientes); ?></textarea>
    </p>
    <?php
}

function bolo_receitas_save_meta($post_id, $post) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if ($post->post_type !== 'receita') return;
    if (!isset($_POST['bolo_receitas_meta_nonce']) || !wp_verify_nonce($_POST['bolo_receitas_meta_nonce'], 'bolo_receitas_save_meta')) return;
    if (!current_user_can('edit_post', $post_id)) return;

    if (isset($_POST['bolo_tempo_preparo'])) {
        update_post_meta($post_id, '_bolo_tempo_preparo', sanitize_text_field(wp_unslash($_POST['bolo_tempo_preparo'])));
    } else {
        delete_post_meta($post_id, '_bolo_tempo_preparo');
    }

    if (isset($_POST['bolo_ingredientes'])) {
        update_post_meta($post_id, '_bolo_ingredientes', sanitize_textarea_field(wp_unslash($_POST['bolo_ingredientes'])));
    } else {
        delete_post_meta($post_id, '_bolo_ingredientes');
    }
}

function bolo_receitas_get_tempo($post_id = null) {
    if (!$post_id) $post_id = get_the_ID();
    return get_post_meta($post_id, '_tempo_preparo', true);
}

function bolo_receitas_get_ingredientes($post_id = null) {
    if (!$post_id) $post_id = get_the_ID();
    $raw = get_post_meta($post_id, '_ingredientes', true);
    if (!$raw) return [];
    $lines = preg_split("/\r\n|\n|\r/", trim($raw));
    return array_filter(array_map('trim', $lines));
}
