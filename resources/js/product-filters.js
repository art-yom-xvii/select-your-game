import noUiSlider from "nouislider";

document.addEventListener("DOMContentLoaded", function () {
    // --- FILTER LOGIC ---
    function setupFilterListeners() {
        const filterCheckboxes = document.querySelectorAll(".filter-checkbox");
        const filterRadios = document.querySelectorAll(".filter-radio");
        const filterSelect = document.querySelector(".filter-select");
        const clearAllFiltersButton =
            document.getElementById("clear-all-filters");
        const clearFilterButtons = document.querySelectorAll(".clear-filter");

        let applyFilters = () => {
            const params = new URLSearchParams(window.location.search);

            // Get checkbox filters (categories, platforms)
            const selectedCategories = [];
            const selectedPlatforms = [];

            document
                .querySelectorAll(".filter-checkbox")
                .forEach((checkbox) => {
                    if (checkbox.checked) {
                        if (checkbox.dataset.filter === "categories") {
                            selectedCategories.push(checkbox.value);
                        } else if (checkbox.dataset.filter === "platforms") {
                            selectedPlatforms.push(checkbox.value);
                        }
                    }
                });

            // Update URL parameters for categories and platforms
            if (selectedCategories.length > 0) {
                params.set("categories", selectedCategories.join(","));
            } else {
                params.delete("categories");
            }

            if (selectedPlatforms.length > 0) {
                params.set("platforms", selectedPlatforms.join(","));
            } else {
                params.delete("platforms");
            }

            // Get radio filters (product type)
            filterRadios.forEach((radio) => {
                if (radio.checked) {
                    if (radio.value) {
                        params.set(radio.dataset.filter, radio.value);
                    } else {
                        params.delete(radio.dataset.filter);
                    }
                }
            });

            // Get sort value
            if (filterSelect) {
                const sortValue = filterSelect.value;
                if (sortValue) {
                    params.set("sort", sortValue);
                } else {
                    params.delete("sort");
                }
            }

            // Update URL
            const newUrl = `${window.location.pathname}?${params.toString()}`;
            sessionStorage.setItem("scrollPos", window.scrollY);
            window.location.href = newUrl;
        };

        // Remove previous listeners by cloning (to avoid double triggers)
        document.querySelectorAll(".filter-checkbox").forEach((checkbox) => {
            const newCheckbox = checkbox.cloneNode(true);
            checkbox.parentNode.replaceChild(newCheckbox, checkbox);
        });

        // Attach listeners
        document.querySelectorAll(".filter-checkbox").forEach((checkbox) => {
            checkbox.addEventListener("change", applyFilters);
        });
        filterRadios.forEach((radio) => {
            radio.addEventListener("change", applyFilters);
        });
        if (filterSelect) filterSelect.addEventListener("change", applyFilters);
    }
    setupFilterListeners();

    // --- END FILTER LOGIC ---

    // Handle collapsible categories
    const categoryToggles = document.querySelectorAll(".category-toggle");
    categoryToggles.forEach((toggle) => {
        toggle.addEventListener("click", function () {
            const categoryId = this.getAttribute("data-category-id");
            const childrenContainer = document.getElementById(
                `children-${categoryId}`
            );
            const icon = this.querySelector("svg");

            if (childrenContainer) {
                const isHidden = childrenContainer.classList.contains("hidden");

                if (isHidden) {
                    // Expand
                    childrenContainer.classList.remove("hidden");
                    icon.classList.add("rotate-90");
                    // Save state
                    localStorage.setItem(
                        `category-${categoryId}-expanded`,
                        "true"
                    );
                } else {
                    // Collapse
                    childrenContainer.classList.add("hidden");
                    icon.classList.remove("rotate-90");
                    // Save state
                    localStorage.setItem(
                        `category-${categoryId}-expanded`,
                        "false"
                    );
                }
            }
        });
        // Restore state on page load
        const categoryId = toggle.getAttribute("data-category-id");
        const childrenContainer = document.getElementById(
            `children-${categoryId}`
        );
        const icon = toggle.querySelector("svg");
        const wasExpanded =
            localStorage.getItem(`category-${categoryId}-expanded`) === "true";
        if (childrenContainer && wasExpanded) {
            childrenContainer.classList.remove("hidden");
            icon.classList.add("rotate-90");
        }
    });

    // Handle main categories section toggle
    const categoriesSectionToggle = document.querySelector(
        ".categories-section-toggle"
    );
    if (categoriesSectionToggle) {
        categoriesSectionToggle.addEventListener("click", function () {
            const content = document.querySelector(".categories-content");
            const icon = this.querySelector("svg");
            if (content) {
                const isHidden = content.classList.contains("hidden");
                if (isHidden) {
                    content.classList.remove("hidden");
                    icon.style.transform = "rotate(0deg)";
                    localStorage.setItem("categories-section-expanded", "true");
                } else {
                    content.classList.add("hidden");
                    icon.style.transform = "rotate(90deg)";
                    localStorage.setItem(
                        "categories-section-expanded",
                        "false"
                    );
                }
            }
        });
        // Restore main section state on page load
        const content = document.querySelector(".categories-content");
        const icon = categoriesSectionToggle.querySelector("svg");
        const wasExpanded =
            localStorage.getItem("categories-section-expanded") === "true";
        if (content && !wasExpanded) {
            content.classList.add("hidden");
            icon.style.transform = "rotate(90deg)";
        }
    }

    // Handle "Show more" and "Show less" for categories
    const showMoreCategoriesBtn = document.querySelector(
        ".show-more-categories-btn"
    );
    const showLessCategoriesBtn = document.querySelector(
        ".show-less-categories-btn"
    );
    const extraCategories = document.querySelector(".extra-categories");
    if (showMoreCategoriesBtn && showLessCategoriesBtn && extraCategories) {
        // On page load, restore state from localStorage
        const expanded = localStorage.getItem("categories-expanded") === "true";
        if (expanded) {
            extraCategories.classList.remove("hidden");
            showMoreCategoriesBtn.style.display = "none";
            showLessCategoriesBtn.style.display = "inline-block";
        } else {
            extraCategories.classList.add("hidden");
            showMoreCategoriesBtn.style.display = "inline-block";
            showLessCategoriesBtn.style.display = "none";
        }
        showMoreCategoriesBtn.addEventListener("click", function () {
            extraCategories.classList.remove("hidden");
            showMoreCategoriesBtn.style.display = "none";
            showLessCategoriesBtn.style.display = "inline-block";
            localStorage.setItem("categories-expanded", "true");
            setupFilterListeners();
        });
        showLessCategoriesBtn.addEventListener("click", function () {
            extraCategories.classList.add("hidden");
            showMoreCategoriesBtn.style.display = "inline-block";
            showLessCategoriesBtn.style.display = "none";
            localStorage.setItem("categories-expanded", "false");
            setupFilterListeners();
        });
    }

    // Price Range Slider
    var priceSlider = document.getElementById("price-slider");
    var priceMinInput = document.getElementById("price-min-input");
    var priceMaxInput = document.getElementById("price-max-input");
    if (priceSlider && priceMinInput && priceMaxInput && window.noUiSlider) {
        noUiSlider.create(priceSlider, {
            start: [
                parseInt(priceMinInput.value) || 0,
                parseInt(priceMaxInput.value) || 500,
            ],
            connect: true,
            range: {
                min: parseInt(priceSlider.getAttribute("data-min")) || 0,
                max: parseInt(priceSlider.getAttribute("data-max")) || 500,
            },
            step: 1,
            tooltips: false,
            format: {
                to: function (value) {
                    return Math.round(value);
                },
                from: function (value) {
                    return Number(value);
                },
            },
        });
        priceSlider.noUiSlider.on("update", function (values, handle) {
            if (handle === 0) {
                priceMinInput.value = values[0];
            } else {
                priceMaxInput.value = values[1];
            }
        });
        priceSlider.noUiSlider.on("change", function (values) {
            const params = new URLSearchParams(window.location.search);
            params.set("price_min", values[0]);
            params.set("price_max", values[1]);
            sessionStorage.setItem("scrollPos", window.scrollY);
            window.location.href = `${
                window.location.pathname
            }?${params.toString()}`;
        });
        priceMinInput.addEventListener("change", function () {
            priceSlider.noUiSlider.set([this.value, null]);
        });
        priceMaxInput.addEventListener("change", function () {
            priceSlider.noUiSlider.set([null, this.value]);
        });
    }

    // Clear All Filters Button
    const clearAllFiltersButton = document.getElementById("clear-all-filters");
    if (clearAllFiltersButton) {
        clearAllFiltersButton.addEventListener("click", function () {
            const params = new URLSearchParams(window.location.search);
            params.delete("categories");
            params.delete("platforms");
            params.delete("category"); // Remove category slug
            params.delete("platform"); // Remove platform slug
            params.delete("type");
            params.delete("sort");
            params.delete("search");
            params.delete("price_min");
            params.delete("price_max");

            // Reset price slider and inputs to dynamic min/max
            var priceSlider = document.getElementById("price-slider");
            var priceMinInput = document.getElementById("price-min-input");
            var priceMaxInput = document.getElementById("price-max-input");
            var minPrice = parseInt(priceSlider.getAttribute("data-min")) || 0;
            var maxPrice =
                parseInt(priceSlider.getAttribute("data-max")) || 500;

            if (priceSlider && priceSlider.noUiSlider) {
                priceSlider.noUiSlider.set([minPrice, maxPrice]);
            }
            if (priceMinInput) priceMinInput.value = minPrice;
            if (priceMaxInput) priceMaxInput.value = maxPrice;

            sessionStorage.setItem("scrollPos", window.scrollY);
            window.location.href = `${
                window.location.pathname
            }?${params.toString()}`;
        });
    }

    // Individual Clear Filter Buttons
    // (e.g. Clear categories, platforms, type, price)
    document.querySelectorAll(".clear-filter").forEach((button) => {
        button.addEventListener("click", function () {
            const filterType = button.dataset.filter;
            const params = new URLSearchParams(window.location.search);

            // Uncheck checkboxes or reset radio buttons based on filter type
            if (filterType === "categories") {
                document
                    .querySelectorAll(
                        '.filter-checkbox[data-filter="categories"]'
                    )
                    .forEach((checkbox) => {
                        checkbox.checked = false;
                    });
                params.delete("categories");
            } else if (filterType === "platforms") {
                document
                    .querySelectorAll(
                        '.filter-checkbox[data-filter="platforms"]'
                    )
                    .forEach((checkbox) => {
                        checkbox.checked = false;
                    });
                params.delete("platforms");
            } else if (filterType === "type") {
                document
                    .querySelectorAll('.filter-radio[data-filter="type"]')
                    .forEach((radio) => {
                        if (radio.value === "") radio.checked = true;
                    });
                params.delete("type");
            } else if (filterType === "price") {
                const priceMin = document.getElementById("price-min-input");
                const priceMax = document.getElementById("price-max-input");
                priceMin.value = 0;
                priceMax.value = 500;
                params.delete("price_min");
                params.delete("price_max");
            }

            // Update URL
            sessionStorage.setItem("scrollPos", window.scrollY);
            window.location.href = `${
                window.location.pathname
            }?${params.toString()}`;
        });
    });
});

