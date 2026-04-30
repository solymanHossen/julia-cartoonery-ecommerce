// কম্পোনেন্টগুলো ইমপোর্ট করা হলো
import { initChatWidget } from './components/chat.js';
import { initHeader } from './components/header.js';
import { initTheme } from './components/theme.js';

(function ($) {
  "use strict";

  $(document).ready(function () {
    initHeader($);
    initTheme($);
    initChatWidget($);

  });

})(jQuery);