<?php
/**
 * Template Name: Contributor Dashboard
 */
if ( ! is_user_logged_in() ) {
    $login = visio_get_page_by_template( 'page-login.php' );
    wp_redirect( $login ? get_permalink( $login ) : wp_login_url( get_permalink() ) ); exit;
}

get_header();
$current_user = wp_get_current_user();
$ref          = $_GET['ref'] ?? '';
$sub_errors   = $ref ? ( get_transient( 'visio_errors_' . $ref ) ?: [] ) : [];
if ( $ref ) delete_transient( 'visio_errors_' . $ref );

// Fetch this contributor's posts
$my_posts = new WP_Query( [
    'post_type'      => 'post',
    'author'         => $current_user->ID,
    'posts_per_page' => 20,
    'post_status'    => [ 'pending', 'publish', 'draft' ],
    'orderby'        => 'date',
    'order'          => 'DESC',
] );

$status_labels = [
    'pending' => [ 'label' => 'Pending Review',  'class' => 'status-pending' ],
    'publish' => [ 'label' => 'Published',       'class' => 'status-published' ],
    'draft'   => [ 'label' => 'Draft',            'class' => 'status-draft' ],
];
$themes = get_terms( [ 'taxonomy' => 'monthly_theme', 'hide_empty' => false ] );
$chars  = get_terms( [ 'taxonomy' => 'character',     'hide_empty' => false ] );
?>

<div class="page-hero">
    <div class="page-hero-label"><?php esc_html_e( 'Contributor Area', 'visio' ); ?></div>
    <h1><?php printf( esc_html__( 'Hi, %s!', 'visio' ), esc_html( $current_user->display_name ) ); ?></h1>
    <p><?php esc_html_e( 'Manage your submissions and send in new work here.', 'visio' ); ?></p>
</div>

