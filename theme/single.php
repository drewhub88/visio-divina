<?php get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>

<!-- Page Hero -->
<div class="page-hero">
    <div class="page-hero-label">
        <?php
        $theme_terms = wp_get_post_terms( get_the_ID(), 'monthly_theme' );
        echo ! empty( $theme_terms ) ? esc_html( $theme_terms[0]->name ) : esc_html__( 'Daily Devotional', 'visio' );
        ?>
    </div>
    <h1><?php the_title(); ?></h1>
    <p><?php echo get_the_date( 'j F Y' ); ?></p>
</div>

<div class="content-area-wrap">
    <div id="primary">
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

            <!-- Featured image -->
            <?php if ( has_post_thumbnail() ) : ?>
            <div class="post-thumbnail-wrap">
                <?php the_post_thumbnail( 'visio-hero' ); ?>
            </div>
            <?php endif; ?>

            <!-- Meta row -->
            <div class="entry-meta-top">
                <span class="entry-date"><?php echo get_the_date( 'j F Y' ); ?></span>
                <?php
                if ( ! empty( $theme_terms ) && ! is_wp_error( $theme_terms ) ) :
                    foreach ( $theme_terms as $t ) :
                ?>
                <a href="<?php echo esc_url( get_term_link( $t ) ); ?>" class="entry-theme">
                    <?php echo esc_html( $t->name ); ?>
                </a>
                <?php endforeach; endif; ?>
                <?php echo visio_character_tags(); ?>
            </div>

            <!-- Key verse -->
            <?php visio_key_verse(); ?>

            <!-- Story content -->
            <div class="entry-content">
                <?php the_content(); ?>
            </div>

            <!-- Mid illustration (ACF) -->
            <?php
            $mid_img = function_exists('get_field') ? get_field('mid_illustration') : null;
            if ( $mid_img ) :
            ?>
            <div class="illustration-block">
                <img src="<?php echo esc_url( $mid_img['url'] ); ?>"
                     alt="<?php echo esc_attr( $mid_img['alt'] ); ?>">
            </div>
            <?php endif; ?>

            <!-- Activity / Reflection / Prayer -->
            <?php visio_activity_box(); ?>

            <!-- Tags -->
            <?php
            $character_tags = wp_get_post_terms( get_the_ID(), 'character' );
            if ( ! empty( $character_tags ) && ! is_wp_error( $character_tags ) ) :
            ?>
            <div class="entry-footer" style="margin-top:28px;padding-top:20px;border-top:1px solid var(--border);">
                <span style="font-family:var(--font-ui);font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:var(--text-muted);margin-right:10px;"><?php esc_html_e( 'Characters:', 'visio' ); ?></span>
                <?php foreach ( $character_tags as $tag ) : ?>
                <a href="<?php echo esc_url( get_term_link( $tag ) ); ?>" class="char-tag char-<?php echo esc_attr( $tag->slug ); ?>">
                    <?php echo esc_html( $tag->name ); ?>
                </a>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <!-- Post navigation -->
            <div class="post-navigation">
                <div class="nav-previous">
                    <?php previous_post_link( '%link',
                        '<div class="nav-label">← ' . __('Previous Devotional','visio') . '</div>' .
                        '<div class="nav-post-title">%title</div>'
                    ); ?>
                </div>
                <div class="nav-next">
                    <?php next_post_link( '%link',
                        '<div class="nav-label">' . __('Next Devotional','visio') . ' →</div>' .
                        '<div class="nav-post-title">%title</div>'
                    ); ?>
                </div>
            </div>

        </article>

        <!-- Comments -->
        <?php if ( comments_open() || get_comments_number() ) : ?>
        <div class="comments-area">
            <?php comments_template(); ?>
        </div>
        <?php endif; ?>

    </div><!-- #primary -->
    <?php get_sidebar(); ?>
</div>

<?php endwhile; ?>

<?php get_footer(); ?>
