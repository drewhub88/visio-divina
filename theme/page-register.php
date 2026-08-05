<?php
/**
 * Template Name: Register
 */
if ( is_user_logged_in() ) {
    $dashboard = visio_get_page_by_template( 'page-contributor-dashboard.php' );
    wp_redirect( $dashboard ? get_permalink( $dashboard ) : home_url('/') ); exit;
}
get_header();

$ref    = $_GET['ref'] ?? '';
$errors = $ref ? ( get_transient( 'visio_errors_' . $ref ) ?: [] ) : [];
if ( $ref ) delete_transient( 'visio_errors_' . $ref );
?>

<div class="auth-page-wrap">
    <div class="auth-card auth-card-wide">

        <div class="auth-card-header">
            <div class="auth-ornament">✝</div>
            <h1><?php esc_html_e( 'Register as a Contributor', 'visio' ); ?></h1>
            <p><?php esc_html_e( 'Share your writing and be a blessing to families everywhere.', 'visio' ); ?></p>
        </div>

        <?php if ( ! empty( $errors ) ) : ?>
        <div class="auth-alert auth-alert-error">
            <strong>⚠️ <?php esc_html_e( 'There were some errors:', 'visio' ); ?></strong>
            <ul style="margin:.6em 0 0 1.2em;">
                <?php foreach ( $errors as $e ) echo '<li>' . esc_html( $e ) . '</li>'; ?>
            </ul>
        </div>
        <?php endif; ?>

        <form method="post" class="auth-form">
            <?php wp_nonce_field( 'visio_register', 'visio_register_nonce' ); ?>

            <div class="auth-field-row">
                <div class="auth-field">
                    <label for="reg_fullname"><?php esc_html_e( 'Full Name', 'visio' ); ?></label>
                    <input type="text" id="reg_fullname" name="reg_fullname" autocomplete="name" required>
                </div>
                <div class="auth-field">
                    <label for="reg_username">
                        <?php esc_html_e( 'Username', 'visio' ); ?>
                        <span class="auth-hint"><?php esc_html_e( '(cannot be changed later)', 'visio' ); ?></span>
                    </label>
                    <input type="text" id="reg_username" name="reg_username" autocomplete="username" required>
                </div>
            </div>

            <div class="auth-field">
                <label for="reg_email"><?php esc_html_e( 'Email Address', 'visio' ); ?></label>
                <input type="email" id="reg_email" name="reg_email" autocomplete="email" required>
            </div>

            <div class="auth-field-row">
                <div class="auth-field">
                    <label for="reg_password">
                        <?php esc_html_e( 'Password', 'visio' ); ?>
                        <span class="auth-hint"><?php esc_html_e( '(min. 8 characters)', 'visio' ); ?></span>
                    </label>
                    <input type="password" id="reg_password" name="reg_password" autocomplete="new-password" minlength="8" required>
                </div>
                <div class="auth-field">
                    <label for="reg_password2"><?php esc_html_e( 'Confirm Password', 'visio' ); ?></label>
                    <input type="password" id="reg_password2" name="reg_password2" autocomplete="new-password" minlength="8" required>
                </div>
            </div>

            <div class="auth-field">
                <label for="reg_bio">
                    <?php esc_html_e( 'Short Bio', 'visio' ); ?>
                    <span class="auth-hint"><?php esc_html_e( '(optional — tell us about yourself)', 'visio' ); ?></span>
                </label>
                <textarea id="reg_bio" name="reg_bio" rows="3" placeholder="<?php esc_attr_e( 'Tell us a little about yourself…', 'visio' ); ?>"></textarea>
            </div>

            <!-- Contributor guidelines summary -->
            <div class="auth-guidelines">
                <div class="auth-guidelines-title">📋 <?php esc_html_e( 'Contributor Guidelines', 'visio' ); ?></div>
                <ul>
                    <li>✦ <?php esc_html_e( '450 words max per submission', 'visio' ); ?></li>
                    <li>✦ <?php esc_html_e( 'Deadline: the 20th of each month', 'visio' ); ?></li>
                    <li>✦ <?php esc_html_e( 'Include at least one character & one Bible verse', 'visio' ); ?></li>
                    <li>✦ <?php esc_html_e( 'Honorarium paid per published article', 'visio' ); ?></li>
                </ul>
            </div>

            <div class="auth-field auth-checkbox-row">
                <label class="auth-checkbox-label">
                    <input type="checkbox" name="agree_terms" required>
                    <?php
                    $contrib_page = visio_get_page_by_template( 'page-contributors.php' );
                    printf(
                        esc_html__( 'I have read and agree to %s.', 'visio' ),
                        $contrib_page
                            ? '<a href="' . esc_url( get_permalink( $contrib_page ) ) . '" target="_blank">' . esc_html__( 'the contributor guidelines', 'visio' ) . '</a>'
                            : esc_html__( 'the contributor guidelines', 'visio' )
                    );
                    ?>
                </label>
            </div>

            <button type="submit" class="auth-btn">
                <?php esc_html_e( 'Register Now', 'visio' ); ?> →
            </button>
        </form>

        <div class="auth-footer">
            <?php esc_html_e( 'Already have an account?', 'visio' ); ?>
            <?php
            $login_page = visio_get_page_by_template( 'page-login.php' );
            if ( $login_page ) :
            ?>
            <a href="<?php echo esc_url( get_permalink( $login_page ) ); ?>">
                <?php esc_html_e( 'Sign in here', 'visio' ); ?>
            </a>
            <?php endif; ?>
        </div>

    </div>
</div>

<?php get_footer(); ?>
