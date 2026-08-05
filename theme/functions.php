<?php
/**
 * Visio Divina — functions.php
 * Theme setup, enqueues, CPTs, taxonomies, widgets, ACF helpers
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'VISIO_VERSION', '1.0.0' );
define( 'VISIO_DIR', get_template_directory() );
define( 'VISIO_URI', get_template_directory_uri() );

/* ─── THEME SETUP ──────────────────────────────────────────────── */
function visio_setup() {
    load_theme_textdomain( 'visio', VISIO_DIR . '/languages' );
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', [ 'search-form','comment-form','comment-list','gallery','caption','script','style' ] );
    add_theme_support( 'custom-logo', [
        'height'      => 80,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ] );
    add_theme_support( 'customize-selective-refresh-widgets' );
    add_theme_support( 'custom-header', [
        'default-image'      => '',
        'width'              => 1920,
        'height'             => 600,
        'flex-height'        => true,
        'flex-width'         => true,
        'uploads'            => true,
        'default-text-color' => 'ffffff',
        'header-text'        => true,
    ] );

    // Thumbnail sizes
    add_image_size( 'visio-hero',    1200, 525, true );
    add_image_size( 'visio-card',    600,  338, true );
    add_image_size( 'visio-thumb',   200,  200, true );
    add_image_size( 'visio-mid',     900,  386, true );

    // Navigation menus
    register_nav_menus( [
        'primary'   => __( 'Main Navigation', 'visio' ),
        'footer'    => __( 'Footer Navigation', 'visio' ),
        'secondary' => __( 'Footer Themes Menu', 'visio' ),
    ] );
}
add_action( 'after_setup_theme', 'visio_setup' );

/* ─── ENQUEUE STYLES & SCRIPTS ─────────────────────────────────── */
function visio_scripts() {
    // Google Fonts
    wp_enqueue_style(
        'visio-fonts',
        'https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400;1,600&family=Lora:ital,wght@0,400;0,500;1,400&family=Source+Sans+3:wght@300;400;500;600;700&display=swap',
        [],
        null
    );
    // Main stylesheet
    wp_enqueue_style( 'visio-style', get_stylesheet_uri(), [ 'visio-fonts' ], VISIO_VERSION );
    // Main JS
    wp_enqueue_script( 'visio-main', VISIO_URI . '/assets/js/main.js', [ 'jquery' ], VISIO_VERSION, true );

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
    // Pass data to JS
    wp_localize_script( 'visio-main', 'visioData', [
        'ajaxUrl' => admin_url( 'admin-ajax.php' ),
        'nonce'   => wp_create_nonce( 'visio_nonce' ),
    ] );
}
add_action( 'wp_enqueue_scripts', 'visio_scripts' );

/* ─── CUSTOM POST TYPES ─────────────────────────────────────────── */
function visio_register_cpts() {

   // Devotionals (default 'post' type) is already registered by WordPress
    // but we register Guest Room and Shop as CPTs

    // Guest Room
    register_post_type( 'guest_room', [
        'labels' => [
            'name'          => __( 'Guest Room', 'visio' ),
            'singular_name' => __( 'Guest Article', 'visio' ),
            'add_new_item'  => __( 'Add Guest Article', 'visio' ),
        ],
        'public'        => true,
        'has_archive'   => true,
        'rewrite'       => [ 'slug' => 'guest-room' ],
        'supports'      => [ 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ],
        'menu_icon'     => 'dashicons-welcome-learn-more',
        'show_in_rest'  => true,
    ] );

    // Figures / Characters
    register_post_type( 'figure', [
        'labels' => [
            'name'          => __( 'Figures', 'visio' ),
            'singular_name' => __( 'Figure', 'visio' ),
            'add_new_item'  => __( 'Add Figure', 'visio' ),
        ],
        'public'       => true,
        'has_archive'  => true,
        'rewrite'      => [ 'slug' => 'figures' ],
        'supports'     => [ 'title', 'editor', 'thumbnail', 'custom-fields' ],
        'menu_icon'    => 'dashicons-groups',
        'show_in_rest' => true,
    ] );
}
add_action( 'init', 'visio_register_cpts' );