function reorderCategoryGroups() {
    const container = document.querySelector(".categories-content");
    if (!container) return;
    const groups = Array.from(container.querySelectorAll(".category-group"));
    // Separate checked and unchecked
    const checked = [];
    const unchecked = [];
    groups.forEach((group) => {
        const checkbox = group.querySelector(
            '.filter-checkbox[data-filter="categories"]'
        );
        if (checkbox && checkbox.checked) {
            checked.push(group);
        } else {
            unchecked.push(group);
        }
    });
    // Sort unchecked by original index
    unchecked.sort((a, b) => {
        return parseInt(a.dataset.index) - parseInt(b.dataset.index);
    });
    // Re-append in order: checked first, then unchecked
    [...checked, ...unchecked].forEach((group) => container.appendChild(group));
}

// Call on page load
reorderCategoryGroups();
// Call on checkbox change
Array.from(
    document.querySelectorAll('.filter-checkbox[data-filter="categories"]')
).forEach((checkbox) => {
    checkbox.addEventListener("change", reorderCategoryGroups);
});

// Load More Products Button
const loadMoreButton = document.getElementById("load-more-products");
if (loadMoreButton) {
    let currentPage = parseInt(loadMoreButton.dataset.currentPage) || 1;
    const totalPages = parseInt(loadMoreButton.dataset.totalPages) || 1;

    loadMoreButton.addEventListener("click", function () {
        const params = new URLSearchParams(window.location.search);
        currentPage++;
        params.set("page", currentPage);

        loadMoreButton.disabled = true;
        loadMoreButton.innerHTML = "Loading...";
        loadMoreButton.classList.add("opacity-50", "cursor-not-allowed");

        fetch(`${window.location.pathname}?${params.toString()}`, {
            headers: {
                "X-Requested-With": "XMLHttpRequest",
                Accept: "application/json",
            },
        })
            .then((response) => response.json())
            .then((data) => {
                const productGrid = document.getElementById("product-grid");
                if (data && data.html) {
                    const tempDiv = document.createElement("div");
                    tempDiv.innerHTML = data.html;
                    const newProducts =
                        tempDiv.querySelectorAll(".game-card-hover");
                    newProducts.forEach((product) => {
                        product.classList.add("fade-in-product");
                        productGrid.appendChild(product);
                        void product.offsetWidth;
                        product.classList.add("visible");
                        setTimeout(
                            () =>
                                product.classList.remove(
                                    "fade-in-product",
                                    "visible"
                                ),
                            600
                        );
                    });
                    // Dispatch event to update product count
                    const totalCount = document.getElementById(
                        "product-count-container"
                    ).dataset.totalCount;
                    document.dispatchEvent(
                        new CustomEvent("products:updated", {
                            detail: {
                                visibleCount:
                                    productGrid.querySelectorAll(
                                        ".game-card-hover"
                                    ).length,
                                totalCount: totalCount,
                            },
                        })
                    );
                }
                if (
                    !data ||
                    !data.has_more ||
                    !data.html ||
                    data.html.trim() === ""
                ) {
                    loadMoreButton.remove();
                    if (!data || !data.html || data.html.trim() === "") {
                        const msg = document.createElement("div");
                        msg.className = "text-gray-500 text-center my-4";
                        msg.textContent = "No more products found.";
                        productGrid.appendChild(msg);
                    }
                } else {
                    loadMoreButton.disabled = false;
                    loadMoreButton.innerHTML = "Load More Products";
                    loadMoreButton.classList.remove(
                        "opacity-50",
                        "cursor-not-allowed"
                    );
                }
            })
            .catch((error) => {
                console.error("Error loading more products:", error);
                loadMoreButton.disabled = false;
                loadMoreButton.innerHTML = "Load More Products";
                loadMoreButton.classList.remove(
                    "opacity-50",
                    "cursor-not-allowed"
                );
            });
    });
}
