<?php
/**
 * Template Name: Figures
 */
get_header(); ?>

<div class="page-hero">
    <div class="page-hero-label"><?php esc_html_e( 'Meet Them', 'visio' ); ?></div>
    <h1><?php esc_html_e( 'Devotional Figures', 'visio' ); ?></h1>
    <p><?php esc_html_e( 'Companions who walk with you as you grow each day', 'visio' ); ?></p>
</div>

<div class="full-width-wrap">
    <p style="text-align:center;max-width:680px;margin:0 auto 40px;font-family:var(--font-body);font-style:italic;color:var(--text-muted);font-size:15px;">
        "For ye are all the children of God by faith in Christ Jesus." — Galatians 3:26 (KJV)
    </p>

    <div class="figures-grid">
    <?php
    $figures = new WP_Query( [
        'post_type'      => 'figure',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
    ] );

    if ( $figures->have_posts() ) :
        while ( $figures->have_posts() ) : $figures->the_post();
            $role   = function_exists('get_field') ? get_field('figure_role')  : '';
            $emoji  = function_exists('get_field') ? get_field('figure_emoji') : '👤';
            $color  = function_exists('get_field') ? get_field('figure_color') : 'linear-gradient(135deg,var(--blue-pale),var(--gold-pale))';
            $count  = function_exists('get_field') ? get_field('figure_count') : '';
    ?>
    <div class="figure-card">
        <div class="figure-card-header" style="background:<?php echo esc_attr( $color ); ?>">
            <?php if ( has_post_thumbnail() ) : ?>
                <div class="figure-avatar figure-avatar-img">
                    <?php the_post_thumbnail( 'visio-thumb' ); ?>
                </div>
            <?php else : ?>
                <div class="figure-avatar"><?php echo esc_html( $emoji ?: '👤' ); ?></div>
            <?php endif; ?>
        </div>
        <div class="figure-card-body">
            <div class="figure-name"><?php the_title(); ?></div>
            <?php if ( $role ) : ?>
            <div class="figure-role"><?php echo esc_html( $role ); ?></div>
            <?php endif; ?>
            <div class="figure-desc"><?php the_excerpt(); ?></div>
            <?php if ( $count ) : ?>
            <div class="figure-count">📖 <?php echo esc_html( $count ); ?></div>
            <?php endif; ?>
        </div>
    </div>
    <?php
        endwhile;
        wp_reset_postdata();
    else :
        // Fallback static figures
        $static_figures = [
            [ 'name'=>'Grace',  'role'=>'Lead Character',        'emoji'=>'💛', 'bg'=>'linear-gradient(135deg,#f5e0c0,#e8c090)', 'desc'=>'A curious, warm-hearted 12-year-old. She represents the open heart of a young person learning to hear God\'s voice.', 'count'=>'280+ devotionals' ],
            [ 'name'=>'Noah',   'role'=>'Lead Character',        'emoji'=>'💙', 'bg'=>'linear-gradient(135deg,var(--blue-pale),#b0d0f8)', 'desc'=>'Grace\'s childhood best friend. Practical, loyal, and always willing to grow and change.', 'count'=>'260+ devotionals' ],
            [ 'name'=>'Samuel', 'role'=>'Friend & Supporting Character','emoji'=>'💚', 'bg'=>'linear-gradient(135deg,#c0f0cc,#90e0a0)', 'desc'=>'A wise, steady presence — a mirror for Grace and Noah as they grow.', 'count'=>'120+ devotionals' ],
            [ 'name'=>'Grace\'s Mother','role'=>'Parent / Mentor','emoji'=>'🤍','bg'=>'linear-gradient(135deg,var(--gold-pale),#f0e0b0)','desc'=>'A wise mother figure — a good listener and strong in prayer.', 'count'=>'80+ devotionals' ],
        ];
        foreach ( $static_figures as $fig ) :
    ?>
    <div class="figure-card">
        <div class="figure-card-header" style="background:<?php echo esc_attr( $fig['bg'] ); ?>">
            <div class="figure-avatar"><?php echo esc_html( $fig['emoji'] ); ?></div>
        </div>
        <div class="figure-card-body">
            <div class="figure-name"><?php echo esc_html( $fig['name'] ); ?></div>
            <div class="figure-role"><?php echo esc_html( $fig['role'] ); ?></div>
            <div class="figure-desc"><?php echo esc_html( $fig['desc'] ); ?></div>
            <div class="figure-count">📖 <?php echo esc_html( $fig['count'] ); ?></div>
        </div>
    </div>
    <?php endforeach; endif; ?>
    </div>
</div>

<?php get_footer(); ?>