/* ─── CUSTOM TAXONOMIES ─────────────────────────────────────────── */
function visio_register_taxonomies() {

    // Monthly Theme (for posts)
    register_taxonomy( 'monthly_theme', 'post', [
        'labels' => [
            'name'          => __( 'Monthly Themes', 'visio' ),
            'singular_name' => __( 'Monthly Theme', 'visio' ),
            'search_items'  => __( 'Search Themes', 'visio' ),
            'all_items'     => __( 'All Themes', 'visio' ),
            'edit_item'     => __( 'Edit Theme', 'visio' ),
            'add_new_item'  => __( 'Add Theme', 'visio' ),
        ],
        'hierarchical'  => true,
        'rewrite'       => [ 'slug' => 'tema' ],
        'show_in_rest'  => true,
        'show_admin_column' => true,
    ] );

    // Character Tags (e.g. lead & supporting characters)
    register_taxonomy( 'character', 'post', [
        'labels' => [
            'name'          => __( 'Characters', 'visio' ),
            'singular_name' => __( 'Character', 'visio' ),
            'search_items'  => __( 'Search Characters', 'visio' ),
            'all_items'     => __( 'All Characters', 'visio' ),
            'add_new_item'  => __( 'Add Character', 'visio' ),
        ],
        'hierarchical'  => false,
        'rewrite'       => [ 'slug' => 'character' ],
        'show_in_rest'  => true,
        'show_admin_column' => true,
    ] );

    // Guest Room Type (Video, Article, Testimony)
    register_taxonomy( 'guest_room_type', 'guest_room', [
        'labels' => [
            'name'          => __( 'Content Types', 'visio' ),
            'singular_name' => __( 'Content Type', 'visio' ),
            'add_new_item'  => __( 'Add Type', 'visio' ),
        ],
        'hierarchical' => true,
        'rewrite'      => [ 'slug' => 'guest-room-type' ],
        'show_in_rest' => true,
    ] );
}
add_action( 'init', 'visio_register_taxonomies' );

/* ─── WIDGETS / SIDEBARS ────────────────────────────────────────── */
function visio_widgets_init() {
    register_sidebar( [
        'name'          => __( 'Devotional Sidebar', 'visio' ),
        'id'            => 'sidebar-1',
        'description'   => __( 'Sidebar shown alongside devotional posts and pages.', 'visio' ),
        'before_widget' => '<div class="widget" id="%1$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ] );
    register_sidebar( [
        'name'          => __( 'Footer Widget Area', 'visio' ),
        'id'            => 'footer-1',
        'description'   => __( 'Widgets placed in the footer.', 'visio' ),
        'before_widget' => '<div class="widget footer-widget" id="%1$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4>',
        'after_title'   => '</h4>',
    ] );
}
add_action( 'widgets_init', 'visio_widgets_init' );

/* ─── CUSTOM WIDGET: DEVOTIONAL CALENDAR ───────────────────────── */
class Visio_Calendar_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'visio_calendar_widget',
            __( 'Visio Divina: Devotional Calendar', 'visio' ),
            [ 'description' => __( 'Interactive devotional calendar for the sidebar.', 'visio' ) ]
        );
    }

    public function widget( $args, $instance ) {
        echo $args['before_widget'];
        echo '<h3 class="widget-title">📅 ' . __( 'Devotional Calendar', 'visio' ) . '</h3>';
        echo '<div class="widget-content"><div class="visio-calendar" id="visio-cal-widget"></div></div>';
        echo $args['after_widget'];
    }
}

