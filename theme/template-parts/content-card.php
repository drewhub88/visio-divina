<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-card' ); ?>>

    <!-- Thumbnail -->
    <div class="post-card-thumb">
        <?php if ( has_post_thumbnail() ) : ?>
            <?php the_post_thumbnail( 'visio-card' ); ?>
        <?php else : ?>
            📖
        <?php endif; ?>
    </div>

    <!-- Body -->
    <div class="post-card-body">
        <div class="post-card-meta">
            <span class="post-card-date"><?php echo get_the_date( 'j F Y' ); ?></span>
            <?php
            $theme_terms = wp_get_post_terms( get_the_ID(), 'monthly_theme' );
            if ( ! empty( $theme_terms ) && ! is_wp_error( $theme_terms ) ) :
                echo '<a href="' . esc_url( get_term_link( $theme_terms[0] ) ) . '" class="entry-theme">' . esc_html( $theme_terms[0]->name ) . '</a>';
            endif;
            echo visio_character_tags();
            ?>
        </div>

        <h2 class="post-card-title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h2>

        <div class="post-card-excerpt"><?php the_excerpt(); ?></div>

        <a href="<?php the_permalink(); ?>" class="read-more">
            <?php esc_html_e( 'Read Devotional', 'visio' ); ?> →
        </a>
    </div>

</article>
