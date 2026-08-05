<?php
/**
 * Template Name: Login
 */
if ( is_user_logged_in() ) {
    $dashboard = visio_get_page_by_template( 'page-contributor-dashboard.php' );
    wp_redirect( $dashboard ? get_permalink( $dashboard ) : home_url('/') ); exit;
}
get_header(); ?>

<div class="auth-page-wrap">
    <div class="auth-card">

        <div class="auth-card-header">
            <div class="auth-ornament">✝</div>
            <h1><?php esc_html_e( 'Sign In to Visio Divina', 'visio' ); ?></h1>
            <p><?php esc_html_e( 'Welcome back, contributor.', 'visio' ); ?></p>
        </div>

        <?php if ( isset( $_GET['login'] ) && $_GET['login'] === 'failed' ) : ?>
        <div class="auth-alert auth-alert-error">
            ⚠️ <?php esc_html_e( 'Incorrect username or password. Please try again.', 'visio' ); ?>
        </div>
        <?php endif; ?>

        <?php if ( isset( $_GET['registered'] ) ) : ?>
        <div class="auth-alert auth-alert-success">
            ✅ <?php esc_html_e( 'Registration successful! Please sign in.', 'visio' ); ?>
        </div>
        <?php endif; ?>

        <form method="post" class="auth-form">
            <?php wp_nonce_field( 'visio_login', 'visio_login_nonce' ); ?>
            <input type="hidden" name="redirect_to" value="<?php echo esc_attr( $_GET['redirect_to'] ?? '' ); ?>">

            <div class="auth-field">
                <label for="log_username"><?php esc_html_e( 'Username or Email', 'visio' ); ?></label>
                <input type="text" id="log_username" name="log_username" autocomplete="username" required>
            </div>

            <div class="auth-field">
                <label for="log_password"><?php esc_html_e( 'Password', 'visio' ); ?></label>
                <input type="password" id="log_password" name="log_password" autocomplete="current-password" required>
            </div>

            <div class="auth-field auth-remember">
                <label class="auth-checkbox-label">
                    <input type="checkbox" name="remember_me">
                    <?php esc_html_e( 'Remember me', 'visio' ); ?>
                </label>
                <a href="<?php echo esc_url( wp_lostpassword_url() ); ?>" class="auth-forgot">
                    <?php esc_html_e( 'Forgot password?', 'visio' ); ?>
                </a>
            </div>

            <button type="submit" class="auth-btn">
                <?php esc_html_e( 'Sign In', 'visio' ); ?> →
            </button>
        </form>

        <div class="auth-footer">
            <?php esc_html_e( 'Don\'t have an account?', 'visio' ); ?>
            <?php
            $reg_page = visio_get_page_by_template( 'page-register.php' );
            if ( $reg_page ) :
            ?>
            <a href="<?php echo esc_url( get_permalink( $reg_page ) ); ?>">
                <?php esc_html_e( 'Register as a contributor', 'visio' ); ?>
            </a>
            <?php endif; ?>
        </div>

    </div>
</div>

<?php get_footer(); ?>
