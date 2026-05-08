export function initCheckout($) {
  "use strict";

  const $form = $("form.checkout.woocommerce-checkout");
  if (!$form.length) return;

  const $body = $(document.body);
  const $orderSummary = $(".order-summary");

  const injectSkeletonStyles = () => {
    if ($('#checkout-skeleton-styles').length) return;
    const styles = `
      <style id="checkout-skeleton-styles">
        .woocommerce-checkout form.checkout .blockUI.blockOverlay {
          display: none !important;
          background: transparent !important;
        }
        .skeleton-loading {
          position: relative;
          pointer-events: none !important;
          user-select: none !important;
          overflow: hidden;
        }
        .skeleton-loading * {
          color: transparent !important;
          background-color: #e2e5e7 !important;
          border-color: #e2e5e7 !important;
          border-radius: 4px !important;
          box-shadow: none !important;
          background-image: none !important;
        }
        .skeleton-loading::before {
          content: "";
          position: absolute;
          top: 0; left: 0; right: 0; bottom: 0;
          background: linear-gradient(90deg, rgba(255,255,255,0), rgba(255,255,255,0.6), rgba(255,255,255,0));
          animation: skeleton-shimmer 1.2s infinite;
          z-index: 10;
        }
        @keyframes skeleton-shimmer {
          0% { transform: translateX(-100%); }
          100% { transform: translateX(100%); }
        }
      </style>
    `;
    $("head").append(styles);
  };

  const isLikelyInvalid = ($field) => {
    const val = ($field.val() || "").toString().trim();
    const type = ($field.attr("type") || "").toLowerCase();
    const required = $field.prop("required") || $field.attr("aria-required") === "true";

    if (!required && !val.length) return false;
    if (required && !val.length) return true;
    if (type === "email" && val.length) return !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val);
    return false;
  };

  const paintFieldState = ($field) => {
    const $row = $field.closest(".form-row");
    if (!$row.length) return;

    const invalid = isLikelyInvalid($field);
    $row.toggleClass("field-error", invalid);
    $row.toggleClass("field-valid", !invalid && ($field.val() || "").toString().trim().length > 0);
    $field.attr("aria-invalid", invalid ? "true" : "false");
  };

  const focusFirstError = () => {
    const $firstInvalid = $form.find(".woocommerce-invalid :input").first();
    if ($firstInvalid.length) {
      $firstInvalid.trigger("focus");
      $("html, body").animate({ scrollTop: Math.max(0, $firstInvalid.offset().top - 120) }, 220);
      return;
    }

    const $notice = $(".woocommerce-NoticeGroup-checkout, .woocommerce-error").first();
    if ($notice.length) {
      $("html, body").animate({ scrollTop: Math.max(0, $notice.offset().top - 120) }, 220);
    }
  };

  const setupFieldValidation = () => {
    $form.on("blur change", "input, select, textarea", function () {
      paintFieldState($(this));
    });

    $form.on("submit", function () {
      $form.find("input, select, textarea").each(function () {
        paintFieldState($(this));
      });
    });
  };

  const setupSummaryUpdateState = () => {
    $body.on("update_checkout", function () {
      $orderSummary.addClass("updating");
      $(".woocommerce-checkout-review-order-table, .woocommerce-checkout-payment").addClass("skeleton-loading");
    });

    $body.on("updated_checkout", function () {
      $orderSummary.removeClass("updating");
      $(".woocommerce-checkout-review-order-table, .woocommerce-checkout-payment").removeClass("skeleton-loading");
    });

    $body.on("checkout_error", function () {
      $orderSummary.removeClass("updating");
      $(".woocommerce-checkout-review-order-table, .woocommerce-checkout-payment").removeClass("skeleton-loading");
      focusFirstError();
    });
  };

  const setupMobileStickyPlaceOrder = () => {
    const $placeOrderWrap = $("#payment .place-order");
    const $placeOrderBtn = $("#place_order");
    if (!$placeOrderWrap.length || !$placeOrderBtn.length) return;

    const media = window.matchMedia("(max-width: 1023px)");
    let ticking = false;

    const refresh = () => {
      const enabled = media.matches;
      $placeOrderWrap.toggleClass("mobile-sticky", enabled);

      if (!enabled) {
        $placeOrderWrap.removeClass("is-visible");
        return;
      }

      const rect = $placeOrderBtn[0].getBoundingClientRect();
      const isVisible = rect.top >= 0 && rect.bottom <= window.innerHeight;
      $placeOrderWrap.toggleClass("is-visible", !isVisible);
    };

    const onScroll = () => {
      if (ticking) return;
      ticking = true;
      window.requestAnimationFrame(() => {
        refresh();
        ticking = false;
      });
    };

    $(window).on("scroll resize", onScroll);
    if (typeof media.addEventListener === "function") {
      media.addEventListener("change", refresh);
    }
    refresh();

    $body.on("updated_checkout", refresh);
  };

  injectSkeletonStyles();
  setupFieldValidation();
  setupSummaryUpdateState();
  setupMobileStickyPlaceOrder();
}