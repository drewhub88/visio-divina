<?php
/**
 * Template Name: Devotional Archive (Archive Matrix)
 * Description: Full searchable archive table of all devotionals
 */
get_header(); ?>

<div class="page-hero">
    <div class="page-hero-label"><?php esc_html_e( 'Daily Devotional', 'visio' ); ?></div>
    <h1><?php esc_html_e( 'Devotional Archive', 'visio' ); ?></h1>
    <p><?php esc_html_e( 'Find devotionals by date, theme, character, or key verse', 'visio' ); ?></p>
</div>

<div class="full-width-wrap">

    <!-- Filter controls -->
    <div class="archive-controls" id="archive-controls">
        <span style="font-family:var(--font-ui);font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:var(--text-muted);"><?php esc_html_e( 'Filter:', 'visio' ); ?></span>
        <button class="archive-filter-btn active" data-filter="all"><?php esc_html_e( 'All', 'visio' ); ?></button>
        <?php
        $chars = get_terms( [ 'taxonomy' => 'character', 'hide_empty' => true ] );
        foreach ( $chars as $ch ) :
        ?>
        <button class="archive-filter-btn" data-filter="<?php echo esc_attr( $ch->slug ); ?>">
            <?php echo esc_html( $ch->name ); ?>
        </button>
        <?php endforeach; ?>
        <input type="text" class="archive-search-bar" id="archive-search"
               placeholder="<?php esc_attr_e( 'Search title, theme, verse, or character…', 'visio' ); ?>">
    </div>

    <!-- Archive Table -->
    <div class="archive-table-wrap">
        <table class="archive-table" id="archive-table">
            <thead>
                <tr>
                    <th><?php esc_html_e( 'Date', 'visio' ); ?></th>
                    <th><?php esc_html_e( 'Story Title', 'visio' ); ?></th>
                    <th><?php esc_html_e( 'Monthly Theme', 'visio' ); ?></th>
                    <th><?php esc_html_e( 'Character', 'visio' ); ?></th>
                    <th><?php esc_html_e( 'Key Verse', 'visio' ); ?></th>
                </tr>
            </thead>
            <tbody id="archive-tbody">
            <?php
            $all_posts = new WP_Query( [
                'posts_per_page' => -1,
                'post_status'    => 'publish',
                'orderby'        => 'date',
                'order'          => 'DESC',
            ] );

            $months_id = [1=>'Jan',2=>'Feb',3=>'Mar',4=>'Apr',5=>'May',6=>'Jun',7=>'Jul',8=>'Aug',9=>'Sep',10=>'Oct',11=>'Nov',12=>'Dec'];

            if ( $all_posts->have_posts() ) :
                while ( $all_posts->have_posts() ) : $all_posts->the_post();
                    $post_id    = get_the_ID();
                    $date_str   = get_the_date( 'j' ) . ' ' . $months_id[ (int) get_the_date('n') ] . ' ' . get_the_date('Y');
                    $verse_ref  = function_exists('get_field') ? get_field('verse_reference', $post_id) : '';

                    $theme_t  = wp_get_post_terms( $post_id, 'monthly_theme' );
                    $char_t   = wp_get_post_terms( $post_id, 'character' );

                    $theme_names = [];
                    foreach ( $theme_t as $t ) $theme_names[] = esc_html( $t->name );

                    $char_slugs = [];
                    foreach ( $char_t as $c ) $char_slugs[] = esc_attr( $c->slug );
            ?>
            <tr data-chars="<?php echo implode( ' ', $char_slugs ); ?>"
                data-title="<?php echo esc_attr( strtolower( get_the_title() ) ); ?>"
                data-theme="<?php echo esc_attr( strtolower( implode( ' ', $theme_names ) ) ); ?>"
                onclick="window.location='<?php the_permalink(); ?>'">
                <td style="white-space:nowrap;font-family:var(--font-ui);font-size:12px;color:var(--text-muted);">
                    <?php echo esc_html( $date_str ); ?>
                </td>
                <td class="title-cell">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </td>
                <td>
                    <?php foreach ( $theme_t as $t ) : ?>
                    <a href="<?php echo esc_url( get_term_link( $t ) ); ?>" class="entry-theme">
                        <?php echo esc_html( $t->name ); ?>
                    </a>
                    <?php endforeach; ?>
                </td>
                <td><?php echo visio_character_tags( $post_id ); ?></td>
                <td class="archive-verse"><?php echo esc_html( $verse_ref ); ?></td>
            </tr>
            <?php
                endwhile;
                wp_reset_postdata();
            endif;
            ?>
            </tbody>
        </table>
    </div>

</div>

<script>
(function() {
    var filterBtns = document.querySelectorAll('.archive-filter-btn');
    var searchBar  = document.getElementById('archive-search');
    var rows       = document.querySelectorAll('#archive-tbody tr');
    var activeFilter = 'all';
    var searchVal    = '';

    function applyFilters() {
        rows.forEach(function(row) {
            var chars  = row.dataset.chars || '';
            var title  = row.dataset.title || '';
            var theme  = row.dataset.theme || '';
            var matchF = (activeFilter === 'all') || chars.indexOf(activeFilter) !== -1;
            var matchS = !searchVal || title.indexOf(searchVal) !== -1 || theme.indexOf(searchVal) !== -1;
            row.style.display = (matchF && matchS) ? '' : 'none';
        });
    }

    filterBtns.forEach(function(btn) {
        btn.addEventListener('click', function() {
            filterBtns.forEach(function(b) { b.classList.remove('active'); });
            btn.classList.add('active');
            activeFilter = btn.dataset.filter;
            applyFilters();
        });
    });

    searchBar.addEventListener('input', function() {
        searchVal = this.value.trim().toLowerCase();
        applyFilters();
    });
})();
</script>

<?php get_footer(); ?>
