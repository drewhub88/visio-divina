<?php get_header(); ?>

<div class="page-hero">
    <div class="page-hero-label"><?php esc_html_e( 'Page', 'visio' ); ?></div>
    <h1><?php the_title(); ?></h1>
</div>

<div class="content-area-wrap">
    <div id="primary">
        <?php while ( have_posts() ) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <?php if ( has_post_thumbnail() ) : ?>
            <div class="post-thumbnail-wrap" style="margin-bottom:28px;">
                <?php the_post_thumbnail( 'visio-hero' ); ?>
            </div>
            <?php endif; ?>
            <div class="entry-content">
                <?php the_content(); ?>
            </div>
        </article>
        <?php endwhile; ?>
    </div>
    <?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>
