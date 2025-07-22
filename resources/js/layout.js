document.addEventListener("DOMContentLoaded", function () {
    // Toast auto-hide
    setTimeout(function () {
        var toast = document.getElementById("toast-success");
        if (toast) {
            toast.style.opacity = "0";
            setTimeout(function () {
                toast.remove();
            }, 300);
        }
    }, 3000);

    // Simple mobile menu toggle
    var mobileMenuBtn = document.getElementById("mobile-menu-button");
    if (mobileMenuBtn) {
        mobileMenuBtn.addEventListener("click", function () {
            const menu = document.getElementById("mobile-menu");
            menu.classList.toggle("hidden");
        });
    }

    // Update cart count - this would typically be done via AJAX or server-side
    window.updateCartCount = function (count) {
        var cartCounter = document.getElementById("cart-counter");
        if (cartCounter) {
            cartCounter.textContent = count;
        }
    };
});
