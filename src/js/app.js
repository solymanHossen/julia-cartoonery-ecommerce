import '../css/app.css';
import { initChatWidget } from './components/chat.js';
import { initHeader } from './components/header.js';
import { initTheme } from './components/theme.js';
import { initCharactersArchive } from './components/charactersArchive.js';

(function ($) {
  "use strict";

  $(document).ready(function () {
    initHeader($);
    initTheme($);
    initChatWidget($);
    initCharactersArchive($);

  });

})(jQuery);