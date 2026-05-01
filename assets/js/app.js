function e(e){let t=e(`#chat-toggle`),n=e(`#chat-window`),r=e(`#close-chat`),i=e(`#chat-icon-msg`),a=e(`#chat-icon-close`),o=e(`#chat-form`),s=e(`#chat-input`),c=e(`#chat-messages`),l=()=>{n.toggleClass(`hidden flex`),i.toggleClass(`hidden`),a.toggleClass(`hidden`)};t.length&&t.on(`click`,l),r.length&&r.on(`click`,l),o.length&&o.on(`submit`,function(e){e.preventDefault();let t=s.val().trim();if(!t)return;let n=`
                <div class="flex justify-end">
                    <div class="px-4 py-2 rounded-2xl max-w-[80%] text-sm shadow-sm bg-[#A8D8EA] dark:bg-sky-500 text-white rounded-br-sm">
                        ${t}
                    </div>
                </div>
            `;c.append(n),s.val(``),c.scrollTop(c[0].scrollHeight),setTimeout(()=>{c.append(`
                    <div class="flex justify-start">
                        <div class="px-4 py-2 rounded-2xl max-w-[80%] text-sm shadow-sm bg-white dark:bg-slate-700 text-gray-800 dark:text-gray-200 border border-gray-100 dark:border-slate-600 rounded-bl-sm">
                            Thanks for your message! This is a demo, but our team will get back to you soon.
                        </div>
                    </div>
                `),c.scrollTop(c[0].scrollHeight)},1e3)})}function t(e){let t=e(`#mobile-drawer`),n=e(`#drawer-content`);e(`#mobile-menu-open`).on(`click`,function(){t.removeClass(`opacity-0 pointer-events-none`),n.removeClass(`translate-x-full`)});let r=()=>{t.addClass(`opacity-0 pointer-events-none`),n.addClass(`translate-x-full`)};e(`#mobile-menu-close, #mobile-drawer`).on(`click`,function(t){(t.target===this||e(t.target).closest(`#mobile-menu-close`).length)&&r()})}function n(e){let t=window.matchMedia(`(prefers-color-scheme: dark)`),n=`theme`,r=e(`html`),i=e(`#theme-toggle-dark-icon`),a=e(`#theme-toggle-light-icon`),o=e(`#theme-toggle`),s=(e,t=!1)=>{let s=e===`dark`;if(r.toggleClass(`dark`,s),r.css(`color-scheme`,e),i.length&&i.toggleClass(`hidden`,s),a.length&&a.toggleClass(`hidden`,!s),o.length&&o.attr(`aria-pressed`,s),t)try{localStorage.setItem(n,e)}catch{}};r.hasClass(`dark`)?(i.length&&i.addClass(`hidden`),a.length&&a.removeClass(`hidden`),o.length&&o.attr(`aria-pressed`,`true`)):(i.length&&i.removeClass(`hidden`),a.length&&a.addClass(`hidden`),o.length&&o.attr(`aria-pressed`,`false`)),o.on(`click`,function(){s(r.hasClass(`dark`)?`light`:`dark`,!0)}),t.addEventListener&&t.addEventListener(`change`,function(){let e=null;try{e=localStorage.getItem(n)}catch{}(!e||e!==`dark`&&e!==`light`)&&s(t.matches?`dark`:`light`)})}function r(e){if(e(`.char-download-btn`).length===0)return;let t=e(`#subModal`),n=e(`#modalContent`),r=e(`#modalBackdrop`),i=e(`#closeModalBtn`),a=e(`#modalActionArea`),o=e(`#modalSuccessArea`),s=e(`#verifyBtn`),c=e(`#verifyBtnContent`),l=e(`#dynamicCharName`),u=e(`#toastNotification`),d=e(`#toastMsg`),f=!1;e(`.char-download-btn`).on(`click`,function(r){r.preventDefault();let i=e(this),u=i.data(`char-name`);i.data(`download-url`),l.text(u),t.removeClass(`opacity-0 pointer-events-none`),setTimeout(()=>{n.removeClass(`scale-90 translate-y-8`).addClass(`scale-100 translate-y-0`)},10),a.removeClass(`hidden`),o.addClass(`hidden`),s.prop(`disabled`,!1),c.html(`2. I've Subscribed - Verify & Download`)});function p(){f||(n.removeClass(`scale-100 translate-y-0`).addClass(`scale-90 translate-y-8`),setTimeout(()=>{t.addClass(`opacity-0 pointer-events-none`)},300))}i.on(`click`,p),r.on(`click`,p),s.on(`click`,function(){f||(f=!0,s.prop(`disabled`,!0),c.html(`
            <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Verifying...
        `),setTimeout(()=>{f=!1,a.addClass(`hidden`),o.removeClass(`hidden`),setTimeout(()=>{p(),m(`Downloading ${l.text()} High-Res PNG!`)},1800)},2e3))});function m(e){d.text(e),u.removeClass(`translate-y-24 opacity-0`),setTimeout(()=>{u.addClass(`translate-y-24 opacity-0`)},4e3)}}function i(e){if(e(`#playground-root`).length===0)return;let t={gamepad:`<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="6" width="20" height="12" rx="2"/><path d="M6 12h4"/><path d="M8 10v4"/><path d="M15 13h.01"/><path d="M18 11h.01"/></svg>`,brain:`<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9.5 2A2.5 2.5 0 0 1 12 4.5v15a2.5 2.5 0 0 1-4.96.44 2.5 2.5 0 0 1-2.96-3.08 3 3 0 0 1-.34-5.58 2.5 2.5 0 0 1 1.32-4.24 2.5 2.5 0 0 1 1.98-3A2.5 2.5 0 0 1 9.5 2Z"/><path d="M14.5 2A2.5 2.5 0 0 0 12 4.5v15a2.5 2.5 0 0 0 4.96.44 2.5 2.5 0 0 0 2.96-3.08 3 3 0 0 0 .34-5.58 2.5 2.5 0 0 0-1.32-4.24 2.5 2.5 0 0 0-1.98-3A2.5 2.5 0 0 0 14.5 2Z"/></svg>`,mouse:`<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 9 5 12 1.774-5.226L21 14 9 9z"/><path d="m16.071 16.071 4.243 4.243"/><path d="m7.188 2.239.776 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656-2.12 2.122"/></svg>`,wind:`<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.7 7.7a2.5 2.5 0 1 1 1.8 4.3H2"/><path d="M9.6 4.6A2 2 0 1 1 11 8H2"/><path d="M12.6 19.4A2 2 0 1 0 14 16H2"/></svg>`,arrowLeft:`<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>`,timer:`<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="10" x2="14" y1="2" y2="2"/><line x1="12" x2="15" y1="14" y2="11"/><circle cx="12" cy="14" r="8"/></svg>`,trophy:`<svg xmlns="http://www.w3.org/2000/svg" width="96" height="96" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"/><path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"/><path d="M4 22h16"/><path d="M10 14.66V17c0 .55-.47.98-.97 1.21C7.85 18.75 7 20.24 7 22"/><path d="M14 14.66V17c0 .55.47.98.97 1.21C16.15 18.75 17 20.24 17 22"/><path d="M18 2H6v7a6 6 0 0 0 12 0V2Z"/></svg>`},n=[{img:`https://api.dicebear.com/7.x/fun-emoji/svg?seed=Felix`},{img:`https://api.dicebear.com/7.x/fun-emoji/svg?seed=Aneka`},{img:`https://api.dicebear.com/7.x/fun-emoji/svg?seed=Buster`}],r=[{img:`https://api.dicebear.com/7.x/bottts/svg?seed=Robot1`},{img:`https://api.dicebear.com/7.x/bottts/svg?seed=Robot2`},{img:`https://api.dicebear.com/7.x/bottts/svg?seed=Robot3`}];({activeGame:null,score:0,timeLeft:0,timerInterval:null,gameLoopInterval:null,animationFrameId:null,init(){this.renderLobby()},clearTimers(){this.timerInterval&&clearInterval(this.timerInterval),this.gameLoopInterval&&clearInterval(this.gameLoopInterval),this.animationFrameId&&cancelAnimationFrame(this.animationFrameId)},backButton(){return`
              <button id="back-to-lobby" class="group w-fit inline-flex items-center gap-2 mb-8 px-5 py-2.5 -ml-5 text-gray-500 dark:text-gray-400 font-bold rounded-full hover:bg-pink-50 dark:hover:bg-slate-800 hover:text-[#FF9CB0] dark:hover:text-pink-400 transition-all duration-300 active:scale-95">
                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="transition-transform duration-300 group-hover:-translate-x-1.5">
                      <path d="m15 18-6-6 6-6"/>
                  </svg>
                  Back to Playground
              </button>
          `},renderLobby(){this.clearTimers(),this.activeGame=null;let n=`
              <div class="container mx-auto px-4 lg:px-8 py-12 animate-in fade-in">
                  <div class="text-center mb-16">
                      <div class="w-24 h-24 bg-gradient-to-br from-purple-300 to-pink-300 dark:from-purple-900/50 dark:to-pink-900/50 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg border-4 border-white dark:border-slate-800">
                          <span class="text-white">${t.gamepad}</span>
                      </div>
                      <h1 class="font-['Bubblegum_Sans'] text-5xl md:text-6xl text-gray-800 dark:text-gray-100 mb-4">The Playground</h1>
                      <p class="text-xl text-gray-500 dark:text-gray-400">Choose a fun mini-game to play!</p>
                  </div>
                  <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                      
                      <!-- Memory Match -->
                      <div data-game="memory" class="game-start-card cursor-pointer flex flex-col items-center p-8 text-center bg-gradient-to-b from-blue-50 to-white dark:from-sky-900/20 dark:to-slate-800 rounded-[40px] shadow-sm hover:shadow-xl transition-all border-2 border-transparent hover:border-[#A8D8EA] dark:hover:border-sky-500 group">
                          <div class="w-20 h-20 bg-[#A8D8EA] dark:bg-sky-500 rounded-2xl flex items-center justify-center text-white mb-6 transform group-hover:rotate-12 transition-transform shadow-md">
                              ${t.brain}
                          </div>
                          <h3 class="font-['Bubblegum_Sans'] text-2xl text-gray-800 dark:text-gray-100 mb-2">Memory Match</h3>
                          <p class="text-gray-500 dark:text-gray-400 mb-6 text-sm">Find all the matching pairs of toys and characters!</p>
                          <button class="mt-auto px-6 py-3 w-full rounded-full font-bold transition-colors bg-slate-900 text-white hover:bg-slate-800 dark:bg-slate-700 dark:hover:bg-slate-600">Play Now</button>
                      </div>

                      <!-- Catch Ollie -->
                      <div data-game="catch" class="game-start-card cursor-pointer flex flex-col items-center p-8 text-center bg-gradient-to-b from-green-50 to-white dark:from-emerald-900/20 dark:to-slate-800 rounded-[40px] shadow-sm hover:shadow-xl transition-all border-2 border-transparent hover:border-[#B5EAD7] dark:hover:border-emerald-500 group">
                          <div class="w-20 h-20 bg-[#B5EAD7] dark:bg-emerald-500 rounded-2xl flex items-center justify-center text-white mb-6 transform group-hover:-rotate-12 transition-transform shadow-md">
                              ${t.mouse}
                          </div>
                          <h3 class="font-['Bubblegum_Sans'] text-2xl text-gray-800 dark:text-gray-100 mb-2">Catch Ollie</h3>
                          <p class="text-gray-500 dark:text-gray-400 mb-6 text-sm">Be quick! Catch Ollie the bear before he hides again.</p>
                          <button class="mt-auto px-6 py-3 w-full rounded-full font-bold transition-colors bg-[#B5EAD7] hover:bg-emerald-300 dark:bg-emerald-500 dark:hover:bg-emerald-600 text-emerald-900 dark:text-white">Play Now</button>
                      </div>

                      <!-- Balloon Pop -->
                      <div data-game="balloon" class="game-start-card cursor-pointer flex flex-col items-center p-8 text-center bg-gradient-to-b from-pink-50 to-white dark:from-pink-900/20 dark:to-slate-800 rounded-[40px] shadow-sm hover:shadow-xl transition-all border-2 border-transparent hover:border-[#FFB7C5] dark:hover:border-pink-500 group">
                          <div class="w-20 h-20 bg-[#FFB7C5] dark:bg-pink-500 rounded-2xl flex items-center justify-center text-white mb-6 transform group-hover:scale-110 transition-transform shadow-md">
                              ${t.wind}
                          </div>
                          <h3 class="font-['Bubblegum_Sans'] text-2xl text-gray-800 dark:text-gray-100 mb-2">Balloon Pop</h3>
                          <p class="text-gray-500 dark:text-gray-400 mb-6 text-sm">Pop as many floating colorful balloons as you can!</p>
                          <button class="mt-auto px-6 py-3 w-full rounded-full font-bold transition-colors bg-pink-500 hover:bg-pink-600 text-white">Play Now</button>
                      </div>

                  </div>
              </div>
          `;e(`#playground-root`).html(n),this.bindLobbyEvents()},bindLobbyEvents(){e(`.game-start-card`).on(`click`,t=>{let n=e(t.currentTarget).data(`game`);n===`memory`&&this.startMemoryGame(),n===`catch`&&this.startCatchGame(),n===`balloon`&&this.startBalloonGame()})},startMemoryGame(){this.activeGame=`memory`,this.score=0,this.matchedPairs=0,this.flippedCards=[],this.isBoardLocked=!1;let i=[{id:`c1`,img:n[0].img},{id:`c2`,img:n[1].img},{id:`c3`,img:n[2].img},{id:`p1`,img:r[0].img},{id:`p2`,img:r[1].img},{id:`p3`,img:r[2].img}];this.memoryCards=[...i,...i].sort(()=>Math.random()-.5).map((e,t)=>({...e,uniqueId:t,matched:!1}));let a=`
              <div class="container mx-auto px-4 py-8 animate-in fade-in">
                  ${this.backButton()}
                  <div class="max-w-2xl mx-auto bg-white dark:bg-slate-800 rounded-[40px] p-8 shadow-xl border border-gray-100 dark:border-slate-700">
                      <div class="flex justify-between items-center mb-8 border-b dark:border-slate-700 pb-4">
                          <h2 class="font-['Bubblegum_Sans'] text-3xl text-gray-800 dark:text-gray-100 flex items-center gap-2">
                              <span class="text-[#A8D8EA] w-8 h-8">${t.brain}</span> Memory Match
                          </h2>
                          <span class="font-bold text-gray-600 dark:text-gray-300">Moves: <span id="memory-moves" class="text-[#A8D8EA] dark:text-sky-400 text-xl">0</span></span>
                      </div>
                      
                      <div id="memory-win-screen" class="hidden text-center py-20 animate-in zoom-in">
                          <div class="text-yellow-400 mx-auto mb-6 animate-bounce w-24 h-24 flex justify-center items-center">${t.trophy}</div>
                          <h2 class="font-['Bubblegum_Sans'] text-4xl text-[#FFB7C5] dark:text-pink-400 mb-4">You Won!</h2>
                          <p class="text-gray-500 dark:text-gray-300 mb-8">Great job matching all the cards in <span id="final-moves"></span> moves!</p>
                          <div class="flex justify-center gap-4">
                              <button id="memory-replay" class="px-6 py-3 bg-slate-900 hover:bg-slate-800 text-white font-bold rounded-full transition-colors">Play Again</button>
                              <button id="memory-exit" class="px-6 py-3 border-2 border-slate-200 dark:border-slate-600 hover:bg-slate-50 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 font-bold rounded-full transition-colors">Exit Game</button>
                          </div>
                      </div>

                      <div id="memory-grid" class="grid grid-cols-3 sm:grid-cols-4 gap-4 perspective-1000">
                          ${this.memoryCards.map(e=>`
                              <div class="memory-card relative aspect-square cursor-pointer transform-style-3d transition-transform duration-500" data-idx="${e.uniqueId}" data-id="${e.id}">
                                  <div class="card-front absolute inset-0 bg-gradient-to-br from-[#A8D8EA] to-blue-200 dark:from-sky-600 dark:to-blue-800 rounded-2xl flex items-center justify-center shadow-sm backface-hidden">
                                      <span class="font-['Bubblegum_Sans'] text-white text-4xl opacity-50">?</span>
                                  </div>
                                  <div class="card-back absolute inset-0 bg-gray-50 dark:bg-slate-700 rounded-2xl overflow-hidden flex items-center justify-center shadow-sm backface-hidden rotate-y-180 hidden">
                                      <img src="${e.img}" class="w-full h-full object-cover mix-blend-multiply dark:mix-blend-normal p-2" alt="card" />
                                  </div>
                              </div>
                          `).join(``)}
                      </div>
                  </div>
              </div>
          `;e(`#playground-root`).html(a),e(`#back-to-lobby, #memory-exit`).on(`click`,()=>this.renderLobby()),e(`#memory-replay`).on(`click`,()=>this.startMemoryGame()),e(`.memory-card`).on(`click`,t=>{if(this.isBoardLocked)return;let n=e(t.currentTarget);n.hasClass(`flipped`)||n.hasClass(`matched`)||this.flipCard(n)})},flipCard(t){t.addClass(`flipped`).css(`transform`,`rotateY(180deg)`),t.find(`.card-front`).addClass(`hidden`),t.find(`.card-back`).removeClass(`hidden`),this.flippedCards.push(t),this.flippedCards.length===2&&(this.isBoardLocked=!0,this.score++,e(`#memory-moves`).text(this.score),this.checkMemoryMatch())},checkMemoryMatch(){let t=this.flippedCards[0],n=this.flippedCards[1];t.data(`id`)===n.data(`id`)?(this.matchedPairs++,t.addClass(`matched`),n.addClass(`matched`),this.flippedCards=[],this.isBoardLocked=!1,this.matchedPairs===6&&setTimeout(()=>{e(`#memory-grid`).addClass(`hidden`),e(`#memory-win-screen`).removeClass(`hidden`),e(`#final-moves`).text(this.score)},500)):setTimeout(()=>{t.removeClass(`flipped`).css(`transform`,``),t.find(`.card-front`).removeClass(`hidden`),t.find(`.card-back`).addClass(`hidden`),n.removeClass(`flipped`).css(`transform`,``),n.find(`.card-front`).removeClass(`hidden`),n.find(`.card-back`).addClass(`hidden`),this.flippedCards=[],this.isBoardLocked=!1},1e3)},startCatchGame(){this.activeGame=`catch`,this.score=0,this.timeLeft=30,this.isPlaying=!1;let r=`
              <div class="container mx-auto px-4 py-8 animate-in fade-in">
                  ${this.backButton()}
                  <div class="max-w-2xl mx-auto bg-white dark:bg-slate-800 rounded-[40px] p-8 shadow-xl border border-gray-100 dark:border-slate-700">
                      
                      <div class="flex justify-between items-center mb-8 border-b dark:border-slate-700 pb-4">
                          <h2 class="font-['Bubblegum_Sans'] text-3xl text-gray-800 dark:text-gray-100 flex items-center gap-2">
                              <span class="text-[#B5EAD7] dark:text-emerald-500 w-8 h-8">${t.mouse}</span> Catch Ollie
                          </h2>
                          <div class="flex gap-6 text-xl font-bold">
                              <span class="text-gray-600 dark:text-gray-300 flex items-center gap-1">
                                  <span id="catch-timer-icon" class="w-5 h-5">${t.timer}</span> <span id="catch-timer">30</span>s
                              </span>
                              <span class="text-[#B5EAD7] dark:text-emerald-400 text-2xl">Score: <span id="catch-score">0</span></span>
                          </div>
                      </div>

                      <div id="catch-start-screen" class="text-center py-20">
                          <div class="w-32 h-32 rounded-full overflow-hidden mx-auto mb-6 border-8 border-[#B5EAD7] dark:border-emerald-500">
                              <img src="${n[0].img}" alt="Ollie" class="w-full h-full object-cover" />
                          </div>
                          <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-4">Ready to catch Ollie?</h3>
                          <button id="catch-start-btn" class="mx-auto bg-[#B5EAD7] hover:bg-emerald-400 dark:bg-emerald-500 text-emerald-900 dark:text-white text-xl py-4 px-10 rounded-full font-bold transition-all shadow-md">Start Game</button>
                      </div>

                      <div id="catch-end-screen" class="hidden text-center py-20 animate-in zoom-in">
                          <h2 class="font-['Bubblegum_Sans'] text-5xl text-[#B5EAD7] dark:text-emerald-400 mb-4">Time's Up!</h2>
                          <p class="text-2xl text-gray-600 dark:text-gray-300 mb-8">You caught Ollie <span id="catch-final-score" class="font-bold text-3xl text-gray-800 dark:text-white">0</span> times!</p>
                          <div class="flex justify-center gap-4">
                              <button id="catch-replay" class="px-6 py-3 bg-[#B5EAD7] hover:bg-emerald-400 text-emerald-900 font-bold rounded-full transition-colors">Play Again</button>
                              <button id="catch-exit" class="px-6 py-3 border-2 border-slate-200 dark:border-slate-600 hover:bg-slate-50 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 font-bold rounded-full transition-colors">Exit Game</button>
                          </div>
                      </div>

                      <div id="catch-grid" class="hidden grid grid-cols-3 gap-4 sm:gap-6 bg-gray-100 dark:bg-slate-900 p-6 rounded-3xl">
                          ${Array(9).fill().map((e,t)=>`
                              <div class="relative aspect-square">
                                  <div class="absolute inset-x-2 bottom-0 h-1/3 bg-gray-300 dark:bg-slate-800 rounded-[100%] shadow-inner z-10"></div>
                                  <div class="hole overflow-hidden absolute inset-x-0 bottom-4 top-0 z-0">
                                      <div class="ollie-character absolute bottom-0 left-1/2 -translate-x-1/2 w-[80%] h-[80%] cursor-pointer transition-transform duration-100 ease-out origin-bottom translate-y-full" data-idx="${t}">
                                          <img src="${n[0].img}" alt="Ollie" class="w-full h-full object-cover rounded-t-full shadow-lg border-4 border-white dark:border-slate-700 bg-[#A8D8EA]" draggable="false" />
                                      </div>
                                  </div>
                              </div>
                          `).join(``)}
                      </div>
                  </div>
              </div>
          `;e(`#playground-root`).html(r),e(`#back-to-lobby, #catch-exit`).on(`click`,()=>this.renderLobby()),e(`#catch-start-btn, #catch-replay`).on(`click`,()=>this.runCatchLoop()),e(`.ollie-character`).on(`click`,t=>{if(!this.isPlaying)return;let n=e(t.currentTarget);n.hasClass(`translate-y-full`)||(this.score++,e(`#catch-score`).text(this.score),n.addClass(`translate-y-full`))})},runCatchLoop(){this.score=0,this.timeLeft=30,this.isPlaying=!0,e(`#catch-score`).text(this.score),e(`#catch-timer`).text(this.timeLeft),e(`#catch-timer-icon`).removeClass(`text-red-500 animate-pulse`),e(`#catch-start-screen, #catch-end-screen`).addClass(`hidden`),e(`#catch-grid`).removeClass(`hidden`),this.clearTimers(),this.timerInterval=setInterval(()=>{this.timeLeft--,e(`#catch-timer`).text(this.timeLeft),this.timeLeft<=5&&e(`#catch-timer-icon`).addClass(`text-red-500 animate-pulse`),this.timeLeft<=0&&(this.clearTimers(),this.isPlaying=!1,e(`#catch-grid`).addClass(`hidden`),e(`#catch-end-screen`).removeClass(`hidden`),e(`#catch-final-score`).text(this.score),e(`.ollie-character`).addClass(`translate-y-full`))},1e3),this.gameLoopInterval=setInterval(()=>{this.isPlaying&&(e(`.ollie-character`).addClass(`translate-y-full`),e(`.ollie-character[data-idx="${Math.floor(Math.random()*9)}"]`).removeClass(`translate-y-full`))},700)},startBalloonGame(){this.activeGame=`balloon`,this.score=0,this.timeLeft=30,this.isPlaying=!1,this.balloons=[];let n=`
              <div class="container mx-auto px-4 py-8 animate-in fade-in flex flex-col h-[85vh]">
                  ${this.backButton()}
                  <div class="w-full max-w-4xl mx-auto flex-grow flex flex-col bg-white dark:bg-slate-800 rounded-[40px] shadow-xl border border-gray-100 dark:border-slate-700 overflow-hidden relative">
                      
                      <div class="flex justify-between items-center p-6 lg:p-8 border-b dark:border-slate-700 relative z-10 bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm">
                          <h2 class="font-['Bubblegum_Sans'] text-3xl text-gray-800 dark:text-gray-100 flex items-center gap-2">
                              <span class="text-[#FFB7C5] dark:text-pink-500 w-8 h-8">${t.wind}</span> Balloon Pop
                          </h2>
                          <div class="flex gap-6 text-xl font-bold">
                              <span class="text-gray-600 dark:text-gray-300 flex items-center gap-1">
                                  <span id="balloon-timer-icon" class="w-5 h-5">${t.timer}</span> <span id="balloon-timer">30</span>s
                              </span>
                              <span class="text-[#FFB7C5] dark:text-pink-400 text-2xl">Score: <span id="balloon-score">0</span></span>
                          </div>
                      </div>

                      <div id="balloon-area" class="flex-grow relative overflow-hidden bg-sky-50 dark:bg-slate-900 bg-[url('https://www.transparenttextures.com/patterns/cloudy-day.png')] dark:bg-blend-multiply">
                          
                          <div id="balloon-start-screen" class="absolute inset-0 flex flex-col items-center justify-center bg-white/50 dark:bg-slate-900/50 backdrop-blur-sm z-20">
                              <div class="text-[#FFB7C5] dark:text-pink-500 mb-6 w-20 h-20">${t.wind}</div>
                              <h3 class="text-3xl font-bold text-gray-800 dark:text-gray-100 mb-6 font-['Bubblegum_Sans']">Pop the balloons before they fly away!</h3>
                              <button id="balloon-start-btn" class="bg-pink-500 hover:bg-pink-600 text-white text-xl py-4 px-10 rounded-full font-bold shadow-lg hover:scale-110 transition-transform">Start Popping!</button>
                          </div>

                          <div id="balloon-end-screen" class="hidden absolute inset-0 flex flex-col items-center justify-center bg-white/80 dark:bg-slate-900/80 backdrop-blur-md z-20 animate-in zoom-in">
                              <h2 class="font-['Bubblegum_Sans'] text-6xl text-[#FFB7C5] dark:text-pink-400 mb-4">Time's Up!</h2>
                              <p class="text-3xl text-gray-600 dark:text-gray-300 mb-8">You popped <span id="balloon-final-score" class="font-bold text-4xl text-gray-800 dark:text-white">0</span> balloons!</p>
                              <div class="flex gap-4">
                                  <button id="balloon-replay" class="bg-pink-500 hover:bg-pink-600 text-white shadow-lg text-lg px-8 py-3 rounded-full font-bold">Play Again</button>
                                  <button id="balloon-exit" class="px-8 py-3 border-2 border-slate-200 dark:border-slate-600 hover:bg-slate-50 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 font-bold rounded-full transition-colors bg-white dark:bg-slate-800">Exit Game</button>
                              </div>
                          </div>

                      </div>
                  </div>
              </div>
          `;e(`#playground-root`).html(n),e(`#back-to-lobby, #balloon-exit`).on(`click`,()=>this.renderLobby()),e(`#balloon-start-btn, #balloon-replay`).on(`click`,()=>this.runBalloonLoop())},runBalloonLoop(){this.score=0,this.timeLeft=30,this.isPlaying=!0,this.balloons=[],e(`#balloon-score`).text(this.score),e(`#balloon-timer`).text(this.timeLeft),e(`#balloon-timer-icon`).removeClass(`text-red-500 animate-pulse`),e(`#balloon-start-screen, #balloon-end-screen`).addClass(`hidden`),e(`.balloon-element`).remove(),this.clearTimers();let t=[`bg-red-400 dark:bg-red-500 shadow-red-200 dark:shadow-red-900`,`bg-blue-400 dark:bg-blue-500 shadow-blue-200 dark:shadow-blue-900`,`bg-emerald-400 dark:bg-emerald-500 shadow-green-200 dark:shadow-emerald-900`,`bg-yellow-400 dark:bg-yellow-500 shadow-yellow-200 dark:shadow-yellow-900`,`bg-purple-400 dark:bg-purple-500 shadow-purple-200 dark:shadow-purple-900`];this.gameLoopInterval=setInterval(()=>{if(!this.isPlaying)return;let n=t[Math.floor(Math.random()*t.length)],r=`balloon-`+Date.now()+Math.random(),i=Math.random()*80+10,a=Math.random()*.8+.4,o=Math.random()*.05+.02,s=Math.random()*Math.PI*2,c=e(`
                  <div id="${r}" class="balloon-element absolute w-16 h-20 rounded-[50%] ${n} cursor-pointer shadow-lg active:scale-0 transition-transform duration-75"
                       style="border-bottom-left-radius: 50%; border-bottom-right-radius: 50%; border-top-left-radius: 40%; border-top-right-radius: 40%; transform-origin: bottom center;">
                      <div class="absolute -bottom-2 left-1/2 -translate-x-1/2 w-2 h-2 ${n.split(` `)[0]} rotate-45"></div>
                      <div class="absolute top-[100%] left-1/2 -translate-x-1/2 w-px h-12 bg-white/50"></div>
                      <div class="absolute top-2 left-2 w-4 h-6 bg-white/30 rounded-full rotate-12"></div>
                  </div>
              `);c.on(`click`,()=>{this.isPlaying&&(this.score++,e(`#balloon-score`).text(this.score),c.remove(),this.balloons=this.balloons.filter(e=>e.id!==r))}),e(`#balloon-area`).append(c),this.balloons.push({id:r,el:c,x:i,y:-20,speed:a,wobbleSpeed:o,wobbleOffset:s})},800),this.timerInterval=setInterval(()=>{this.timeLeft--,e(`#balloon-timer`).text(this.timeLeft),this.timeLeft<=5&&e(`#balloon-timer-icon`).addClass(`text-red-500 animate-pulse`),this.timeLeft<=0&&(this.isPlaying=!1,this.clearTimers(),e(`#balloon-end-screen`).removeClass(`hidden`),e(`#balloon-final-score`).text(this.score))},1e3);let n=()=>{this.isPlaying&&this.balloons.length>0&&(this.balloons.forEach((e,t)=>{e.y+=e.speed,e.wobble=Math.sin(e.y*e.wobbleSpeed+e.wobbleOffset)*20,e.y>120?(e.el.remove(),this.balloons[t]=null):e.el.css({left:`calc(${e.x}% + ${e.wobble}px)`,bottom:`${e.y}%`})}),this.balloons=this.balloons.filter(e=>e!==null)),this.animationFrameId=requestAnimationFrame(n)};this.animationFrameId=requestAnimationFrame(n)}}).init()}(function(a){a(document).ready(function(){t(a),n(a),e(a),r(a),i(a)})})(jQuery);