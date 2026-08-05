<?php get_header(); ?>

<?php
$page_title = '';
if ( is_category() )         $page_title = single_cat_title( '', false );
elseif ( is_tag() )          $page_title = single_tag_title( '', false );
elseif ( is_tax() )          $page_title = single_term_title( '', false );
elseif ( is_search() )       $page_title = sprintf( __( 'Search Results: "%s"', 'visio' ), get_search_query() );
elseif ( is_archive() )      $page_title = __( 'Devotional Archive', 'visio' );
else                         $page_title = __( 'Daily Reflections', 'visio' );
?>

<!-- Page Hero -->
<div class="page-hero">
    <div class="page-hero-label"><?php esc_html_e( 'Daily Devotional', 'visio' ); ?></div>
    <h1><?php echo esc_html( $page_title ); ?></h1>
    <?php if ( is_tax( 'monthly_theme' ) ) : ?>
    <p><?php echo esc_html( term_description() ); ?></p>
    <?php elseif ( is_search() ) : ?>
    <p><?php printf( esc_html__( '%d results found', 'visio' ), $wp_query->found_posts ); ?></p>
    <?php endif; ?>
</div>

<div class="content-area-wrap">
    <div id="primary">

        <?php if ( have_posts() ) : ?>
        <div class="posts-loop">
        <?php
        while ( have_posts() ) : the_post();
            get_template_part( 'template-parts/content', 'card' );
        endwhile;
        ?>
        </div>

        <?php the_posts_pagination( [
            'prev_text' => '&larr; ' . __( 'Previous', 'visio' ),
            'next_text' => __( 'Next', 'visio' ) . ' &rarr;',
        ] ); ?>

        <?php else : ?>
        <p><?php esc_html_e( 'No devotionals found.', 'visio' ); ?></p>
        <?php endif; ?>

    </div>
    <?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>