/* ─── CUSTOM WIDGET: MONTHLY THEME INDEX ───────────────────────── */
class Visio_Theme_Index_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'visio_theme_index',
            __( 'Visio Divina: Monthly Theme Index', 'visio' ),
            [ 'description' => __( 'Displays clickable monthly theme list.', 'visio' ) ]
        );
    }

    public function widget( $args, $instance ) {
        $themes = get_terms( [ 'taxonomy' => 'monthly_theme', 'hide_empty' => false ] );
        if ( empty( $themes ) || is_wp_error( $themes ) ) return;

        echo $args['before_widget'];
        echo '<h3 class="widget-title">📌 ' . __( 'Monthly Theme Index', 'visio' ) . '</h3>';
        echo '<div class="widget-content"><div class="theme-index-list">';

        $colors = [ '#2a4a8a','#b8920a','#1a6a30','#c06010','#6a1a8a','#8a1a1a','#1a6a6a','#3a6bc8','#d4a80e','#2e5ba8','#4a7acc','#1a3060' ];
        $i = 0;
        foreach ( $themes as $term ) {
            $color = $colors[ $i % count( $colors ) ];
            $count = $term->count;
            echo '<a href="' . esc_url( get_term_link( $term ) ) . '" class="theme-index-item">';
            echo '<span class="theme-dot" style="background:' . esc_attr( $color ) . '"></span>';
            echo '<span class="theme-name">' . esc_html( $term->name ) . '</span>';
            echo '<span class="theme-count-lbl">' . $count . ' ' . esc_html__( 'days', 'visio' ) . '</span>';
            echo '</a>';
            $i++;
        }
        echo '</div></div>';
        echo $args['after_widget'];
    }
}

/* ─── CUSTOM WIDGET: RECENT DEVOTIONALS ─────────────────────────── */
class Visio_Recent_Devotionals_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'visio_recent_devotionals',
            __( 'Visio Divina: Recent Devotionals', 'visio' ),
            [ 'description' => __( 'Shows recent devotional posts with date badge.', 'visio' ) ]
        );
    }

    public function widget( $args, $instance ) {
        $count = isset( $instance['count'] ) ? (int) $instance['count'] : 5;
        $posts = get_posts( [ 'numberposts' => $count, 'post_status' => 'publish' ] );
        if ( empty( $posts ) ) return;

        echo $args['before_widget'];
        echo '<h3 class="widget-title">🕊 ' . __( 'Recent Devotionals', 'visio' ) . '</h3>';
        echo '<div class="widget-content">';

        $months_en = [ 1=>'Jan',2=>'Feb',3=>'Mar',4=>'Apr',5=>'May',6=>'Jun',7=>'Jul',8=>'Aug',9=>'Sep',10=>'Oct',11=>'Nov',12=>'Dec' ];

        foreach ( $posts as $post ) {
            $day = get_the_date( 'j', $post );
            $mon = $months_en[ (int) get_the_date( 'n', $post ) ];
            $theme_terms = wp_get_post_terms( $post->ID, 'monthly_theme' );
            $theme_name  = ! empty( $theme_terms ) ? $theme_terms[0]->name : '';

            echo '<a href="' . esc_url( get_permalink( $post ) ) . '" class="recent-post-item">';
            echo '<div class="rp-date-badge"><div class="rp-day">' . esc_html( $day ) . '</div><div class="rp-month">' . esc_html( $mon ) . '</div></div>';
            echo '<div><div class="recent-post-title">' . esc_html( get_the_title( $post ) ) . '</div>';
            if ( $theme_name ) echo '<div class="recent-post-theme">' . esc_html( $theme_name ) . '</div>';
            echo '</div></a>';
        }
        echo '</div>';
        echo $args['after_widget'];
    }

    public function form( $instance ) {
        $count = isset( $instance['count'] ) ? (int) $instance['count'] : 5;
        echo '<p><label for="' . $this->get_field_id('count') . '">' . __('Number of posts:', 'visio') . '</label>';
        echo '<input class="widefat" id="' . $this->get_field_id('count') . '" name="' . $this->get_field_name('count') . '" type="number" min="1" max="20" value="' . $count . '"></p>';
    }

    public function update( $new_instance, $old_instance ) {
        $instance = [];
        $instance['count'] = min( 20, max( 1, (int) $new_instance['count'] ) );
        return $instance;
    }
}

