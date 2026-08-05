<?php get_header(); ?>

<?php
// Get today's post, fallback to latest
$today_query = new WP_Query( [
    'posts_per_page' => 1,
    'post_status'    => 'publish',
    'date_query'     => [ [ 'year' => date('Y'), 'month' => date('m'), 'day' => date('d') ] ],
] );
if ( ! $today_query->have_posts() ) {
    $today_query = new WP_Query( [ 'posts_per_page' => 1, 'post_status' => 'publish' ] );
}

$hero_post_id   = 0;
$hero_title     = get_bloginfo( 'name' );
$hero_verse     = '';
$hero_verse_ref = '';
$hero_permalink = home_url('/');

if ( $today_query->have_posts() ) {
    $today_query->the_post();
    $hero_post_id   = get_the_ID();
    $hero_title     = get_the_title();
    $hero_permalink = get_permalink();
    $hero_verse     = function_exists('get_field') ? get_field('key_verse')       : '';
    $hero_verse_ref = function_exists('get_field') ? get_field('verse_reference') : '';
    wp_reset_postdata();
}

// Today's date, spelled out
$days   = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
$months = ['','January','February','March','April','May','June','July','August','September','October','November','December'];
$today_label = $days[ date('w') ] . ', ' . $months[ (int) date('n') ] . ' ' . date('j') . ', ' . date('Y');

// Header image priority:
// 1. Today's post featured image
// 2. WordPress custom header (Appearance → Header)
// 3. CSS gradient fallback
$header_img_url = '';
if ( $hero_post_id && has_post_thumbnail( $hero_post_id ) ) {
    $thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $hero_post_id ), 'visio-hero' );
    if ( $thumb ) $header_img_url = $thumb[0];
}
if ( ! $header_img_url && get_header_image() ) {
    $header_img_url = get_header_image();
}
?>

<!-- ═══════════════════════════════════════════════════════════════
     FULL-WIDTH HEADER IMAGE HERO
════════════════════════════════════════════════════════════════ -->
<section class="front-hero-img" aria-label="<?php esc_attr_e( "Today's Devotional", 'visio' ); ?>">

    <!-- Background -->
    <div class="fhi-bg"<?php if ( $header_img_url ) echo ' style="background-image:url(\'' . esc_url( $header_img_url ) . '\')"'; ?>>
        <div class="fhi-overlay"></div>
    </div>

    <!-- Centred content block -->
    <div class="fhi-content">
        <div class="fhi-inner">

            <div class="today-badge"><?php echo esc_html( $today_label ); ?></div>

            <h1 class="fhi-title">
                <a href="<?php echo esc_url( $hero_permalink ); ?>">
                    <?php echo esc_html( $hero_title ); ?>
                </a>
            </h1>

            <?php if ( $hero_verse ) : ?>
            <div class="fhi-verse">
                <p>
                    "<?php echo esc_html( $hero_verse ); ?>"
                    <?php if ( $hero_verse_ref ) : ?>
                    <em> — <?php echo esc_html( $hero_verse_ref ); ?></em>
                    <?php endif; ?>
                </p>
            </div>
            <?php endif; ?>

            <a href="<?php echo esc_url( $hero_permalink ); ?>" class="fhi-read-btn">
                <?php esc_html_e( "Read Today's Devotional", 'visio' ); ?> ↓
            </a>

        </div>
    </div>

    <!-- Animated scroll cue -->
    <div class="fhi-scroll-hint" aria-hidden="true">
        <div class="fhi-chevron"></div>
    </div>

</section>

<!-- ═══════════════════════════════════════════════════════════════
     TWO-COLUMN CONTENT + SIDEBAR
════════════════════════════════════════════════════════════════ -->
<div class="content-area-wrap">

    <div id="primary">
        <?php
        $main_query = new WP_Query( [
            'posts_per_page' => 1,
            'post_status'    => 'publish',
            'date_query'     => [ [ 'year' => date('Y'), 'month' => date('m'), 'day' => date('d') ] ],
        ] );
        if ( ! $main_query->have_posts() ) {
            $main_query = new WP_Query( [ 'posts_per_page' => 1, 'post_status' => 'publish' ] );
        }

        if ( $main_query->have_posts() ) :
            while ( $main_query->have_posts() ) : $main_query->the_post();
        ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

            <div class="entry-meta-top">
                <span class="entry-date"><?php echo get_the_date( 'j F Y' ); ?></span>
                <?php
                $theme_terms = wp_get_post_terms( get_the_ID(), 'monthly_theme' );
                if ( ! empty( $theme_terms ) && ! is_wp_error( $theme_terms ) ) :
                    foreach ( $theme_terms as $t ) :
                ?>
                <a href="<?php echo esc_url( get_term_link( $t ) ); ?>" class="entry-theme">
                    <?php echo esc_html( $t->name ); ?>
                </a>
                <?php endforeach; endif;
                echo visio_character_tags();
                ?>
            </div>

            <h2 class="entry-title">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h2>

            <?php visio_key_verse(); ?>

            <div class="entry-content">
                <?php the_content( sprintf(
                    '<a href="%s" class="read-more">%s →</a>',
                    esc_url( get_permalink() ),
                    __( 'Read More', 'visio' )
                ) ); ?>
            </div>

            <?php
            $mid_img = function_exists('get_field') ? get_field('mid_illustration') : null;
            if ( $mid_img ) : ?>
            <div class="illustration-block">
                <img src="<?php echo esc_url( $mid_img['url'] ); ?>"
                     alt="<?php echo esc_attr( $mid_img['alt'] ); ?>">
            </div>
            <?php endif; ?>

            <?php visio_activity_box(); ?>

            <div class="post-navigation">
                <div class="nav-previous">
                    <?php previous_post_link( '%link',
                        '<div class="nav-label">← ' . __( 'Yesterday', 'visio' ) . '</div>' .
                        '<div class="nav-post-title">%title</div>'
                    ); ?>
                </div>
                <div class="nav-next">
                    <?php next_post_link( '%link',
                        '<div class="nav-label">' . __( 'Tomorrow', 'visio' ) . ' →</div>' .
                        '<div class="nav-post-title">%title</div>'
                    ); ?>
                </div>
            </div>

        </article>

        <?php
            endwhile;
            wp_reset_postdata();
        else :
        ?>
        <p style="font-family:var(--font-body);color:var(--text-muted);padding:20px 0;">
            <?php esc_html_e( 'No devotionals yet. Please add a new post.', 'visio' ); ?>
        </p>
        <?php endif; ?>
    </div><!-- #primary -->

    <?php get_sidebar(); ?>

</div><!-- .content-area-wrap -->

<?php get_footer(); ?>
