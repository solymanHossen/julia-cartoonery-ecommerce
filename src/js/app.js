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

    // WooCommerce native trigger when an item is added to cart via AJAX
    $(document.body).on('added_to_cart', function (event, fragments, cart_hash, $button) {
      showToast("Item added to your cart.", "success");
    });

  });

})(jQuery);