<?php
/**
 * Template Name: Contributors
 */
get_header(); ?>

<div class="page-hero">
    <div class="page-hero-label"><?php esc_html_e( 'Join Us', 'visio' ); ?></div>
    <h1><?php esc_html_e( 'Contributor Space', 'visio' ); ?></h1>
    <p><?php esc_html_e( 'Make your writing a blessing to many families', 'visio' ); ?></p>
</div>

<div class="full-width-wrap" style="max-width:860px;">

    <div class="contrib-box">
        <h2><?php esc_html_e( 'Devotional Writing Guidelines', 'visio' ); ?></h2>
        <p class="subtitle"><?php esc_html_e( "Good writing is prayer flowing into words.", 'visio' ); ?></p>

        <ul class="contrib-rules">
            <li>
                <div class="rule-icon">✍</div>
                <div>
                    <strong><?php esc_html_e( 'Word limit:', 'visio' ); ?></strong>
                    <?php esc_html_e( '450 words maximum per article. Focused, concise writing connects best with young readers and families.', 'visio' ); ?>
                </div>
            </li>
            <li>
                <div class="rule-icon">📅</div>
                <div>
                    <strong><?php esc_html_e( 'Deadline:', 'visio' ); ?></strong>
                    <?php esc_html_e( 'Manuscripts are due by the 25th of each month for publication the following month.', 'visio' ); ?>
                </div>
            </li>
            <li>
                <div class="rule-icon">✝</div>
                <div>
                    <strong><?php esc_html_e( 'Theme & Characters:', 'visio' ); ?></strong>
                    <?php esc_html_e( 'Each devotional must feature at least one character (a lead or supporting character) and include one relevant Bible verse.', 'visio' ); ?>
                </div>
            </li>
            <li>
                <div class="rule-icon">📖</div>
                <div>
                    <strong><?php esc_html_e( 'Submission format:', 'visio' ); ?></strong>
                    <?php esc_html_e( 'Submit your manuscript as .docx or .txt via editorial WhatsApp, including the author name, monthly theme, and key verse.', 'visio' ); ?>
                </div>
            </li>
            <li>
                <div class="rule-icon">🌟</div>
                <div>
                    <strong><?php esc_html_e( 'Originality:', 'visio' ); ?></strong>
                    <?php esc_html_e( 'Manuscripts must be original work that has not been published elsewhere.', 'visio' ); ?>
                </div>
            </li>
            <li>
                <div class="rule-icon">💌</div>
                <div>
                    <strong><?php esc_html_e( 'Contributor appreciation:', 'visio' ); ?></strong>
                    <?php esc_html_e( 'Each published article receives a contributor honorarium — set your own rate here.', 'visio' ); ?>
                </div>
            </li>
        </ul>

        <div class="contrib-stats">
            <div class="stat-item">
                <div class="stat-number">450</div>
                <div class="stat-label"><?php esc_html_e( 'Max Words', 'visio' ); ?></div>
            </div>
            <div class="stat-item">
                <div class="stat-number">25</div>
                <div class="stat-label"><?php esc_html_e( 'Deadline / Month', 'visio' ); ?></div>
            </div>
            <div class="stat-item">
                <div class="stat-number">$X</div>
                <div class="stat-label"><?php esc_html_e( 'Honorarium / Article', 'visio' ); ?></div>
            </div>
        </div>

        <?php
        $register_page = visio_get_page_by_template( 'page-register.php' );
        $register_url = $register_page ? get_permalink( $register_page ) : home_url( '/register' );
        ?>
        <a href="<?php echo esc_url( $register_url ); ?>" class="btn-primary">
            <?php esc_html_e( 'Submit Your Writing →', 'visio' ); ?>
        </a>
    </div>

    <!-- Upcoming themes -->
    <?php
    $upcoming = get_terms( [ 'taxonomy' => 'monthly_theme', 'hide_empty' => false, 'number' => 3 ] );
    if ( ! empty( $upcoming ) && ! is_wp_error( $upcoming ) ) :
    ?>
    <div class="contrib-box">
        <h2><?php esc_html_e( 'Upcoming Monthly Themes', 'visio' ); ?></h2>
        <p class="subtitle"><?php esc_html_e( 'Prepare your writing for the following themes', 'visio' ); ?></p>
        <ul class="contrib-rules">
            <?php foreach ( $upcoming as $term ) : ?>
            <li>
                <div class="rule-icon">🌿</div>
                <div>
                    <strong><?php echo esc_html( $term->name ); ?></strong>
                    <?php if ( $term->description ) echo ' — ' . esc_html( $term->description ); ?>
                </div>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>

</div>

<?php get_footer(); ?>