function visio_register_widgets() {
    register_widget( 'Visio_Calendar_Widget' );
    register_widget( 'Visio_Theme_Index_Widget' );
    register_widget( 'Visio_Recent_Devotionals_Widget' );
}
add_action( 'widgets_init', 'visio_register_widgets' );

/* ─── EXCERPT ────────────────────────────────────────────────────── */
function visio_excerpt_length( $length ) { return 28; }
add_filter( 'excerpt_length', 'visio_excerpt_length' );

function visio_excerpt_more( $more ) { return '…'; }
add_filter( 'excerpt_more', 'visio_excerpt_more' );

/* ─── BODY CLASSES ───────────────────────────────────────────────── */
function visio_body_classes( $classes ) {
    if ( is_singular() ) $classes[] = 'single-post-view';
    if ( is_front_page() ) $classes[] = 'front-page';
    return $classes;
}
add_filter( 'body_class', 'visio_body_classes' );

/* ─── TITLE TAG ──────────────────────────────────────────────────── */
function visio_wp_title( $title, $sep ) {
    if ( is_feed() ) return $title;
    global $paged, $page;
    if ( is_home() || is_front_page() ) {
        $site_name = get_bloginfo( 'name' );
        $site_desc = get_bloginfo( 'description', 'display' );
        if ( $site_desc && is_front_page() ) $title = "$site_name $sep $site_desc";
        return $title;
    }
    $title .= get_bloginfo( 'name', 'display' );
    $site_desc = get_bloginfo( 'description', 'display' );
    if ( $site_desc && ( is_home() || is_front_page() ) ) $title .= " $sep $site_desc";
    if ( $paged >= 2 || $page >= 2 ) $title .= " $sep " . sprintf( __( 'Page %s', 'visio' ), max( $paged, $page ) );
    return $title;
}
add_filter( 'wp_title', 'visio_wp_title', 10, 2 );

/* ─── HELPER: CHARACTER TAGS ─────────────────────────────────────── */
function visio_character_tags( $post_id = null ) {
    if ( ! $post_id ) $post_id = get_the_ID();
    $chars = wp_get_post_terms( $post_id, 'character' );
    if ( empty( $chars ) || is_wp_error( $chars ) ) return '';
    $output = '';
    foreach ( $chars as $char ) {
        $slug  = sanitize_html_class( $char->slug );
        $output .= '<span class="char-tag char-' . $slug . '">' . esc_html( $char->name ) . '</span> ';
    }
    return $output;
}

/* ─── HELPER: ACF KEY VERSE ──────────────────────────────────────── */
function visio_key_verse() {
    if ( function_exists( 'get_field' ) ) {
        $verse = get_field( 'key_verse' );
        $ref   = get_field( 'verse_reference' );
        if ( $verse ) {
            echo '<blockquote class="entry-verse">';
            echo '"' . esc_html( $verse ) . '"';
            if ( $ref ) echo '<cite>' . esc_html( $ref ) . '</cite>';
            echo '</blockquote>';
        }
    }
}

/* ─── HELPER: ACTIVITY BOX ───────────────────────────────────────── */
function visio_activity_box() {
    if ( function_exists( 'get_field' ) ) {
        $challenge   = get_field( 'activity_challenge' );
        $reflection  = get_field( 'reflection_questions' );
        $prayer      = get_field( 'closing_prayer' );
        if ( $challenge || $reflection || $prayer ) {
            echo '<div class="activity-box">';
            echo '<div class="activity-box-label">✨ ' . __( 'Activity & Reflection', 'visio' ) . '</div>';
            if ( $challenge ) {
                echo '<h4>' . __( "Today's Challenge", 'visio' ) . '</h4>';
                echo '<p>' . wp_kses_post( $challenge ) . '</p>';
            }
            if ( $reflection ) {
                echo '<p><strong>' . __( 'Reflection Questions:', 'visio' ) . '</strong></p>';
                echo wp_kses_post( $reflection );
            }
            if ( $prayer ) {
                echo '<div class="activity-prayer">🙏 <em>' . wp_kses_post( $prayer ) . '</em></div>';
            }
            echo '</div>';
        }
    }
}

