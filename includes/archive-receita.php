<?php
/**
 * Template: Archive Receitas (plugin)
 */
if (!defined('ABSPATH')) {
    exit;
}
get_header(); ?>

<div class="bolo-receitas-archive">
    <header class="page-header">
        <h1 class="page-title">Receitas</h1>
    </header>

    <?php if (have_posts()) : ?>
        <div class="receitas-grid">
            <?php while (have_posts()) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('receita-item'); ?>>
                    <a href="<?php the_permalink(); ?>">
                        <div class="receita-thumb">
                            <?php if (has_post_thumbnail()) {
                                the_post_thumbnail('medium');
                            } else { ?>
                                <img src="<?php echo esc_url(plugins_url('assets/css/placeholder.png', BOLO_RECEITAS_PATH)); ?>" alt="<?php the_title_attribute(); ?>">
                            <?php } ?>
                        </div>
                        <h2 class="receita-title"><?php the_title(); ?></h2>
                        <div class="receita-tempo"><?php echo esc_html(bolo_receitas_get_tempo(get_the_ID())); ?></div>
                    </a>
                </article>
            <?php endwhile; ?>
        </div>

        <div class="pagination">
            <?php the_posts_pagination(); ?>
        </div>

    <?php else : ?>
        <p>Não há receitas publicadas.</p>
    <?php endif; ?>
</div>

<?php get_footer(); ?>
