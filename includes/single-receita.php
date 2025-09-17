<?php
/**
 * Template: Single Receita (plugin)
 */
if (!defined('ABSPATH')) {
    exit;
}
get_header(); ?>

<div class="bolo-receita-single">
    <?php
    while (have_posts()) : the_post();
        ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <header class="receita-header">
                <h1 class="receita-title"><?php the_title(); ?></h1>
                <div class="receita-tempo"><?php echo esc_html(bolo_receitas_get_tempo(get_the_ID())); ?></div>
            </header>

            <div class="receita-main">
                <div class="receita-imagem">
                    <?php
                    if (has_post_thumbnail()) {
                        the_post_thumbnail('large');
                    }
                    ?>
                </div>

                <div class="receita-conteudo">
                    <h2>Descrição</h2>
                    <div class="receita-descricao">
                        <?php the_content(); ?>
                    </div>

                    <h3>Ingredientes</h3>
                    <ul class="receita-ingredientes">
                        <?php
                        $ingredientes = bolo_receitas_get_ingredientes(get_the_ID());
                        if (!empty($ingredientes)) {
                            foreach ($ingredientes as $ing) {
                                echo '<li>' . esc_html($ing) . '</li>';
                            }
                        } else {
                            echo '<li>Não informado</li>';
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </article>

        <?php
        // --- Veja mais: 3 sugestões (excluindo o atual)
        $args = [
            'post_type' => 'receita',
            'posts_per_page' => 3,
            'post__not_in' => [get_the_ID()],
            'orderby' => 'rand'
        ];
        $sug = new WP_Query($args);

        if ($sug->have_posts()) : ?>
            <section class="veja-mais">
                <h3>Veja mais</h3>
                <div class="veja-mais-grid">
                    <?php while ($sug->have_posts()) : $sug->the_post(); ?>
                        <article class="sugestao-item">
                            <a href="<?php the_permalink(); ?>">
                                <div class="sug-thumb">
                                    <?php
                                    if (has_post_thumbnail()) {
                                        the_post_thumbnail('thumbnail');
                                    } else {
                                        echo '<div class="no-thumb">' . get_the_title() . '</div>';
                                    }
                                    ?>
                                </div>
                                <div class="sug-title"><?php the_title(); ?></div>
                            </a>
                        </article>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>
            </section>
        <?php endif; ?>

    <?php endwhile; ?>
</div>

<?php get_footer(); ?>
