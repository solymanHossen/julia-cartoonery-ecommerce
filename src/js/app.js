import '../css/app.css';
import { initChatWidget } from './components/chat.js';
import { initHeader } from './components/header.js';
import { initTheme } from './components/theme.js';
import { initCharactersArchive } from './components/charactersArchive.js';
import { initPlaygroundGames } from './components/playgroundGames.js';
import { initCreateCharacter } from './components/createCharacter.js';
import { showToast } from './components/toast.js';
import { initWishlist } from './components/wishlist.js';
import { initSingleProduct } from './components/singleProduct.js';
import { initCart } from './components/cart.js';
import { initCheckout } from './components/checkout.js';
import { initCarousel } from './components/carousel.js';
import { initVideos } from './components/videos.js';

(function ($) {
  "use strict";

  $(document).ready(function () {
    initHeader($);
    initTheme($);
    initChatWidget($);
    initCharactersArchive($);
    initPlaygroundGames($);
    initCreateCharacter($);
    initWishlist($);
    initSingleProduct($);
    initCart($);
    initCheckout($);
    initCarousel();
    initVideos();

    // WooCommerce native trigger when an item is added to cart via AJAX
    $(document.body).on('added_to_cart', function (event, fragments, cart_hash, $button) {
      showToast("Item added to your cart.", "success");
      
      // Add visual feedback to cart button
      if ($button && $button.length) {
        const $btn = $button;
        $btn.addClass('added');
        
        // Add scale animation
        $btn.css({
          'animation': 'ping-once 0.6s ease-out'
        });
        
        // Keep the pink highlight for 2 seconds then fade
        setTimeout(() => {
          $btn.removeClass('added');
        }, 2000);
      }
    });

    // Handle product loop add-to-cart button clicks for visual feedback
    $(document.body).on('click', '.custom-premium-cart .button, .custom-premium-cart a.button', function (e) {
      const $btn = $(this);
      
      // Add loading state
      $btn.addClass('opacity-70 pointer-events-none');
      
      // Listen for added_to_cart event and restore button
      $(document.body).one('added_to_cart', function () {
        $btn.removeClass('opacity-70 pointer-events-none');
      });
      
      // Fallback: restore button after 3 seconds if event doesn't fire
      setTimeout(() => {
        $btn.removeClass('opacity-70 pointer-events-none');
      }, 3000);
    });

  });

})(jQuery);