<div class="full-width-wrap" style="max-width:1000px;">

    <?php if ( isset( $_GET['submitted'] ) ) : ?>
    <div class="auth-alert auth-alert-success" style="margin-bottom:28px;">
        ✅ <?php esc_html_e( 'Your submission was sent successfully and is awaiting editorial review. Thank you!', 'visio' ); ?>
    </div>
    <?php endif; ?>

    <!-- Dashboard stats -->
    <div class="dash-stats">
        <?php
        $count_pending   = new WP_Query( [ 'author' => $current_user->ID, 'post_status' => 'pending', 'posts_per_page' => -1 ] );
        $count_published = new WP_Query( [ 'author' => $current_user->ID, 'post_status' => 'publish', 'posts_per_page' => -1 ] );
        ?>
        <div class="dash-stat">
            <div class="dash-stat-number"><?php echo $count_published->found_posts; ?></div>
            <div class="dash-stat-label"><?php esc_html_e( 'Published Submissions', 'visio' ); ?></div>
        </div>
        <div class="dash-stat">
            <div class="dash-stat-number"><?php echo $count_pending->found_posts; ?></div>
            <div class="dash-stat-label"><?php esc_html_e( 'Pending Review', 'visio' ); ?></div>
        </div>
        <div class="dash-stat">
            <div class="dash-stat-number">
                <?php echo date('j') <= 25 ? (25 - date('j')) : (date('t') - date('j') + 25); ?>
            </div>
            <div class="dash-stat-label"><?php esc_html_e( 'Days Until Deadline', 'visio' ); ?></div>
        </div>
        <div class="dash-stat" style="border-right:none;">
            <a href="<?php echo esc_url( wp_logout_url( home_url('/') ) ); ?>"
               class="dash-logout" onclick="return confirm('<?php esc_attr_e('Are you sure you want to log out?','visio'); ?>')">
               <?php esc_html_e( 'Log Out', 'visio' ); ?> ↗
            </a>
            <div class="dash-stat-label"><?php esc_html_e( 'Account', 'visio' ); ?></div>
        </div>
    </div>

    <!-- ── SUBMIT NEW WRITING ─────────────────────────────── -->
    <div class="dash-section">
        <div class="section-heading"><h2>✍ <?php esc_html_e( 'Submit New Writing', 'visio' ); ?></h2></div>

        <?php if ( ! empty( $sub_errors ) ) : ?>
        <div class="auth-alert auth-alert-error" style="margin-bottom:20px;">
            <strong>⚠️ <?php esc_html_e( 'There were some errors:', 'visio' ); ?></strong>
            <ul style="margin:.5em 0 0 1.2em;">
                <?php foreach ( $sub_errors as $e ) echo '<li>' . esc_html( $e ) . '</li>'; ?>
            </ul>
        </div>
        <?php endif; ?>

        <form method="post" class="submit-form">
            <?php wp_nonce_field( 'visio_submit', 'visio_submit_nonce' ); ?>

            <!-- Title -->
            <div class="submit-field">
                <label for="sub_title">
                    <?php esc_html_e( 'Devotional Title', 'visio' ); ?>
                    <span class="auth-hint"><?php esc_html_e( '(max. 5 words)', 'visio' ); ?></span>
                </label>
                <input type="text" id="sub_title" name="sub_title" required
                       placeholder="<?php esc_attr_e( 'Example: Faithful in Small Things', 'visio' ); ?>">
            </div>

            <!-- Story content -->
            <div class="submit-field">
                <label for="sub_content">
                    <?php esc_html_e( 'Story Content', 'visio' ); ?>
                    <span class="auth-hint" id="word-count-label"><?php esc_html_e( '0 / 450 words', 'visio' ); ?></span>
                </label>
                <textarea id="sub_content" name="sub_content" rows="14" required
                          placeholder="<?php esc_attr_e( 'Write your devotional story here…', 'visio' ); ?>"></textarea>
                <div class="word-count-bar"><div id="word-count-fill"></div></div>
            </div>

            <!-- Verse -->
            <div class="submit-field-row">
                <div class="submit-field">
                    <label for="sub_verse"><?php esc_html_e( 'Key Verse', 'visio' ); ?></label>
                    <input type="text" id="sub_verse" name="sub_verse"
                           placeholder="<?php esc_attr_e( 'Verse text…', 'visio' ); ?>">
                </div>
                <div class="submit-field" style="max-width:200px;">
                    <label for="sub_verse_ref"><?php esc_html_e( 'Reference', 'visio' ); ?></label>
                    <input type="text" id="sub_verse_ref" name="sub_verse_ref"
                           placeholder="<?php esc_attr_e( 'e.g. Luke 16:10', 'visio' ); ?>">
                </div>
            </div>

            <!-- Theme + Characters -->
            <div class="submit-field-row">
                <div class="submit-field">
                    <label for="sub_theme"><?php esc_html_e( 'Monthly Theme', 'visio' ); ?></label>
                    <select id="sub_theme" name="sub_theme">
                        <option value=""><?php esc_html_e( '— Select a theme —', 'visio' ); ?></option>
                        <?php foreach ( $themes as $theme ) : ?>
                        <option value="<?php echo esc_attr( $theme->term_id ); ?>">
                            <?php echo esc_html( $theme->name ); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="submit-field">
                    <label><?php esc_html_e( 'Characters Featured', 'visio' ); ?></label>
                    <div class="submit-checkboxes">
                        <?php foreach ( $chars as $char ) : ?>
                        <label class="submit-checkbox-label">
                            <input type="checkbox" name="sub_characters[]" value="<?php echo esc_attr( $char->name ); ?>">
                            <?php echo esc_html( $char->name ); ?>
                        </label>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Activity fields -->
            <div class="submit-field">
                <label for="sub_challenge">
                    <?php esc_html_e( 'Challenge / Activity', 'visio' ); ?>
                    <span class="auth-hint"><?php esc_html_e( '(optional)', 'visio' ); ?></span>
                </label>
                <textarea id="sub_challenge" name="sub_challenge" rows="3"
                          placeholder="<?php esc_attr_e( 'A practical challenge for readers…', 'visio' ); ?>"></textarea>
            </div>

            <div class="submit-field">
                <label for="sub_reflection">
                    <?php esc_html_e( 'Reflection Questions', 'visio' ); ?>
                    <span class="auth-hint"><?php esc_html_e( '(optional)', 'visio' ); ?></span>
                </label>
                <textarea id="sub_reflection" name="sub_reflection" rows="3"
                          placeholder="<?php esc_attr_e( '1. …\n2. …\n3. …', 'visio' ); ?>"></textarea>
            </div>

            <div class="submit-field">
                <label for="sub_prayer">
                    <?php esc_html_e( 'Closing Prayer', 'visio' ); ?>
                    <span class="auth-hint"><?php esc_html_e( '(optional)', 'visio' ); ?></span>
                </label>
                <textarea id="sub_prayer" name="sub_prayer" rows="3"
                          placeholder="<?php esc_attr_e( 'Lord, teach me…', 'visio' ); ?>"></textarea>
            </div>

            <button type="submit" class="auth-btn">
                📨 <?php esc_html_e( 'Submit Writing', 'visio' ); ?>
            </button>
        </form>
    </div>

    <!-- ── MY SUBMISSIONS ─────────────────────────────────── -->
    <?php if ( $my_posts->have_posts() ) : ?>
    <div class="dash-section" style="margin-top:48px;">
        <div class="section-heading"><h2>📋 <?php esc_html_e( 'My Submissions', 'visio' ); ?></h2></div>
        <div class="my-posts-list">
        <?php while ( $my_posts->have_posts() ) : $my_posts->the_post();
            $status = get_post_status();
            $sl     = $status_labels[ $status ] ?? [ 'label' => $status, 'class' => 'status-draft' ];
        ?>
        <div class="my-post-item">
            <div class="my-post-info">
                <div class="my-post-title"><?php the_title(); ?></div>
                <div class="my-post-meta"><?php echo get_the_date( 'j F Y' ); ?></div>
            </div>
            <span class="my-post-status <?php echo esc_attr( $sl['class'] ); ?>">
                <?php echo esc_html( $sl['label'] ); ?>
            </span>
            <?php if ( $status === 'publish' ) : ?>
            <a href="<?php the_permalink(); ?>" class="my-post-link" target="_blank">
                <?php esc_html_e( 'View →', 'visio' ); ?>
            </a>
            <?php endif; ?>
        </div>
        <?php endwhile; wp_reset_postdata(); ?>
        </div>
    </div>
    <?php endif; ?>

</div>

<script>
// Live word count
var textarea = document.getElementById('sub_content');
var label    = document.getElementById('word-count-label');
var fill     = document.getElementById('word-count-fill');
if (textarea) {
    textarea.addEventListener('input', function() {
        var words = this.value.trim() === '' ? 0 : this.value.trim().split(/\s+/).length;
        var pct   = Math.min(100, (words / 450) * 100);
        label.textContent = words + ' / 450 words';
        fill.style.width  = pct + '%';
        fill.style.background = pct >= 100 ? '#c0202a' : pct >= 80 ? '#d4a80e' : 'var(--blue-mid)';
        label.style.color = pct >= 100 ? '#c0202a' : '';
    });
}
</script>

<?php get_footer(); ?>
