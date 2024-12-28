/**
 * Perfect Scrollbar
 */
'use strict';

document.addEventListener('DOMContentLoaded', function () {
    (function () {
        const vertical = document.getElementById('vertical-scroll'),
            verticals = document.querySelectorAll('.vertical-scroll'),
            horizontal = document.getElementById('horizontal-scroll'),
            horizVert = document.getElementById('both-scrollbars-scroll');

        // Vertical
        // --------------------------------------------------------------------
        if (vertical) {
            new PerfectScrollbar(vertical, {
                wheelPropagation: false
            });
        }

        // vertical scrolls
        if (verticals) {
            verticals.forEach(vertical => {
                new PerfectScrollbar(vertical, {
                    wheelPropagation: false
                });
            })
        }

        // Horizontal
        // --------------------------------------------------------------------
        if (horizontal) {
            new PerfectScrollbar(horizontal, {
                wheelPropagation: false,
                suppressScrollY: true
            });
        }

        // Both vertical and Horizontal
        // --------------------------------------------------------------------
        if (horizVert) {
            new PerfectScrollbar(horizVert, {
                wheelPropagation: false
            });
        }
    })();
});
