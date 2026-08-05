<div id="secondary" role="complementary">
    <?php
    if ( is_active_sidebar( 'sidebar-1' ) ) {
        dynamic_sidebar( 'sidebar-1' );
    } else {
        // Default sidebar content when no widgets are assigned
        ?>

        <!-- Default: Calendar Widget -->
        <div class="widget">
            <h3 class="widget-title">📅 <?php esc_html_e( 'Devotional Calendar', 'visio' ); ?></h3>
            <div class="widget-content">
                <div class="visio-calendar" id="visio-cal-sidebar"></div>
            </div>
        </div>

        <!-- Default: Theme Index -->
        <?php
        $themes = get_terms( [ 'taxonomy' => 'monthly_theme', 'hide_empty' => false, 'number' => 12 ] );
        if ( ! empty( $themes ) && ! is_wp_error( $themes ) ) :
        $colors = [ '#2a4a8a','#b8920a','#1a6a30','#c06010','#6a1a8a','#8a1a1a','#1a6a6a','#3a6bc8','#d4a80e','#2e5ba8','#4a7acc','#1a3060' ];
        ?>
        <div class="widget">
            <h3 class="widget-title">📌 <?php esc_html_e( 'Monthly Theme Index', 'visio' ); ?></h3>
            <div class="widget-content">
                <div class="theme-index-list">
                    <?php foreach ( $themes as $i => $term ) : ?>
                    <a href="<?php echo esc_url( get_term_link( $term ) ); ?>" class="theme-index-item">
                        <span class="theme-dot" style="background:<?php echo esc_attr( $colors[ $i % count($colors) ] ); ?>"></span>
                        <span class="theme-name"><?php echo esc_html( $term->name ); ?></span>
                        <span class="theme-count-lbl"><?php echo $term->count; ?> <?php esc_html_e( 'days', 'visio' ); ?></span>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Default: Recent Posts -->
        <?php
        $recent = get_posts( [ 'numberposts' => 5, 'post_status' => 'publish' ] );
        if ( ! empty( $recent ) ) :
        $months_id = [1=>'Jan',2=>'Feb',3=>'Mar',4=>'Apr',5=>'May',6=>'Jun',7=>'Jul',8=>'Aug',9=>'Sep',10=>'Oct',11=>'Nov',12=>'Dec'];
        ?>
        <div class="widget">
            <h3 class="widget-title">🕊 <?php esc_html_e( 'Recent Devotionals', 'visio' ); ?></h3>
            <div class="widget-content">
                <?php foreach ( $recent as $post ) :
                    $day = get_the_date( 'j', $post );
                    $mon = $months_id[ (int) get_the_date( 'n', $post ) ];
                    $themes_post = wp_get_post_terms( $post->ID, 'monthly_theme' );
                    $theme_name  = ! empty( $themes_post ) ? $themes_post[0]->name : '';
                ?>
                <a href="<?php echo esc_url( get_permalink( $post ) ); ?>" class="recent-post-item">
                    <div class="rp-date-badge">
                        <div class="rp-day"><?php echo esc_html( $day ); ?></div>
                        <div class="rp-month"><?php echo esc_html( $mon ); ?></div>
                    </div>
                    <div>
                        <div class="recent-post-title"><?php echo esc_html( get_the_title( $post ) ); ?></div>
                        <?php if ( $theme_name ) : ?>
                        <div class="recent-post-theme"><?php echo esc_html( $theme_name ); ?></div>
                        <?php endif; ?>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

    <?php } ?>
</div><!-- #secondary -->
