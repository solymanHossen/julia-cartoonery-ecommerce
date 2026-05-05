var e=Object.create,t=Object.defineProperty,n=Object.getOwnPropertyDescriptor,r=Object.getOwnPropertyNames,i=Object.getPrototypeOf,a=Object.prototype.hasOwnProperty,o=(e,t)=>()=>(t||(e((t={exports:{}}).exports,t),e=null),t.exports),s=(e,i,o,s)=>{if(i&&typeof i==`object`||typeof i==`function`)for(var c=r(i),l=0,u=c.length,d;l<u;l++)d=c[l],!a.call(e,d)&&d!==o&&t(e,d,{get:(e=>i[e]).bind(null,d),enumerable:!(s=n(i,d))||s.enumerable});return e},c=(n,r,a)=>(a=n==null?{}:e(i(n)),s(r||!n||!n.__esModule?t(a,`default`,{value:n,enumerable:!0}):a,n));function l(e){let t=e(`#chat-toggle`),n=e(`#chat-window`),r=e(`#close-chat`),i=e(`#chat-icon-msg`),a=e(`#chat-icon-close`),o=e(`#chat-form`),s=e(`#chat-input`),c=e(`#chat-messages`),l=()=>{n.toggleClass(`hidden flex`),i.toggleClass(`hidden`),a.toggleClass(`hidden`)};t.length&&t.on(`click`,l),r.length&&r.on(`click`,l),o.length&&o.on(`submit`,function(e){e.preventDefault();let t=s.val().trim();if(!t)return;let n=`
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
                `),c.scrollTop(c[0].scrollHeight)},1e3)})}function u(e){let t=e(`#mobile-drawer`),n=e(`#drawer-content`);e(`#mobile-menu-open`).on(`click`,function(){t.removeClass(`opacity-0 pointer-events-none`),n.removeClass(`translate-x-full`)});let r=()=>{t.addClass(`opacity-0 pointer-events-none`),n.addClass(`translate-x-full`)};e(`#mobile-menu-close, #mobile-drawer`).on(`click`,function(t){(t.target===this||e(t.target).closest(`#mobile-menu-close`).length)&&r()})}function d(e){let t=window.matchMedia(`(prefers-color-scheme: dark)`),n=`theme`,r=e(`html`),i=e(`#theme-toggle-dark-icon`),a=e(`#theme-toggle-light-icon`),o=e(`#theme-toggle`),s=(e,t=!1)=>{let s=e===`dark`;if(r.toggleClass(`dark`,s),r.css(`color-scheme`,e),i.length&&i.toggleClass(`hidden`,s),a.length&&a.toggleClass(`hidden`,!s),o.length&&o.attr(`aria-pressed`,s),t)try{localStorage.setItem(n,e)}catch{}};r.hasClass(`dark`)?(i.length&&i.addClass(`hidden`),a.length&&a.removeClass(`hidden`),o.length&&o.attr(`aria-pressed`,`true`)):(i.length&&i.removeClass(`hidden`),a.length&&a.addClass(`hidden`),o.length&&o.attr(`aria-pressed`,`false`)),o.on(`click`,function(){s(r.hasClass(`dark`)?`light`:`dark`,!0)}),t.addEventListener&&t.addEventListener(`change`,function(){let e=null;try{e=localStorage.getItem(n)}catch{}(!e||e!==`dark`&&e!==`light`)&&s(t.matches?`dark`:`light`)})}function f(e){if(e(`.char-download-btn`).length===0)return;let t=e(`#subModal`),n=e(`#modalContent`),r=e(`#modalBackdrop`),i=e(`#closeModalBtn`),a=e(`#modalActionArea`),o=e(`#modalSuccessArea`),s=e(`#verifyBtn`),c=e(`#verifyBtnContent`),l=e(`#dynamicCharName`),u=e(`#toastNotification`),d=e(`#toastMsg`),f=!1;e(`.char-download-btn`).on(`click`,function(r){r.preventDefault();let i=e(this),u=i.data(`char-name`);i.data(`download-url`),l.text(u),t.removeClass(`opacity-0 pointer-events-none`),setTimeout(()=>{n.removeClass(`scale-90 translate-y-8`).addClass(`scale-100 translate-y-0`)},10),a.removeClass(`hidden`),o.addClass(`hidden`),s.prop(`disabled`,!1),c.html(`2. I've Subscribed - Verify & Download`)});function p(){f||(n.removeClass(`scale-100 translate-y-0`).addClass(`scale-90 translate-y-8`),setTimeout(()=>{t.addClass(`opacity-0 pointer-events-none`)},300))}i.on(`click`,p),r.on(`click`,p),s.on(`click`,function(){f||(f=!0,s.prop(`disabled`,!0),c.html(`
            <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Verifying...
        `),setTimeout(()=>{f=!1,a.addClass(`hidden`),o.removeClass(`hidden`),setTimeout(()=>{p(),m(`Downloading ${l.text()} High-Res PNG!`)},1800)},2e3))});function m(e){d.text(e),u.removeClass(`translate-y-24 opacity-0`),setTimeout(()=>{u.addClass(`translate-y-24 opacity-0`)},4e3)}}function p(e){if(e(`#playground-root`).length===0)return;let t={gamepad:`<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="6" width="20" height="12" rx="2"/><path d="M6 12h4"/><path d="M8 10v4"/><path d="M15 13h.01"/><path d="M18 11h.01"/></svg>`,brain:`<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9.5 2A2.5 2.5 0 0 1 12 4.5v15a2.5 2.5 0 0 1-4.96.44 2.5 2.5 0 0 1-2.96-3.08 3 3 0 0 1-.34-5.58 2.5 2.5 0 0 1 1.32-4.24 2.5 2.5 0 0 1 1.98-3A2.5 2.5 0 0 1 9.5 2Z"/><path d="M14.5 2A2.5 2.5 0 0 0 12 4.5v15a2.5 2.5 0 0 0 4.96.44 2.5 2.5 0 0 0 2.96-3.08 3 3 0 0 0 .34-5.58 2.5 2.5 0 0 0-1.32-4.24 2.5 2.5 0 0 0-1.98-3A2.5 2.5 0 0 0 14.5 2Z"/></svg>`,mouse:`<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 9 5 12 1.774-5.226L21 14 9 9z"/><path d="m16.071 16.071 4.243 4.243"/><path d="m7.188 2.239.776 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656-2.12 2.122"/></svg>`,wind:`<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.7 7.7a2.5 2.5 0 1 1 1.8 4.3H2"/><path d="M9.6 4.6A2 2 0 1 1 11 8H2"/><path d="M12.6 19.4A2 2 0 1 0 14 16H2"/></svg>`,arrowLeft:`<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>`,timer:`<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="10" x2="14" y1="2" y2="2"/><line x1="12" x2="15" y1="14" y2="11"/><circle cx="12" cy="14" r="8"/></svg>`,trophy:`<svg xmlns="http://www.w3.org/2000/svg" width="96" height="96" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"/><path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"/><path d="M4 22h16"/><path d="M10 14.66V17c0 .55-.47.98-.97 1.21C7.85 18.75 7 20.24 7 22"/><path d="M14 14.66V17c0 .55.47.98.97 1.21C16.15 18.75 17 20.24 17 22"/><path d="M18 2H6v7a6 6 0 0 0 12 0V2Z"/></svg>`},n=[{img:`https://api.dicebear.com/7.x/fun-emoji/svg?seed=Felix`},{img:`https://api.dicebear.com/7.x/fun-emoji/svg?seed=Aneka`},{img:`https://api.dicebear.com/7.x/fun-emoji/svg?seed=Buster`}],r=[{img:`https://api.dicebear.com/7.x/bottts/svg?seed=Robot1`},{img:`https://api.dicebear.com/7.x/bottts/svg?seed=Robot2`},{img:`https://api.dicebear.com/7.x/bottts/svg?seed=Robot3`}];({activeGame:null,score:0,timeLeft:0,timerInterval:null,gameLoopInterval:null,animationFrameId:null,init(){this.renderLobby()},clearTimers(){this.timerInterval&&clearInterval(this.timerInterval),this.gameLoopInterval&&clearInterval(this.gameLoopInterval),this.animationFrameId&&cancelAnimationFrame(this.animationFrameId)},backButton(){return`
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
                      <div data-game="memory" class="game-start-card cursor-pointer flex flex-col items-center p-8 text-center bg-gradient-to-b from-blue-50 to-white dark:from-sky-900/20 dark:to-slate-800 rounded-[40px] shadow-sm hover:shadow-[0_20px_40px_rgb(0,0,0,0.08)] dark:hover:shadow-[0_20px_40px_rgb(0,0,0,0.3)] transition-all duration-500 ease-out hover:-translate-y-2 hover:scale-[1.02] border-2 border-transparent hover:border-[#A8D8EA] dark:hover:border-sky-500 group">
                          <div class="w-20 h-20 bg-[#A8D8EA] dark:bg-sky-500 rounded-2xl flex items-center justify-center text-white mb-6 transform group-hover:rotate-12 group-hover:scale-110 transition-transform duration-500 shadow-md">
                              ${t.brain}
                          </div>
                          <h3 class="font-['Bubblegum_Sans'] text-2xl text-gray-800 dark:text-gray-100 mb-2">Memory Match</h3>
                          <p class="text-gray-500 dark:text-gray-400 mb-6 text-sm">Find all the matching pairs of toys and characters!</p>
                          <button class="mt-auto px-6 py-3 w-full rounded-full font-bold transition-colors bg-slate-900 text-white hover:bg-slate-800 dark:bg-slate-700 dark:hover:bg-slate-600">Play Now</button>
                      </div>

                      <!-- Catch Ollie -->
                      <div data-game="catch" class="game-start-card cursor-pointer flex flex-col items-center p-8 text-center bg-gradient-to-b from-green-50 to-white dark:from-emerald-900/20 dark:to-slate-800 rounded-[40px] shadow-sm hover:shadow-[0_20px_40px_rgb(0,0,0,0.08)] dark:hover:shadow-[0_20px_40px_rgb(0,0,0,0.3)] transition-all duration-500 ease-out hover:-translate-y-2 hover:scale-[1.02] border-2 border-transparent hover:border-[#B5EAD7] dark:hover:border-emerald-500 group">
                          <div class="w-20 h-20 bg-[#B5EAD7] dark:bg-emerald-500 rounded-2xl flex items-center justify-center text-white mb-6 transform group-hover:-rotate-12 group-hover:scale-110 transition-transform duration-500 shadow-md">
                              ${t.mouse}
                          </div>
                          <h3 class="font-['Bubblegum_Sans'] text-2xl text-gray-800 dark:text-gray-100 mb-2">Catch Ollie</h3>
                          <p class="text-gray-500 dark:text-gray-400 mb-6 text-sm">Be quick! Catch Ollie the bear before he hides again.</p>
                          <button class="mt-auto px-6 py-3 w-full rounded-full font-bold transition-colors bg-[#B5EAD7] hover:bg-emerald-300 dark:bg-emerald-500 dark:hover:bg-emerald-600 text-emerald-900 dark:text-white">Play Now</button>
                      </div>

                      <!-- Balloon Pop -->
                      <div data-game="balloon" class="game-start-card cursor-pointer flex flex-col items-center p-8 text-center bg-gradient-to-b from-pink-50 to-white dark:from-pink-900/20 dark:to-slate-800 rounded-[40px] shadow-sm hover:shadow-[0_20px_40px_rgb(0,0,0,0.08)] dark:hover:shadow-[0_20px_40px_rgb(0,0,0,0.3)] transition-all duration-500 ease-out hover:-translate-y-2 hover:scale-[1.02] border-2 border-transparent hover:border-[#FFB7C5] dark:hover:border-pink-500 group">
                          <div class="w-20 h-20 bg-[#FFB7C5] dark:bg-pink-500 rounded-2xl flex items-center justify-center text-white mb-6 transform group-hover:scale-110 group-hover:-translate-y-2 transition-transform duration-500 shadow-md">
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
              `);c.on(`click`,()=>{this.isPlaying&&(this.score++,e(`#balloon-score`).text(this.score),c.remove(),this.balloons=this.balloons.filter(e=>e.id!==r))}),e(`#balloon-area`).append(c),this.balloons.push({id:r,el:c,x:i,y:-20,speed:a,wobbleSpeed:o,wobbleOffset:s})},800),this.timerInterval=setInterval(()=>{this.timeLeft--,e(`#balloon-timer`).text(this.timeLeft),this.timeLeft<=5&&e(`#balloon-timer-icon`).addClass(`text-red-500 animate-pulse`),this.timeLeft<=0&&(this.isPlaying=!1,this.clearTimers(),e(`#balloon-end-screen`).removeClass(`hidden`),e(`#balloon-final-score`).text(this.score))},1e3);let n=()=>{this.isPlaying&&this.balloons.length>0&&(this.balloons.forEach((e,t)=>{e.y+=e.speed,e.wobble=Math.sin(e.y*e.wobbleSpeed+e.wobbleOffset)*20,e.y>120?(e.el.remove(),this.balloons[t]=null):e.el.css({left:`calc(${e.x}% + ${e.wobble}px)`,bottom:`${e.y}%`})}),this.balloons=this.balloons.filter(e=>e!==null)),this.animationFrameId=requestAnimationFrame(n)};this.animationFrameId=requestAnimationFrame(n)}}).init()}var m=e=>{let t=e(`#create-character-root`);if(!t.length)return;let n=e=>{let t=document.createElement(`div`);return t.textContent=e,t.innerHTML},r={prompt:``,selectedStyle:`Cute 3D 🧸`,styles:[`Cute 3D 🧸`,`Watercolor 🎨`,`Coloring Book 🖍️`,`Pixel Art 👾`,`Anime Style 🌸`],tools:[{id:`craiyon`,name:`Craiyon`,desc:`Best for fun art!`,color:`bg-gradient-to-br from-orange-400 to-red-500 shadow-orange-300`,urlTemplate:(e,t)=>`https://www.craiyon.com/?prompt=${encodeURIComponent(e+` in `+t+` style`)}`},{id:`chatgpt`,name:`ChatGPT (DALL-E)`,desc:`Super smart AI!`,color:`bg-gradient-to-br from-emerald-400 to-teal-500 shadow-emerald-300`,urlTemplate:(e,t)=>`https://chatgpt.com/?q=${encodeURIComponent(`Create a highly detailed image of: `+e+`. Must use `+t+` style.`)}`},{id:`designer`,name:`MS Designer`,desc:`Ultra high quality!`,color:`bg-gradient-to-br from-purple-500 to-indigo-600 shadow-purple-300`,urlTemplate:(e,t)=>`https://www.bing.com/images/create?q=${encodeURIComponent(e+` in `+t+` style`)}`},{id:`gemini`,name:`Gemini AI`,desc:`Google Magic!`,color:`bg-gradient-to-br from-blue-400 to-indigo-500 shadow-blue-300`,urlTemplate:(e,t)=>`https://gemini.google.com/app?q=${encodeURIComponent(`Please generate an image of: `+e+`, using a `+t+` art style.`)}`}]},i={sparkles:`<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="absolute top-6 right-10 text-white/60 w-20 h-20 animate-[spin_4s_linear_infinite]"><path d="M9.937 15.5A2 2 0 0 0 8.5 14.063l-6.135-1.582a.5.5 0 0 1 0-.962L8.5 9.936A2 2 0 0 0 9.937 8.5l1.582-6.135a.5.5 0 0 1 .963 0L14.063 8.5A2 2 0 0 0 15.5 9.937l6.135 1.581a.5.5 0 0 1 0 .964L15.5 14.063a2 2 0 0 0-1.437 1.437l-1.582 6.135a.5.5 0 0 1-.963 0z"/><path d="M20 3v4"/><path d="M22 5h-4"/><path d="M4 17v2"/><path d="M5 18H3"/></svg>`,magicWand:`<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mb-2"><path d="m15 5 4 4"/><path d="M13 7 8.7 2.7a2.41 2.41 0 0 0-3.4 0L2.7 5.3a2.41 2.41 0 0 0 0 3.4L7 13"/><path d="m8 6 2-2"/><path d="m2 22 5.5-1.5L21.1 6.9a2.41 2.41 0 0 0 0-3.4l-2.6-2.6a2.41 2.41 0 0 0-3.4 0L1.5 14.5Z"/></svg>`,cloud:`<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="white" opacity="0.1" class="absolute -left-4 top-4"><path d="M17.5 19c-2.5 0-4.5-2-4.5-4.5a4.5 4.5 0 0 1 1-2.8A5 5 0 0 0 4 12a5 5 0 0 0 5 5h8.5A2.5 2.5 0 0 0 20 14.5c0-1.2-.9-2.2-2-2.4a4.5 4.5 0 0 0-.5-8.1v.1Z"/></svg>`},a=()=>{let e=`
            <div class="max-w-5xl mx-auto bg-white dark:bg-slate-800 rounded-[50px] shadow-[0_20px_60px_-15px_rgba(0,0,0,0.1)] dark:shadow-none overflow-hidden border-4 border-white dark:border-slate-700">
                
                <!-- Magical Header -->
                <div class="bg-gradient-to-r from-[#FFB7C5] via-[#A8D8EA] to-[#B5EAD7] p-12 text-center relative overflow-hidden">
                    ${i.cloud}
                    ${i.sparkles}
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-white/30 backdrop-blur-md rounded-[30px] mb-6 rotate-12 hover:rotate-0 transition-transform duration-500 shadow-xl border-2 border-white/50">
                        <span class="text-4xl">🦄</span>
                    </div>
                    <h1 class="font-['Bubblegum_Sans'] text-5xl lg:text-6xl text-white mb-4 relative z-10 drop-shadow-md tracking-wide">Magic Character Maker</h1>
                    <p class="text-white/95 font-bold text-xl relative z-10 drop-shadow-sm">Describe your dream friend and watch AI draw it!</p>
                </div>

                <div class="p-8 lg:p-14 bg-[#fdfbf7] dark:bg-slate-900">
                    
                    <!-- Prompt Box -->
                    <div class="mb-10 relative group">
                        <label class="flex items-center gap-2 text-slate-700 dark:text-slate-200 font-black mb-4 text-2xl font-['Bubblegum_Sans'] tracking-wide">
                            <span class="text-pink-400">1.</span> Describe your character:
                        </label>
                        <div class="relative">
                            <textarea 
                                id="prompt-textarea"
                                placeholder="Example: A tiny fluffy cat wearing a superhero cape, flying through space..."
                                class="w-full p-6 text-lg rounded-[30px] bg-white dark:bg-slate-800 border-4 border-sky-100 dark:border-slate-700 focus:border-pink-300 dark:focus:border-pink-500 focus:ring-0 transition-all outline-none min-h-[140px] resize-y dark:text-white shadow-[inset_0_4px_20px_rgba(0,0,0,0.03)] focus:shadow-[0_10px_40px_-10px_rgba(255,183,197,0.4)]"
                            ></textarea>
                            <div class="absolute bottom-4 right-6 text-sm font-bold text-slate-300 dark:text-slate-600 transition-colors" id="char-counter">0 chars</div>
                        </div>
                    </div>

                    <!-- Style Selector -->
                    <div class="mb-12">
                        <label class="flex items-center gap-2 text-slate-700 dark:text-slate-200 font-black mb-4 text-2xl font-['Bubblegum_Sans'] tracking-wide">
                            <span class="text-sky-400">2.</span> Pick an art style:
                        </label>
                        <div id="styles-container" class="flex flex-wrap gap-4"></div>
                    </div>

                    <div class="h-1 bg-slate-100 dark:bg-slate-800 rounded-full w-full mb-12"></div>

                    <!-- AI Tools -->
                    <div class="mb-6">
                        <div class="flex flex-col md:flex-row items-center justify-between mb-8 gap-4">
                            <h3 class="text-2xl font-black text-slate-800 dark:text-slate-200 font-['Bubblegum_Sans'] flex items-center gap-2">
                                <span class="text-emerald-400">3.</span> Choose your Magic Engine!
                            </h3>
                            <div id="warning-container"></div>
                        </div>
                        <div id="tools-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6"></div>
                    </div>
                </div>
            </div>
        `;t.html(e)},o=()=>{let t=!r.prompt.trim(),n=r.styles.map(e=>`<button data-style="${e}" class="style-btn px-6 py-3 rounded-full font-bold transition-all duration-300 ${r.selectedStyle===e?`bg-pink-400 dark:bg-pink-500 text-white shadow-[0_10px_20px_-5px_rgba(244,114,182,0.5)] transform scale-110 -translate-y-2 border-2 border-white`:`bg-white dark:bg-slate-800 text-slate-500 dark:text-slate-300 hover:bg-pink-50 dark:hover:bg-slate-700 border-2 border-slate-100 dark:border-slate-700 hover:-translate-y-1 hover:shadow-lg`}">${e}</button>`).join(``);e(`#styles-container`).html(n);let a=r.tools.map(e=>{let n=t?`opacity-40 cursor-not-allowed filter grayscale bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700`:`bg-white dark:bg-slate-800 border-slate-100 dark:border-slate-700 hover:border-transparent hover:shadow-[0_20px_40px_-10px_rgba(0,0,0,0.1)] dark:hover:shadow-[0_20px_40px_-10px_rgba(0,0,0,0.5)] cursor-pointer hover:-translate-y-2 active:scale-95 group relative overflow-hidden`,r=t?`bg-slate-300 dark:bg-slate-600`:e.color;return`
                <button data-tool="${e.id}" ${t?`disabled`:``} aria-label="Open in ${e.name}" class="tool-btn flex flex-col items-center p-8 rounded-[40px] border-4 transition-all duration-300 ease-out ${n}">
                    <div class="w-20 h-20 rounded-full ${r} flex items-center justify-center text-white mb-6 shadow-lg group-hover:scale-110 transition-transform duration-500 ease-out border-4 border-white/20 relative z-10">
                        ${i.magicWand}
                    </div>
                    <span class="font-black text-xl text-slate-800 dark:text-white font-['Bubblegum_Sans'] tracking-wide relative z-10">${e.name}</span>
                    <span class="text-sm font-bold text-slate-400 dark:text-slate-500 mt-2 relative z-10">${e.desc}</span>
                </button>
            `}).join(``);e(`#tools-container`).html(a);let o=t?`<span class="px-4 py-2 bg-rose-100 text-rose-500 rounded-full text-sm font-bold animate-bounce inline-block border-2 border-rose-200">↑ Type something first!</span>`:`<span class="px-4 py-2 bg-emerald-100 text-emerald-600 rounded-full text-sm font-bold inline-block border-2 border-emerald-200 shadow-sm animate-pulse">Ready to magic! ✨</span>`;e(`#warning-container`).html(o)};a(),o(),e(`#prompt-textarea`).on(`input`,function(){let t=e(this).val();r.prompt=n(t);let i=e(`#char-counter`);i.text(`${t.length} chars`),t.length>150?i.addClass(`text-emerald-400`).removeClass(`text-slate-300 text-rose-400`):t.length>0?i.addClass(`text-rose-400`).removeClass(`text-slate-300 text-emerald-400`):i.addClass(`text-slate-300`).removeClass(`text-rose-400 text-emerald-400`),o()}),t.on(`click`,`.style-btn`,function(){r.selectedStyle=e(this).data(`style`);let t=e(`#prompt-textarea`);t.addClass(`scale-[1.02] shadow-[0_10px_40px_-10px_rgba(168,216,234,0.5)] border-[#A8D8EA]`),setTimeout(()=>{t.removeClass(`scale-[1.02] shadow-[0_10px_40px_-10px_rgba(168,216,234,0.5)] border-[#A8D8EA]`)},300),o()}),t.on(`click`,`.tool-btn`,function(t){if(t.preventDefault(),!r.prompt.trim())return;let n=e(this).data(`tool`),i=r.tools.find(e=>e.id===n);i&&(e(this).append(`<div class="absolute inset-0 bg-white/40 rounded-[40px] animate-ping pointer-events-none z-0"></div>`),setTimeout(()=>{let e=i.urlTemplate(r.prompt,r.selectedStyle);window.open(e,`_blank`,`noopener,noreferrer`)},400))})},h=c(o(((e,t)=>{(function(e,n){typeof t==`object`&&t.exports?t.exports=n():e.Toastify=n()})(e,function(e){var t=function(e){return new t.lib.init(e)};t.defaults={oldestFirst:!0,text:`Toastify is awesome!`,node:void 0,duration:3e3,selector:void 0,callback:function(){},destination:void 0,newWindow:!1,close:!1,gravity:`toastify-top`,positionLeft:!1,position:``,backgroundColor:``,avatar:``,className:``,stopOnFocus:!0,onClick:function(){},offset:{x:0,y:0},escapeMarkup:!0,ariaLive:`polite`,style:{background:``}},t.lib=t.prototype={toastify:`1.12.0`,constructor:t,init:function(e){return e||={},this.options={},this.toastElement=null,this.options.text=e.text||t.defaults.text,this.options.node=e.node||t.defaults.node,this.options.duration=e.duration===0?0:e.duration||t.defaults.duration,this.options.selector=e.selector||t.defaults.selector,this.options.callback=e.callback||t.defaults.callback,this.options.destination=e.destination||t.defaults.destination,this.options.newWindow=e.newWindow||t.defaults.newWindow,this.options.close=e.close||t.defaults.close,this.options.gravity=e.gravity===`bottom`?`toastify-bottom`:t.defaults.gravity,this.options.positionLeft=e.positionLeft||t.defaults.positionLeft,this.options.position=e.position||t.defaults.position,this.options.backgroundColor=e.backgroundColor||t.defaults.backgroundColor,this.options.avatar=e.avatar||t.defaults.avatar,this.options.className=e.className||t.defaults.className,this.options.stopOnFocus=e.stopOnFocus===void 0?t.defaults.stopOnFocus:e.stopOnFocus,this.options.onClick=e.onClick||t.defaults.onClick,this.options.offset=e.offset||t.defaults.offset,this.options.escapeMarkup=e.escapeMarkup===void 0?t.defaults.escapeMarkup:e.escapeMarkup,this.options.ariaLive=e.ariaLive||t.defaults.ariaLive,this.options.style=e.style||t.defaults.style,e.backgroundColor&&(this.options.style.background=e.backgroundColor),this},buildToast:function(){if(!this.options)throw`Toastify is not initialized`;var e=document.createElement(`div`);for(var t in e.className=`toastify on `+this.options.className,this.options.position?e.className+=` toastify-`+this.options.position:this.options.positionLeft===!0?(e.className+=` toastify-left`,console.warn("Property `positionLeft` will be depreciated in further versions. Please use `position` instead.")):e.className+=` toastify-right`,e.className+=` `+this.options.gravity,this.options.backgroundColor&&console.warn(`DEPRECATION NOTICE: "backgroundColor" is being deprecated. Please use the "style.background" property.`),this.options.style)e.style[t]=this.options.style[t];if(this.options.ariaLive&&e.setAttribute(`aria-live`,this.options.ariaLive),this.options.node&&this.options.node.nodeType===Node.ELEMENT_NODE)e.appendChild(this.options.node);else if(this.options.escapeMarkup?e.innerText=this.options.text:e.innerHTML=this.options.text,this.options.avatar!==``){var r=document.createElement(`img`);r.src=this.options.avatar,r.className=`toastify-avatar`,this.options.position==`left`||this.options.positionLeft===!0?e.appendChild(r):e.insertAdjacentElement(`afterbegin`,r)}if(this.options.close===!0){var i=document.createElement(`button`);i.type=`button`,i.setAttribute(`aria-label`,`Close`),i.className=`toast-close`,i.innerHTML=`&#10006;`,i.addEventListener(`click`,function(e){e.stopPropagation(),this.removeElement(this.toastElement),window.clearTimeout(this.toastElement.timeOutValue)}.bind(this));var a=window.innerWidth>0?window.innerWidth:screen.width;(this.options.position==`left`||this.options.positionLeft===!0)&&a>360?e.insertAdjacentElement(`afterbegin`,i):e.appendChild(i)}if(this.options.stopOnFocus&&this.options.duration>0){var o=this;e.addEventListener(`mouseover`,function(t){window.clearTimeout(e.timeOutValue)}),e.addEventListener(`mouseleave`,function(){e.timeOutValue=window.setTimeout(function(){o.removeElement(e)},o.options.duration)})}if(this.options.destination!==void 0&&e.addEventListener(`click`,function(e){e.stopPropagation(),this.options.newWindow===!0?window.open(this.options.destination,`_blank`):window.location=this.options.destination}.bind(this)),typeof this.options.onClick==`function`&&this.options.destination===void 0&&e.addEventListener(`click`,function(e){e.stopPropagation(),this.options.onClick()}.bind(this)),typeof this.options.offset==`object`){var s=n(`x`,this.options),c=n(`y`,this.options),l=this.options.position==`left`?s:`-`+s,u=this.options.gravity==`toastify-top`?c:`-`+c;e.style.transform=`translate(`+l+`,`+u+`)`}return e},showToast:function(){this.toastElement=this.buildToast();var e=typeof this.options.selector==`string`?document.getElementById(this.options.selector):this.options.selector instanceof HTMLElement||typeof ShadowRoot<`u`&&this.options.selector instanceof ShadowRoot?this.options.selector:document.body;if(!e)throw`Root element is not defined`;var n=t.defaults.oldestFirst?e.firstChild:e.lastChild;return e.insertBefore(this.toastElement,n),t.reposition(),this.options.duration>0&&(this.toastElement.timeOutValue=window.setTimeout(function(){this.removeElement(this.toastElement)}.bind(this),this.options.duration)),this},hideToast:function(){this.toastElement.timeOutValue&&clearTimeout(this.toastElement.timeOutValue),this.removeElement(this.toastElement)},removeElement:function(e){e.className=e.className.replace(` on`,``),window.setTimeout(function(){this.options.node&&this.options.node.parentNode&&this.options.node.parentNode.removeChild(this.options.node),e.parentNode&&e.parentNode.removeChild(e),this.options.callback.call(e),t.reposition()}.bind(this),400)}},t.reposition=function(){for(var e={top:15,bottom:15},t={top:15,bottom:15},n={top:15,bottom:15},i=document.getElementsByClassName(`toastify`),a,o=0;o<i.length;o++){a=r(i[o],`toastify-top`)===!0?`toastify-top`:`toastify-bottom`;var s=i[o].offsetHeight;a=a.substr(9,a.length-1);var c=15;(window.innerWidth>0?window.innerWidth:screen.width)<=360?(i[o].style[a]=n[a]+`px`,n[a]+=s+c):r(i[o],`toastify-left`)===!0?(i[o].style[a]=e[a]+`px`,e[a]+=s+c):(i[o].style[a]=t[a]+`px`,t[a]+=s+c)}return this};function n(e,t){return t.offset[e]?isNaN(t.offset[e])?t.offset[e]:t.offset[e]+`px`:`0px`}function r(e,t){return!e||typeof t!=`string`?!1:!!(e.className&&e.className.trim().split(/\s+/gi).indexOf(t)>-1)}return t.lib.init.prototype=t.lib,t})}))()),g=(e,t=`success`)=>{let n=3e3,r={success:{title:`Success!`,bg:`bg-emerald-500/15 dark:bg-emerald-500/20`,color:`text-emerald-600 dark:text-emerald-400`,border:`border-emerald-500/30`,glow:`bg-emerald-500/30 dark:bg-emerald-500/40`,progress:`bg-emerald-500`,icon:`<svg class="w-5 h-5 drop-shadow-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>`},error:{title:`Error!`,bg:`bg-rose-500/15 dark:bg-rose-500/20`,color:`text-rose-600 dark:text-rose-400`,border:`border-rose-500/30`,glow:`bg-rose-500/30 dark:bg-rose-500/40`,progress:`bg-rose-500`,icon:`<svg class="w-5 h-5 drop-shadow-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>`},warning:{title:`Warning!`,bg:`bg-amber-500/15 dark:bg-amber-500/20`,color:`text-amber-600 dark:text-amber-400`,border:`border-amber-500/30`,glow:`bg-amber-500/30 dark:bg-amber-500/40`,progress:`bg-amber-500`,icon:`<svg class="w-5 h-5 drop-shadow-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>`},info:{title:`Info`,bg:`bg-sky-500/15 dark:bg-sky-500/20`,color:`text-sky-600 dark:text-sky-400`,border:`border-sky-500/30`,glow:`bg-sky-500/30 dark:bg-sky-500/40`,progress:`bg-sky-500`,icon:`<svg class="w-5 h-5 drop-shadow-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>`}},i=r[t]||r.success,a=`progress-${Math.random().toString(36).substring(2,9)}`,o=document.createElement(`div`);o.className=`group w-full max-w-[340px] pointer-events-auto mt-4`,o.innerHTML=`
        <style>
            @keyframes shrink-${a} {
                from { width: 100%; }
                to { width: 0%; }
            }
            .animate-shrink-${a} {
                animation: shrink-${a} ${n}ms linear forwards;
            }
            .group:hover .animate-shrink-${a} {
                animation-play-state: paused;
            }
            .premium-toast-enter {
                animation: toast-slide-in 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
            }
            @keyframes toast-slide-in {
                0% { opacity: 0; transform: translateY(30px) scale(0.9); }
                100% { opacity: 1; transform: translateY(0) scale(1); }
            }
        </style>
        
        <div class="premium-toast-enter relative overflow-hidden flex items-center gap-4 bg-white/95 dark:bg-slate-800/95 backdrop-blur-2xl border border-slate-100/80 dark:border-slate-700/80 rounded-[28px] p-4 shadow-[0_10px_40px_-10px_rgba(15,23,42,0.1)] dark:shadow-[0_10px_40px_-10px_rgba(0,0,0,0.5)] transform transition-transform duration-300 hover:-translate-y-1 hover:shadow-[0_15px_50px_-10px_rgba(15,23,42,0.15)] dark:hover:shadow-[0_15px_50px_-10px_rgba(0,0,0,0.6)] cursor-default">
            
            <div class="absolute -left-8 -top-8 w-28 h-28 ${i.glow} blur-[36px] rounded-full pointer-events-none transition-transform duration-700 group-hover:scale-150"></div>

            <div class="flex items-center justify-center w-11 h-11 ${i.bg} ${i.color} rounded-[16px] shrink-0 shadow-[inset_0_2px_10px_rgba(255,255,255,0.4)] dark:shadow-[inset_0_2px_10px_rgba(255,255,255,0.05)] border border-white/50 dark:border-white/10 relative z-10 overflow-hidden transition-all duration-400 group-hover:rotate-12 group-hover:scale-110">
                <div class="relative z-10">
                    ${i.icon}
                </div>
            </div>

            <div class="flex flex-col relative z-10 w-full pr-6">
                <p class="text-[1rem] font-extrabold text-slate-800 dark:text-slate-100 tracking-tight leading-none mb-1 font-['Bubblegum_Sans',sans-serif]">${i.title}</p>
                <p class="text-[0.8rem] font-semibold text-slate-500 dark:text-slate-400 leading-snug">${e}</p>
            </div>

            <button type="button" class="toast-close-btn absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-700 dark:hover:text-slate-200 transition-colors duration-200 z-20 cursor-pointer focus:outline-none">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            
            <div class="absolute bottom-0 left-0 h-[4px] w-full bg-slate-100 dark:bg-slate-700/50 rounded-b-[28px] overflow-hidden">
                <div class="h-full ${i.progress} animate-shrink-${a} shadow-[0_0_12px_${i.progress}]"></div>
            </div>
        </div>
    `;let s=(0,h.default)({text:e,duration:n,gravity:`top`,position:`right`,stopOnFocus:!0,className:`premium-glass-toast-wrapper`,style:{background:`transparent`,boxShadow:`none`,padding:`0`,margin:`0 16px 0 0`,pointerEvents:`none`},escapeMarkup:!1,node:o}),c=o.querySelector(`.toast-close-btn`);c&&c.addEventListener(`click`,e=>{e.preventDefault(),e.stopPropagation(),s.hideToast()}),s.showToast()};window.showToast=g;var _=e=>{e(document).on(`click`,`.julias-wishlist-btn`,function(t){t.preventDefault(),t.stopPropagation();let n=e(this),r=n.data(`product-id`),i=n.find(`svg`);if(typeof juliasSettings>`u`||!juliasSettings.ajaxUrl){console.error(`Wishlist settings not found.`);return}n.hasClass(`is-loading`)||(n.addClass(`is-loading opacity-70 pointer-events-none`),i.addClass(`animate-pulse`),e.ajax({url:juliasSettings.ajaxUrl,type:`POST`,data:{action:`toggle_wishlist`,product_id:r,security:juliasSettings.nonce},success:function(t){if(n.removeClass(`is-loading opacity-70 pointer-events-none`),i.removeClass(`animate-pulse`),t.success){let r=t.data.is_added;n.closest(`#wishlist-drawer`).length>0?(n.closest(`li`).fadeOut(300,function(){e(this).remove(),e(`#wishlist-drawer-items ul li`).length===0&&o()}),g(`Removed from your wishlist.`,`info`)):r?(n.addClass(`text-[#FFB7C5]`),i.attr(`fill`,`currentColor`),g(`Added to your wishlist!`,`success`)):(n.removeClass(`text-[#FFB7C5]`),i.attr(`fill`,`none`),g(`Removed from your wishlist.`,`info`)),t.data.fragment&&e(`.julias-wishlist-count`).replaceWith(t.data.fragment)}else g(t.data.message||`Failed to update wishlist.`,`error`)},error:function(){n.removeClass(`is-loading opacity-70 pointer-events-none`),i.removeClass(`animate-pulse`),g(`Network error occurred.`,`error`)}}))});let t=e(`#wishlist-drawer`),n=e(`#wishlist-drawer-content`),r=e(`#wishlist-drawer-items`);function i(){t.removeClass(`opacity-0 pointer-events-none`).addClass(`opacity-100 pointer-events-auto`),n.removeClass(`translate-x-full`).addClass(`translate-x-0`),e(`body`).addClass(`overflow-hidden`),o()}function a(){t.removeClass(`opacity-100 pointer-events-auto`).addClass(`opacity-0 pointer-events-none`),n.removeClass(`translate-x-0`).addClass(`translate-x-full`),e(`body`).removeClass(`overflow-hidden`)}function o(){r.html(`<div class="flex flex-col items-center justify-center h-full text-[#FFB7C5]"><svg class="w-8 h-8 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg></div>`),e.ajax({url:juliasSettings.ajaxUrl,type:`POST`,data:{action:`get_wishlist_content`,security:juliasSettings.nonce},success:function(e){e.success&&e.data.html&&r.html(e.data.html)}})}e(`#wishlist-drawer-open`).on(`click`,function(e){e.preventDefault(),i()}),e(`#wishlist-drawer-close, #wishlist-drawer`).on(`click`,function(e){e.target===this&&a()})};(function(e){e(document).ready(function(){u(e),d(e),l(e),f(e),p(e),m(e),_(e),e(document.body).on(`added_to_cart`,function(e,t,n,r){g(`Item added to your cart.`,`success`)})})})(jQuery);