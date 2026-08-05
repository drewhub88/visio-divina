<?php
/**
 * Template Name: Guest Room
 */
get_header(); ?>

<div class="page-hero">
    <div class="page-hero-label"><?php esc_html_e( 'Guest Room', 'visio' ); ?></div>
    <h1><?php esc_html_e( 'Guest Room', 'visio' ); ?></h1>
    <p><?php esc_html_e( 'Life testimonies & parenting tips from inspiring parents', 'visio' ); ?></p>
</div>

<div class="full-width-wrap" style="max-width:1100px;">
    <div class="section-heading"><h2><?php esc_html_e( 'Featured Articles & Testimonies', 'visio' ); ?></h2></div>

    <div class="guest-feed">
    <?php
    $guests = new WP_Query( [
        'post_type'      => 'guest_room',
        'posts_per_page' => 12,
        'post_status'    => 'publish',
    ] );

    $badge_map = [ 'video'=>'badge-video', 'article'=>'badge-article', 'testimony'=>'badge-testimony' ];
    $label_map = [ 'video'=>'Video', 'article'=>'Article', 'testimony'=>'Testimony' ];

    if ( $guests->have_posts() ) :
        while ( $guests->have_posts() ) : $guests->the_post();
            $speaker  = function_exists('get_field') ? get_field('guest_speaker')  : '';
            $hashtags = function_exists('get_field') ? get_field('guest_hashtags') : '';

            $type_terms = wp_get_post_terms( get_the_ID(), 'tipe_tamu' );
            $type_slug  = ! empty( $type_terms ) ? $type_terms[0]->slug : 'article';
            $badge_cls  = isset( $badge_map[ $type_slug ] ) ? $badge_map[ $type_slug ] : 'badge-article';
            $badge_lbl  = isset( $label_map[ $type_slug ] ) ? $label_map[ $type_slug ] : 'Article';
    ?>
    <div class="guest-card">
        <div class="guest-thumb">
            <?php if ( has_post_thumbnail() ) : ?>
                <?php the_post_thumbnail( 'visio-thumb' ); ?>
            <?php else : ?>
                <?php echo $type_slug === 'video' ? '📹' : ( $type_slug === 'testimony' ? '🌺' : '✍' ); ?>
            <?php endif; ?>
        </div>
        <div class="guest-body">
            <span class="guest-badge <?php echo esc_attr( $badge_cls ); ?>"><?php echo esc_html( $badge_lbl ); ?></span>
            <h3 class="guest-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
            <?php if ( $speaker ) : ?>
            <div class="guest-speaker">— <?php echo esc_html( $speaker ); ?></div>
            <?php endif; ?>
            <div class="guest-excerpt"><?php the_excerpt(); ?></div>
            <?php if ( $hashtags ) : ?>
            <div class="hashtags">
                <?php foreach ( array_map( 'trim', explode( ',', $hashtags ) ) as $tag ) : ?>
                <span class="hashtag"><?php echo esc_html( $tag ); ?></span>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <?php
        endwhile;
        wp_reset_postdata();
    else :
        echo '<p>' . esc_html__( 'No guest articles yet. Add some from the Guest Room menu.', 'visio' ) . '</p>';
    endif;
    ?>
    </div>
</div>

<?php get_footer(); ?>