/* ─── ACF FIELD GROUPS (if ACF active) ─────────────────────────── */
function visio_register_acf_fields() {
    if ( ! function_exists( 'acf_add_local_field_group' ) ) return;

    acf_add_local_field_group( [
        'key'    => 'group_devotional_meta',
        'title'  => 'Devotional Metadata',
        'fields' => [
            [ 'key'=>'field_key_verse',       'label'=>'Key Verse (Text)',       'name'=>'key_verse',           'type'=>'textarea', 'rows'=>3 ],
            [ 'key'=>'field_verse_reference', 'label'=>'Verse Reference',        'name'=>'verse_reference',     'type'=>'text'  ],
            [ 'key'=>'field_illustration',    'label'=>'Mid-Story Illustration', 'name'=>'mid_illustration',    'type'=>'image', 'return_format'=>'array' ],
            [ 'key'=>'field_challenge',       'label'=>'Activity / Challenge',   'name'=>'activity_challenge',  'type'=>'wysiwyg', 'toolbar'=>'basic', 'media_upload'=>0 ],
            [ 'key'=>'field_reflection',      'label'=>'Reflection Questions',   'name'=>'reflection_questions','type'=>'wysiwyg', 'toolbar'=>'basic', 'media_upload'=>0 ],
            [ 'key'=>'field_prayer',          'label'=>'Closing Prayer',         'name'=>'closing_prayer',      'type'=>'textarea','rows'=>4 ],
        ],
        'location' => [ [ [ 'param'=>'post_type','operator'=>'==','value'=>'post' ] ] ],
        'position' => 'normal',
    ] );

    acf_add_local_field_group( [
        'key'    => 'group_figure_meta',
        'title'  => 'Figure Details',
        'fields' => [
            [ 'key'=>'field_figure_role',   'label'=>'Role / Description', 'name'=>'figure_role',  'type'=>'text' ],
            [ 'key'=>'field_figure_emoji',  'label'=>'Emoji / Icon',       'name'=>'figure_emoji', 'type'=>'text' ],
            [ 'key'=>'field_figure_color',  'label'=>'Card Gradient',      'name'=>'figure_color', 'type'=>'text', 'placeholder'=>'linear-gradient(135deg,#dce8f8,#faf0c8)' ],
            [ 'key'=>'field_figure_count',  'label'=>'Appearances Count',  'name'=>'figure_count', 'type'=>'text', 'placeholder'=>'e.g. Appears in 280+ devotionals' ],
        ],
        'location' => [ [ [ 'param'=>'post_type','operator'=>'==','value'=>'figure' ] ] ],
    ] );

    acf_add_local_field_group( [
        'key'    => 'group_guest_meta',
        'title'  => 'Guest Room Details',
        'fields' => [
            [ 'key'=>'field_guest_speaker', 'label'=>'Speaker / Author', 'name'=>'guest_speaker', 'type'=>'text' ],
            [ 'key'=>'field_guest_hashtags','label'=>'Hashtags (comma separated)','name'=>'guest_hashtags','type'=>'text' ],
        ],
        'location' => [ [ [ 'param'=>'post_type','operator'=>'==','value'=>'guest_room' ] ] ],
    ] );
}
add_action( 'acf/init', 'visio_register_acf_fields' );

/* ─── CONTRIBUTOR AUTH & SUBMISSION ─────────────────────────────── */

/** Force new registrations to Contributor role */
add_filter( 'pre_option_default_role', function() { return 'contributor'; } );

/** Keep contributors out of wp-admin */
function visio_redirect_contributors() {
    if ( is_admin() && ! current_user_can( 'edit_others_posts' ) && ! ( defined('DOING_AJAX') && DOING_AJAX ) ) {
        $page = visio_get_page_by_template( 'page-contributor-dashboard.php' );
        wp_redirect( $page ? get_permalink( $page ) : home_url('/') ); exit;
    }
}
add_action( 'admin_init', 'visio_redirect_contributors' );

