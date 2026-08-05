# Visio Divina — A WordPress Theme for Daily Christian Devotionals

Visio Divina is a WordPress theme built specifically for daily devotional publishers — sites that post a short reflection, verse, and prayer every day and want it to feel like reading a well-designed print devotional rather than scrolling a generic blog.

---

## Why I Built This

Devotional and family-ministry sites are a real, recurring niche, but most of them run on themes that were never designed for the format. A typical devotional post has a very specific shape — a key verse, a short story or reflection, an activity or discussion question, a closing prayer — and generic blog themes have no idea any of that structure exists. The result is devotional content jammed into a layout meant for restaurant reviews or tech blogs: no visual hierarchy for the verse, no way to tag which characters or themes a post touches, no calendar view, no easy way to browse "what did we publish on this date."

I built Visio Divina after running into this exact problem on a real devotional site. Rather than bolt fixes onto a stock theme, I built the content model first — what a devotional post actually needs — and designed the theme around it. What you're looking at is that project, generalized into a standalone, sellable template.

**About the name.** *Visio Divina* — "divine seeing" — is the visual counterpart to the ancient practice of *Lectio Divina* (prayerful reading of scripture): sitting with an image, an illustration, or a scene and letting it lead you into reflection rather than rushing past it. It's a fitting name for a theme built around illustrated devotionals, where the mid-story image and the verse are given as much visual weight as the text itself.

---

## Design Choices

**Editorial, not "blog."** The layout borrows more from print devotional books and church bulletins than from typical WordPress blog themes — generous whitespace, a serif display face for headlines, a clear hierarchy that puts the day's verse front and center instead of burying it in body text.

**Blue and gold palette.** Blue reads as calm, trustworthy, and reflective — the right mood for a slow morning read. Gold is used sparingly as an accent (rules, highlights, small ornamental touches) to add warmth without turning the design gaudy. Together they avoid both the coldness of a purely corporate blue theme and the over-brightness a lot of "family friendly" sites lean into.

**Structure as a first-class citizen, not an afterthought.** Every devotional post supports a key verse (with reference), a mid-story illustration, an activity/challenge prompt, reflection questions, and a closing prayer — all as distinct, styled blocks rather than freeform content. A publisher doesn't have to remember to format these consistently; the theme does it for them.

**A real character/figure system.** Many devotional series are built around recurring characters (kids, mentors, animals — whatever the series uses) who show up across posts. Visio Divina registers these as an actual custom post type and taxonomy, so each character gets a real profile page, and every devotional post can be tagged with which characters appear in it. It's a small thing, but it's the difference between a devotional site that feels like a series with continuity and one that feels like disconnected daily posts.

**A full archive matrix, not just a paginated blog list.** Devotional readers often want to jump back to "the one about patience from March" rather than scroll chronologically. Visio Divina ships a searchable, filterable archive table — filter by character, search by title/theme/verse — so years of daily content stay genuinely browsable instead of buried.

**Built-in contributor workflow.** Devotional content is very often written by a small rotating team or community of contributors, not one editor. Visio Divina includes front-end registration, login, and a submission dashboard with word-count limits and guideline enforcement built directly into the theme — no third-party plugin required for a publisher who wants outside writers submitting drafts for review.

---

## Why It's a Good Template

- **Solves a real, specific problem** rather than being a generic blog theme with a Bible verse font swapped in. The content types, taxonomies, and layout all map to how devotional publishing actually works.
- **Translation-ready from the ground up.** Every UI string is wrapped for WordPress's translation system (`__()` / `esc_html_e()` with a proper text domain), so a buyer can localize the whole theme without touching PHP.
- **No hard dependency on proprietary plugins.** Advanced Custom Fields is used for structured metadata where available, but the theme degrades gracefully without it — nothing breaks if ACF isn't installed.
- **Clean separation of demo content from functionality.** The character system, monthly themes, and figures all pull from real WordPress data (custom post types and taxonomies). Example content is only a fallback shown when a fresh install has no real posts yet — so what a buyer sees in the demo is exactly the system they'll be using, not a hardcoded mockup.
- **Follows WordPress coding conventions**: proper enqueueing of styles/scripts, escaped output (`esc_html`, `esc_attr`, `esc_url`), nonce-verified form handling, and theme support flags (custom logo, custom header, HTML5 markup, feed links) declared the way WordPress core expects.
- **Accessible and responsive by default** — semantic landmarks, skip links, keyboard-navigable menus, and a layout that holds up from mobile through desktop.
- **A complete site, not just a blog skin.** Contact/donations page, contributor guidelines, a guest-room section for testimonies and outside content, and full auth flows are included, so a buyer isn't left building half the site themselves after installing the theme.

---

## Tech Overview

- **Type:** Classic WordPress theme (PHP templates, no build step required to run)
- **Recommended plugins:** Advanced Custom Fields (for structured devotional metadata) — optional but recommended
- **Custom post types:** `figure` (characters), `guest_room` (guest articles/testimonies)
- **Custom taxonomies:** monthly theme, character tags, guest content type
- **Text domain:** `visio` (fully translation-ready)

---

## License

GNU General Public License v2 or later, in line with WordPress theme distribution standards.
