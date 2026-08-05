<?php
/**
 * Template Name: Contact & Donations
 */
get_header(); ?>

<div class="page-hero">
    <div class="page-hero-label"><?php esc_html_e( 'Contact Us', 'visio' ); ?></div>
    <h1><?php esc_html_e( 'Contact & Donations', 'visio' ); ?></h1>
    <p><?php esc_html_e( 'Together we can bring light to more hearts and families', 'visio' ); ?></p>
</div>

<div class="full-width-wrap" style="max-width:900px;">

    <div class="section-heading">
        <h2><?php esc_html_e( 'How to Reach Us', 'visio' ); ?></h2>
    </div>

    <div class="contact-grid">

        <!-- WhatsApp -->
        <div class="contact-card">
            <div class="contact-card-icon">📱</div>
            <h3><?php esc_html_e( 'Editorial WhatsApp', 'visio' ); ?></h3>
            <p><?php esc_html_e( 'For manuscript submissions, content questions, or editorial partnerships, reach our team on WhatsApp.', 'visio' ); ?></p>
            <div class="contact-detail">
                <a href="https://wa.me/10000000000" target="_blank" rel="noopener" style="color:var(--blue-mid);">
                    +1 000 000 0000
                </a>
            </div>
        </div>

        <!-- Social Media -->
        <div class="contact-card">
            <div class="contact-card-icon">📸</div>
            <h3><?php esc_html_e( 'Social Media', 'visio' ); ?></h3>
            <p><?php esc_html_e( 'Follow along for the latest updates, daily content, and our Christian family community on social media.', 'visio' ); ?></p>
            <div class="social-row" style="margin-top:12px;">
                <a href="https://instagram.com/your_handle" class="social-pill" target="_blank" rel="noopener"
                   style="background:var(--blue-pale);color:var(--blue-mid);border:1px solid var(--border);">📷 Instagram</a>
                <a href="https://tiktok.com/@your_handle" class="social-pill" target="_blank" rel="noopener"
                   style="background:var(--blue-pale);color:var(--blue-mid);border:1px solid var(--border);">▶ TikTok</a>
                <a href="https://facebook.com/your_handle" class="social-pill" target="_blank" rel="noopener"
                   style="background:var(--blue-pale);color:var(--blue-mid);border:1px solid var(--border);">👤 Facebook</a>
            </div>
            <div class="contact-detail" style="font-size:13px;">@your_handle</div>
        </div>

        <!-- Donations — full width -->
        <div class="contact-card donation-card">
            <div class="contact-card-icon">🙏</div>
            <h3><?php esc_html_e( 'Support Our Ministry', 'visio' ); ?></h3>
            <p><?php esc_html_e( 'Every donation helps us bring quality devotionals, print books, and reach more families.', 'visio' ); ?></p>
            <div class="bank-details">
                <div class="bank-chip">
                    <div class="bank-chip-label"><?php esc_html_e( 'Bank', 'visio' ); ?></div>
                    Bank Name
                </div>
                <div class="bank-chip">
                    <div class="bank-chip-label"><?php esc_html_e( 'Account No.', 'visio' ); ?></div>
                    000-000-000000-0
                </div>
                <div class="bank-chip">
                    <div class="bank-chip-label"><?php esc_html_e( 'Account Holder', 'visio' ); ?></div>
                    Account Holder Name
                </div>
            </div>
            <div class="social-row">
                <button class="social-pill" onclick="copyBank(this)">📋 <?php esc_html_e( 'Copy Account Number', 'visio' ); ?></button>
            </div>
        </div>

    </div><!-- .contact-grid -->

    <!-- Page content (if any) -->
    <?php while ( have_posts() ) : the_post(); ?>
        <?php if ( get_the_content() ) : ?>
        <div class="entry-content" style="margin-top:36px;">
            <?php the_content(); ?>
        </div>
        <?php endif; ?>
    <?php endwhile; ?>

</div>

<script>
function copyBank(btn) {
    if (navigator.clipboard) {
        navigator.clipboard.writeText('0000000000000').then(function() {
            btn.textContent = '✅ Copied!';
            setTimeout(function() { btn.textContent = '📋 Copy Account Number'; }, 2500);
        });
    } else {
        btn.textContent = 'Account No.: 000-000-000000-0';
    }
}
</script>

<?php get_footer(); ?>
