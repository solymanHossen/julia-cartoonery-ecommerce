/**
 * Premium Checkout Experience
 * - Step-based checkout flow
 * - Real-time form validation
 * - Auto-focus UX
 * - Guest/Login toggle
 * - Shipping cost live update
 * - Trust signals
 */

export function initCheckout($) {
  "use strict";

  const CheckoutManager = {
    currentStep: 1,
    steps: {
      1: { name: "Contact", fields: ["email", "phone"] },
      2: { name: "Shipping", fields: ["address", "city", "country", "shipping_method"] },
      3: { name: "Payment", fields: ["payment_method"] },
      4: { name: "Review", fields: [] },
    },
    validationRules: {
      email: (val) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val),
      phone: (val) => /^[\d\s\-\+\(\)]+$/.test(val) || val === "",
      address: (val) => val.trim().length >= 3,
      city: (val) => val.trim().length >= 2,
      country: (val) => val !== "",
      payment_method: (val) => val !== "",
    },

    init() {
      this.setupStepIndicator();
      this.setupFormValidation();
      this.setupGuestLoginToggle();
      this.setupShippingMethodListener();
      this.setupAutoFocus();
      this.setupTrustSignals();
      this.setupMobileOptimization();
      this.setupCouponUX();
    },

    setupStepIndicator() {
      const checkout = $(".checkout");
      if (!checkout.length) return;

      // Add step indicator
      const stepIndicator = `
        <div class="checkout-progress-bar">
          <div class="flex justify-between items-center">
            <div class="step-item active" data-step="1">
              <div class="step-circle">
                <span class="step-number">1</span>
                <span class="step-checkmark" style="display:none;">✓</span>
              </div>
              <span class="step-label">Contact</span>
            </div>
            <div class="step-connector"></div>
            <div class="step-item" data-step="2">
              <div class="step-circle">
                <span class="step-number">2</span>
                <span class="step-checkmark" style="display:none;">✓</span>
              </div>
              <span class="step-label">Shipping</span>
            </div>
            <div class="step-connector"></div>
            <div class="step-item" data-step="3">
              <div class="step-circle">
                <span class="step-number">3</span>
                <span class="step-checkmark" style="display:none;">✓</span>
              </div>
              <span class="step-label">Payment</span>
            </div>
            <div class="step-connector"></div>
            <div class="step-item" data-step="4">
              <div class="step-circle">
                <span class="step-number">4</span>
                <span class="step-checkmark" style="display:none;">✓</span>
              </div>
              <span class="step-label">Review</span>
            </div>
          </div>
        </div>
      `;
      checkout.prepend(stepIndicator);
    },

    setupFormValidation() {
      const form = $("form.checkout");

      // Real-time field validation
      form.on("change blur", "input[type='text'], input[type='email'], input[type='tel'], select", function () {
        const $field = $(this);
        const fieldName = $field.attr("name") || $field.attr("id");
        const fieldValue = $field.val();
        const fieldType = $field.attr("type") || "text";

        // Determine validation rule
        let isValid = true;
        if (fieldName.includes("email")) {
          isValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(fieldValue) || fieldValue === "";
        } else if (fieldName.includes("phone")) {
          isValid = /^[\d\s\-\+\(\)]+$/.test(fieldValue) || fieldValue === "";
        } else if (fieldName.includes("address")) {
          isValid = fieldValue.trim().length >= 3 || fieldValue === "";
        } else if (fieldName.includes("city")) {
          isValid = fieldValue.trim().length >= 2 || fieldValue === "";
        } else if (fieldName.includes("country")) {
          isValid = fieldValue !== "";
        }

        // Update field styling
        const $wrapper = $field.closest(".form-row");
        if (isValid) {
          $wrapper.removeClass("field-error").addClass("field-valid");
          $wrapper.find(".field-error-message").fadeOut(200);
        } else if (fieldValue !== "") {
          $wrapper.addClass("field-error").removeClass("field-valid");
          if (!$wrapper.find(".field-error-message").length) {
            $field.after('<span class="field-error-message text-xs text-red-500 mt-1">Please check this field</span>');
          } else {
            $wrapper.find(".field-error-message").fadeIn(200);
          }
        } else {
          $wrapper.removeClass("field-error field-valid");
          $wrapper.find(".field-error-message").fadeOut(200);
        }
      });

      // Prevent submission if form is invalid
      form.on("submit", function (e) {
        const hasErrors = form.find(".field-error").length > 0;
        if (hasErrors) {
          e.preventDefault();
          $("html, body").animate(
            { scrollTop: form.find(".field-error:first").offset().top - 200 },
            600
          );
          return false;
        }
      });
    },

    setupGuestLoginToggle() {
      const loginLink = $(".checkout-login-toggle");
      const accountFields = $(".woocommerce-account-fields");

      if (!loginLink.length) return;

      loginLink.on("click", function (e) {
        e.preventDefault();
        accountFields.slideToggle(300);
        loginLink.toggleClass("active");
      });
    },

    setupAutoFocus() {
      // Auto-focus first empty required field
      const form = $("form.checkout");
      const firstEmpty = form.find("input[required], select[required]").filter(function () {
        return $(this).val() === "";
      }).first();

      if (firstEmpty.length) {
        setTimeout(() => {
          firstEmpty.focus();
          firstEmpty.select();
        }, 500);
      }
    },

    setupShippingMethodListener() {
      $(document.body).on("change", "input[name^='shipping_method']", function () {
        // Trigger shipping method update via WooCommerce AJAX
        $("body").trigger("update_checkout");

        // Animate shipping cost update in order summary
        const orderSummary = $(".order-summary");
        orderSummary.addClass("updating");
        setTimeout(() => {
          orderSummary.removeClass("updating");
        }, 500);
      });
    },
    setupCouponUX() {
      const couponField = $("#coupon_code");
      const couponForm = couponField.closest("form");

      couponField.on("keypress", function (e) {
        if (e.which === 13) {
          e.preventDefault();
          couponForm.find("button[name='apply_coupon']").click();
        }
      });

      // Add loading state to apply button
      couponForm.on("submit", function () {
        const btn = $(this).find("button[name='apply_coupon']");
        btn.prop("disabled", true).addClass("loading");
        btn.html('<span class="inline-flex items-center gap-1"><span class="animate-spin">⟳</span> Applying...</span>');

        setTimeout(() => {
          btn.prop("disabled", false).removeClass("loading");
          btn.html("Apply");
        }, 1500);
      });
    },

    setupMobileOptimization() {
      // Sticky bottom checkout button on mobile
      const placeOrderBtn = $("#place_order");
      const placeOrderSection = placeOrderBtn.closest(".place-order");
      const isMobile = $(window).width() < 1024;

      if (isMobile && placeOrderBtn.length && placeOrderSection.length) {
        placeOrderSection.addClass("mobile-sticky");

        $(window).on("scroll", function () {
          const scrollTop = $(window).scrollTop();
          const formTop = $("form.checkout").offset().top;
          const formBottom = formTop + $("form.checkout").outerHeight();
          const windowBottom = scrollTop + $(window).height();

          if (windowBottom < formBottom - 100) {
            placeOrderSection.addClass("is-visible");
          } else {
            placeOrderSection.removeClass("is-visible");
          }
        });
      }
    },
  };

  // Initialize on document ready
  $(document).ready(function () {
    CheckoutManager.init();
  });

  // Update checkout when cart is modified
  $(document.body).on("updated_checkout", function () {
    CheckoutManager.setupAutoFocus();
  });
}
