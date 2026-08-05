</main><!-- #content -->
</div><!-- #page -->

<footer id="colophon" role="contentinfo">
    <div class="footer-grid">

        <!-- Brand Column -->
        <div class="footer-brand">
            <div class="site-title">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="color:var(--gold-lt);">
                    <?php bloginfo( 'name' ); ?>
                </a>
            </div>
            <div style="font-family:var(--font-display);font-size:12px;font-style:italic;color:var(--gold-lt);margin-top:4px;">
                ✦ Daily Reflections ✦
            </div>
            <p><?php esc_html_e( '"Knowing Christ as a true friend through everyday life."', 'visio' ); ?></p>
        </div>

        <!-- Navigation Column -->
        <div class="footer-col">
            <h4><?php esc_html_e( 'Navigation', 'visio' ); ?></h4>
            <?php
            wp_nav_menu( [
                'theme_location' => 'footer',
                'container'      => false,
                'fallback_cb'    => false,
            ] );
            ?>
        </div>

        <!-- Themes Column -->
        <div class="footer-col">
            <h4><?php esc_html_e( 'Monthly Themes', 'visio' ); ?></h4>
            <?php
            $theme_terms = get_terms( [ 'taxonomy' => 'monthly_theme', 'hide_empty' => false, 'number' => 6 ] );
            if ( ! empty( $theme_terms ) && ! is_wp_error( $theme_terms ) ) :
            ?>
            <ul>
                <?php foreach ( $theme_terms as $term ) : ?>
                <li><a href="<?php echo esc_url( get_term_link( $term ) ); ?>"><?php echo esc_html( $term->name ); ?></a></li>
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>
        </div>

        <!-- Contact Column -->
        <div class="footer-col footer-contact">
            <h4><?php esc_html_e( 'Contact Us', 'visio' ); ?></h4>
            <p>
                <?php esc_html_e( 'Editorial WhatsApp:', 'visio' ); ?><br>
                <a href="https://wa.me/10000000000" class="wa">+1 000 000 0000</a>
            </p>
            <p>
                <?php esc_html_e( 'Social Media:', 'visio' ); ?><br>
                <strong style="color:var(--gold-lt);">@your_handle</strong>
            </p>
        </div>

    </div><!-- .footer-grid -->

    <div class="footer-bottom">
        <span>
            &copy; <?php echo date( 'Y' ); ?>
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="color:inherit;">
                <?php bloginfo( 'name' ); ?>
            </a>.
            <?php esc_html_e( 'All rights reserved.', 'visio' ); ?>
        </span>
        <span class="footer-cross">✝</span>
        <span><?php esc_html_e( 'Made with love for families everywhere', 'visio' ); ?></span>
    </div>

</footer>

<?php wp_footer(); ?>

</body>
</html>
