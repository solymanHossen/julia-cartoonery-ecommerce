export function initChatWidget($) {
  const $chatToggle = $('#chat-toggle');
  const $chatWindow = $('#chat-window');
  const $closeChat = $('#close-chat');
  const $iconMsg = $('#chat-icon-msg');
  const $iconClose = $('#chat-icon-close');
  const $chatForm = $('#chat-form');
  const $chatInput = $('#chat-input');
  const $chatMessages = $('#chat-messages');

  const toggleChat = () => {
    $chatWindow.toggleClass('hidden flex');
    $iconMsg.toggleClass('hidden');
    $iconClose.toggleClass('hidden');
  };

  if ($chatToggle.length) $chatToggle.on('click', toggleChat);
  if ($closeChat.length) $closeChat.on('click', toggleChat);

  if ($chatForm.length) {
    $chatForm.on('submit', function (e) {
      e.preventDefault();

      const text = $chatInput.val().trim();
      if (!text) return;

      const userMsgHtml = `
                <div class="flex justify-end">
                    <div class="px-4 py-2 rounded-2xl max-w-[80%] text-sm shadow-sm bg-[#A8D8EA] dark:bg-sky-500 text-white rounded-br-sm">
                        ${text}
                    </div>
                </div>
            `;
      $chatMessages.append(userMsgHtml);
      $chatInput.val('');
      $chatMessages.scrollTop($chatMessages[0].scrollHeight);

      setTimeout(() => {
        const botMsgHtml = `
                    <div class="flex justify-start">
                        <div class="px-4 py-2 rounded-2xl max-w-[80%] text-sm shadow-sm bg-white dark:bg-slate-700 text-gray-800 dark:text-gray-200 border border-gray-100 dark:border-slate-600 rounded-bl-sm">
                            Thanks for your message! This is a demo, but our team will get back to you soon.
                        </div>
                    </div>
                `;
        $chatMessages.append(botMsgHtml);
        $chatMessages.scrollTop($chatMessages[0].scrollHeight);
      }, 1000);
    });
  }
}