/** Point login_url() to custom login page */
function visio_login_url( $url, $redirect ) {
    $page = visio_get_page_by_template( 'page-login.php' );
    if ( $page ) $url = add_query_arg( 'redirect_to', urlencode( $redirect ), get_permalink( $page ) );
    return $url;
}
add_filter( 'login_url', 'visio_login_url', 10, 2 );

/** Redirect logout to homepage */
add_action( 'wp_logout', function() { wp_redirect( home_url('/') ); exit; } );

/** Helper: find a page by its template filename */
function visio_get_page_by_template( $template ) {
    $pages = get_pages( [ 'meta_key' => '_wp_page_template', 'meta_value' => $template ] );
    return ! empty( $pages ) ? $pages[0]->ID : null;
}

/** Handle registration POST */
function visio_handle_register() {
    if ( ! isset( $_POST['visio_register_nonce'] ) || ! wp_verify_nonce( $_POST['visio_register_nonce'], 'visio_register' ) ) return;
    $username = sanitize_user( $_POST['reg_username'] ?? '' );
    $email    = sanitize_email( $_POST['reg_email'] ?? '' );
    $password = $_POST['reg_password'] ?? '';
    $fullname = sanitize_text_field( $_POST['reg_fullname'] ?? '' );
    $bio      = sanitize_textarea_field( $_POST['reg_bio'] ?? '' );
    $errors   = [];
    if ( empty( $username ) )              $errors[] = __( 'Username is required.', 'visio' );
    elseif ( username_exists( $username ) ) $errors[] = __( 'That username is already taken.', 'visio' );
    if ( ! is_email( $email ) )            $errors[] = __( 'Please enter a valid email address.', 'visio' );
    elseif ( email_exists( $email ) )       $errors[] = __( 'That email is already registered.', 'visio' );
    if ( strlen( $password ) < 8 )         $errors[] = __( 'Password must be at least 8 characters.', 'visio' );
    if ( ( $_POST['reg_password2'] ?? '' ) !== $password ) $errors[] = __( 'Password confirmation does not match.', 'visio' );
    $ref = 'reg_' . md5( $email . time() );
    if ( ! empty( $errors ) ) { set_transient( 'visio_errors_' . $ref, $errors, 60 ); wp_redirect( add_query_arg( 'ref', $ref, $_SERVER['REQUEST_URI'] ) ); exit; }
    $user_id = wp_create_user( $username, $password, $email );
    if ( is_wp_error( $user_id ) ) { set_transient( 'visio_errors_' . $ref, [ $user_id->get_error_message() ], 60 ); wp_redirect( add_query_arg( 'ref', $ref, $_SERVER['REQUEST_URI'] ) ); exit; }
    wp_update_user( [ 'ID' => $user_id, 'display_name' => $fullname ?: $username, 'description' => $bio, 'role' => 'contributor' ] );
    wp_mail( get_option('admin_email'), '[Visio Divina] New contributor: ' . $username, "Name: $fullname\nUsername: $username\nEmail: $email" );
    wp_set_current_user( $user_id ); wp_set_auth_cookie( $user_id );
    $dashboard = visio_get_page_by_template( 'page-contributor-dashboard.php' );
    wp_redirect( $dashboard ? get_permalink( $dashboard ) : home_url('/') ); exit;
}
add_action( 'init', 'visio_handle_register' );

/** Handle login POST */
function visio_handle_login() {
    if ( ! isset( $_POST['visio_login_nonce'] ) || ! wp_verify_nonce( $_POST['visio_login_nonce'], 'visio_login' ) ) return;
    $user = wp_authenticate( sanitize_user( $_POST['log_username'] ?? '' ), $_POST['log_password'] ?? '' );
    if ( is_wp_error( $user ) ) {
        $page = visio_get_page_by_template( 'page-login.php' );
        wp_redirect( add_query_arg( 'login', 'failed', $page ? get_permalink( $page ) : home_url('/') ) ); exit;
    }
    wp_set_current_user( $user->ID ); wp_set_auth_cookie( $user->ID, isset( $_POST['remember_me'] ) );
    $redirect  = esc_url_raw( $_POST['redirect_to'] ?? '' );
    $dashboard = visio_get_page_by_template( 'page-contributor-dashboard.php' );
    wp_redirect( $redirect ?: ( $dashboard ? get_permalink( $dashboard ) : home_url('/') ) ); exit;
}
add_action( 'init', 'visio_handle_login' );

