/**
 * Visio Divina — main.js
 * Calendar widget + UI interactions
 */

document.addEventListener('DOMContentLoaded', function () {

    /* ── DEVOTIONAL CALENDAR WIDGET ─────────────────────────────── */
    var calContainers = document.querySelectorAll('.visio-calendar');

    calContainers.forEach(function (container) {
        var today = new Date();
        var curYear = today.getFullYear();
        var curMonth = today.getMonth();

        var MONTHS_EN = [
            'January','February','March','April','May','June',
            'July','August','September','October','November','December'
        ];
        var DAYS_EN = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'];

        function buildCalendar(year, month) {
            var firstDay    = new Date(year, month, 1).getDay();
            var daysInMonth = new Date(year, month + 1, 0).getDate();

            var html = '<div class="cal-nav">';
            html += '<button class="cal-btn cal-prev">&#8249;</button>';
            html += '<span class="cal-month-label">' + MONTHS_EN[month] + ' ' + year + '</span>';
            html += '<button class="cal-btn cal-next">&#8250;</button>';
            html += '</div><div class="cal-grid">';

            DAYS_EN.forEach(function (d) {
                html += '<div class="cal-dayname">' + d + '</div>';
            });

            for (var i = 0; i < firstDay; i++) {
                html += '<div class="cal-day" style="pointer-events:none;"></div>';
            }

            for (var d = 1; d <= daysInMonth; d++) {
                var isToday = (d === today.getDate() && month === today.getMonth() && year === today.getFullYear());
                var isPast  = (year < today.getFullYear()) ||
                              (year === today.getFullYear() && month < today.getMonth()) ||
                              (year === today.getFullYear() && month === today.getMonth() && d <= today.getDate());

                var cls = 'cal-day';
                if (isToday)       cls += ' today';
                if (isPast && !isToday) cls += ' has-post';

                html += '<div class="' + cls + '" data-day="' + d + '">' + d + '</div>';
            }
            html += '</div>';
            container.innerHTML = html;

            // Nav buttons
            container.querySelector('.cal-prev').addEventListener('click', function () {
                curMonth--;
                if (curMonth < 0) { curMonth = 11; curYear--; }
                buildCalendar(curYear, curMonth);
            });
            container.querySelector('.cal-next').addEventListener('click', function () {
                curMonth++;
                if (curMonth > 11) { curMonth = 0; curYear++; }
                buildCalendar(curYear, curMonth);
            });

            // Day clicks — navigate to date archive
            container.querySelectorAll('.cal-day[data-day]').forEach(function (dayEl) {
                dayEl.addEventListener('click', function () {
                    var day   = this.dataset.day;
                    var dStr  = String(day).padStart(2,'0');
                    var mStr  = String(curMonth + 1).padStart(2,'0');
                    var yStr  = String(curYear);
                    // Navigate to WP date archive: /YYYY/MM/DD/
                    window.location.href = '/' + yStr + '/' + mStr + '/' + dStr + '/';
                });
            });
        }

        buildCalendar(curYear, curMonth);
    });

    /* ── MOBILE NAV ── */
    var toggle = document.getElementById('nav-toggle');
    var nav    = document.getElementById('site-navigation');
    if (toggle && nav) {
        toggle.addEventListener('click', function () {
            nav.classList.toggle('open');
            toggle.classList.toggle('open');
            var expanded = nav.classList.contains('open');
            toggle.setAttribute('aria-expanded', expanded);
        });
        
        // Close menu when clicking outside header
        document.addEventListener('click', function(e) {
            if (!e.target.closest('#masthead')) {
                nav.classList.remove('open');
                toggle.classList.remove('open');
                toggle.setAttribute('aria-expanded', 'false');
            }
        });
        
        // Close menu when clicking on a menu link
        var links = nav.querySelectorAll('a');
        links.forEach(function(link) {
            link.addEventListener('click', function() {
                nav.classList.remove('open');
                toggle.classList.remove('open');
                toggle.setAttribute('aria-expanded', 'false');
            });
        });
    }

    /* ── MOBILE SEARCH TOGGLE ── */
    var searchToggle = document.getElementById('search-toggle');
    var headerActions = document.getElementById('header-actions');
    if (searchToggle && headerActions) {
        searchToggle.addEventListener('click', function () {
            headerActions.classList.toggle('open');
            searchToggle.classList.toggle('open');
            var expanded = headerActions.classList.contains('open');
            searchToggle.setAttribute('aria-expanded', expanded);
            if (expanded) {
                // Focus the search input when opened
                var searchInput = headerActions.querySelector('.search-field');
                if (searchInput) {
                    setTimeout(function() { searchInput.focus(); }, 100);
                }
            }
        });
        
        // Close search when clicking outside header
        document.addEventListener('click', function(e) {
            if (!e.target.closest('#masthead')) {
                headerActions.classList.remove('open');
                searchToggle.classList.remove('open');
                searchToggle.setAttribute('aria-expanded', 'false');
            }
        });
        
        // Close search when form is submitted
        var searchForm = headerActions.querySelector('.header-search-form');
        if (searchForm) {
            searchForm.addEventListener('submit', function() {
                headerActions.classList.remove('open');
                searchToggle.classList.remove('open');
                searchToggle.setAttribute('aria-expanded', 'false');
            });
        }
    }

    /* ── SMOOTH SCROLL FOR ANCHOR LINKS ─────────────────────────── */
    document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
        anchor.addEventListener('click', function (e) {
            var target = document.querySelector(this.getAttribute('href'));
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

    /* ── LAZY FADE-IN FOR CARDS ─────────────────────────────────── */
    if ('IntersectionObserver' in window) {
        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.post-card, .figure-card, .guest-card, .archive-card').forEach(function (el) {
            el.style.opacity = '0';
            el.style.transform = 'translateY(16px)';
            el.style.transition = 'opacity .4s ease, transform .4s ease';
            observer.observe(el);
        });
    }
});
