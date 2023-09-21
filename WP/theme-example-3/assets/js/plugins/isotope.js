import Isotope from 'isotope-layout';

// To use Isotope the markup must be as follows:
/*
<div class="isotope-wrapper">
    // The filter is optional
    <div class="isotope-filter">
        <div data-filter=".foo"></div>
        <div data-filter=".bar"></div>
        <div data-filter=".baz"></div>
        ...
    </div>

    // The .isotope-grid div is optional, if you do not want to
    // use the filter, but just the masonry grid.
    <div class="isotope-grid">
        <div class="isotope-item foo"></div>
        <div class="isotope-item bar"></div>
        <div class="isotope-item baz"></div>
        ...
    </div>
</div>

*/

/**
 * Arrange the items based on the location hash.
 *
 * It will look for a link with the
 * hash set as the href and uses its filter to arrange the items.
 *
 * @param {object} iso
 * @param {Element} wrapper
 * @param {NodeListOf<Element>} filters
 * @returns {boolean}
 */
function arrangeItemsToHash(iso, wrapper, filters) {
    // Look for a hash to apply the right filter, or mark the wildcard filter as active
    const filter = wrapper.querySelector('[href*="' + location.hash + '"');

    if (filter) {
        const selector = filter.getAttribute('data-filter');
        iso.arrange({filter: selector});
        filters.forEach(filter => filter.classList.remove('active'));
        filter.classList.add('active');

        return true;
    }

    return false;
}

const initIsotope = (grid) => {
    return new Isotope(grid, {
        itemSelector: '.isotope-item',
        filter: '*'
    });
};

const arrangeByFilters = (iso, filters) => {
    const filter = Array.from(filters).find(f => f.classList.contains('active'));

    // Filters according to the button with the active state
    if (filter) {
        iso.arrange({
            filter: filter.getAttribute('data-filter')
        });
    }
};

const initWrapper = wrapper => {
    let grid = wrapper.querySelector('.isotope-grid');

    // If no grid has been found the wrapper will be used for the grid container.
    // This should only be the case if no filters are used.
    if (!grid) {
        grid = wrapper;
    }

    if (grid) {
        setTimeout(() => {
            // Init the Isotope instance.
            let iso = initIsotope(grid);

            window.iso = iso;

            const filters = wrapper.querySelectorAll('.isotope-filter [data-filter]');

            for (let filter of filters) {
                filter.addEventListener('click', (e) => {
                    e.preventDefault();

                    filters.forEach(filter => filter.classList.remove('active'));
                    filter.classList.add('active');

                    iso.arrange({
                        filter: filter.getAttribute('data-filter')
                    });

                    const href = filter.getAttribute('href');

                    if (href) {
                        history.pushState({}, document.title, href);
                    }

                    return false;
                });
            }

            // At first, we try to arrange the items initially by the location hash.
            // If there is no hash set, we look for a filter with the active state.
            if (!arrangeItemsToHash(iso, wrapper, filters)) {
                arrangeByFilters(iso, filters);
            }

            if (wrapper.getAttribute('data-change-listener')) {
                const target = document.querySelector(wrapper.getAttribute('data-change-listener'));

                if (target) {
                    target.addEventListener('change', e => {
                        // Re-init isotope so it detects the new items.
                        iso = initIsotope(grid);
                        arrangeByFilters(iso, filters);
                    });
                }
            }

            window.addEventListener('hashchange', () => arrangeItemsToHash(iso, wrapper, filters));

            // Give the css a little time to get rendered when using HMR
        }, module.hot ? 500 : 10);
    }
};

// The main isotope wrappers. This is required to be set.
const wrappers = document.querySelectorAll('.isotope-wrapper');

for (let wrapper of wrappers) {
    // If the target grid is loaded async the wrapper can provide a message
    // that should be listened to, so isotope can be initialized after the
    // dom is ready. In this case a Vue-Component will post a message when it's mounted.
    const initMessage = wrapper.getAttribute('data-init-message');

    if (initMessage) {
        window.addEventListener('message', e => {
            if (e.data === initMessage) {
                initWrapper(wrapper);
            }
        });
    } else {
        initWrapper(wrapper);
    }
}