/** Handle writing submission POST */
function visio_handle_submission() {
    if ( ! isset( $_POST['visio_submit_nonce'] ) || ! wp_verify_nonce( $_POST['visio_submit_nonce'], 'visio_submit' ) ) return;
    if ( ! is_user_logged_in() ) { wp_redirect( home_url('/') ); exit; }
    $title      = sanitize_text_field( $_POST['sub_title'] ?? '' );
    $content    = wp_kses_post( $_POST['sub_content'] ?? '' );
    $word_count = str_word_count( wp_strip_all_tags( $content ) );
    $errors     = [];
    if ( empty( $title ) )        $errors[] = __( 'A title is required.', 'visio' );
    if ( empty( $content ) )      $errors[] = __( 'Story content is required.', 'visio' );
    if ( $word_count > 450 )      $errors[] = sprintf( __( 'Your submission exceeds the 450-word limit (%d words).', 'visio' ), $word_count );
    $ref = 'sub_' . get_current_user_id();
    if ( ! empty( $errors ) ) { set_transient( 'visio_errors_' . $ref, $errors, 120 ); wp_redirect( add_query_arg( 'ref', $ref, $_SERVER['REQUEST_URI'] ) ); exit; }
    $post_id = wp_insert_post( [ 'post_title' => $title, 'post_content' => $content, 'post_status' => 'pending', 'post_author' => get_current_user_id() ] );
    if ( $post_id && ! is_wp_error( $post_id ) ) {
        update_post_meta( $post_id, 'key_verse',            sanitize_text_field( $_POST['sub_verse'] ?? '' ) );
        update_post_meta( $post_id, 'verse_reference',      sanitize_text_field( $_POST['sub_verse_ref'] ?? '' ) );
        update_post_meta( $post_id, 'activity_challenge',   sanitize_textarea_field( $_POST['sub_challenge'] ?? '' ) );
        update_post_meta( $post_id, 'reflection_questions', sanitize_textarea_field( $_POST['sub_reflection'] ?? '' ) );
        update_post_meta( $post_id, 'closing_prayer',       sanitize_textarea_field( $_POST['sub_prayer'] ?? '' ) );
        $theme_id = (int) ( $_POST['sub_theme'] ?? 0 );
        if ( $theme_id ) wp_set_post_terms( $post_id, [ $theme_id ], 'monthly_theme' );
        $chars = array_map( 'sanitize_text_field', (array) ( $_POST['sub_characters'] ?? [] ) );
        $char_ids = [];
        foreach ( $chars as $c ) { $t = get_term_by( 'name', $c, 'character' ); if ( $t ) $char_ids[] = $t->term_id; }
        if ( $char_ids ) wp_set_post_terms( $post_id, $char_ids, 'character' );
        $author = wp_get_current_user();
        wp_mail( get_option('admin_email'), '[Visio Divina] New submission: ' . $title, "From: {$author->display_name}\nWord count: $word_count\n\nReview: " . admin_url( 'post.php?post=' . $post_id . '&action=edit' ) );
        $dashboard = visio_get_page_by_template( 'page-contributor-dashboard.php' );
        wp_redirect( add_query_arg( 'submitted', '1', $dashboard ? get_permalink( $dashboard ) : home_url('/') ) ); exit;
    }
    wp_redirect( add_query_arg( 'ref', $ref, $_SERVER['REQUEST_URI'] ) ); exit;
}
add_action( 'init', 'visio_handle_submission' );

/* ─── FLUSH REWRITE RULES ON ACTIVATION ─────────────────────────── */
function visio_activation() {
    visio_register_cpts();
    visio_register_taxonomies();
    flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'visio_activation' );
