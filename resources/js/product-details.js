document.addEventListener("DOMContentLoaded", function () {
    // Product image gallery
    const thumbnailButtons = document.querySelectorAll(".thumbnail-btn");
    const mainImage = document.getElementById("mainImage");

    thumbnailButtons.forEach((button) => {
        button.addEventListener("click", function () {
            const imageUrl = this.getAttribute("data-image");
            mainImage.src = imageUrl;

            // Update active state
            thumbnailButtons.forEach((btn) =>
                btn.classList.remove("ring-2", "ring-primary")
            );
            this.classList.add("ring-2", "ring-primary");
        });
    });

    // Quantity buttons
    const minusButton = document.querySelector(".quantity-btn.minus");
    const plusButton = document.querySelector(".quantity-btn.plus");
    const quantityInput = document.getElementById("quantity");

    if (minusButton && plusButton && quantityInput) {
        minusButton.addEventListener("click", function () {
            const currentValue = parseInt(quantityInput.value);
            if (currentValue > 1) {
                quantityInput.value = currentValue - 1;
            }
        });

        plusButton.addEventListener("click", function () {
            const currentValue = parseInt(quantityInput.value);
            if (currentValue < 10) {
                quantityInput.value = currentValue + 1;
            }
        });
    }
});
