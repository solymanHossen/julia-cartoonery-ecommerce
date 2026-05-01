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
        `),setTimeout(()=>{f=!1,a.addClass(`hidden`),o.removeClass(`hidden`),setTimeout(()=>{p(),m(`Downloading ${l.text()} High-Res PNG!`)},1800)},2e3))});function m(e){d.text(e),u.removeClass(`translate-y-24 opacity-0`),setTimeout(()=>{u.addClass(`translate-y-24 opacity-0`)},4e3)}}function i(e){e(`#playground-root`).length!==0&&{activeGame:null,score:0,timeLeft:0,timerInterval:null,gameLoopInterval:null,animationFrameId:null,init(){this.renderLobby()},clearTimers(){this.timerInterval&&clearInterval(this.timerInterval),this.gameLoopInterval&&clearInterval(this.gameLoopInterval),this.animationFrameId&&cancelAnimationFrame(this.animationFrameId)},renderLobby(){this.clearTimers(),this.activeGame=null;let t=`
              <div class="container mx-auto px-4 lg:px-8 py-12 animate-in fade-in">
                  <div class="text-center mb-16">
                      <div class="w-24 h-24 bg-gradient-to-br from-purple-300 to-pink-300 dark:from-purple-900/50 dark:to-pink-900/50 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg border-4 border-white dark:border-slate-800">
                          <span class="text-4xl text-white">🎮</span>
                      </div>
                      <h1 class="font-['Bubblegum_Sans'] text-5xl md:text-6xl text-gray-800 dark:text-gray-100 mb-4">The Playground</h1>
                      <p class="text-xl text-gray-500 dark:text-gray-400">Choose a fun mini-game to play!</p>
                  </div>
                  <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                      ${this.gameCard(`memory`,`Memory Match`,`🧠`,`bg-[#A8D8EA] dark:bg-sky-500`,`bg-gradient-to-b from-blue-50 to-white dark:from-sky-900/20 dark:to-slate-800 hover:border-[#A8D8EA] dark:hover:border-sky-500`,`bg-slate-900 text-white hover:bg-slate-800`)}
                      ${this.gameCard(`catch`,`Catch Ollie`,`🖱️`,`bg-[#B5EAD7] dark:bg-emerald-500`,`bg-gradient-to-b from-green-50 to-white dark:from-emerald-900/20 dark:to-slate-800 hover:border-[#B5EAD7] dark:hover:border-emerald-500`,`bg-[#B5EAD7] hover:bg-emerald-300 dark:bg-emerald-500 dark:hover:bg-emerald-600 text-emerald-900 dark:text-white`)}
                      ${this.gameCard(`balloon`,`Balloon Pop`,`🎈`,`bg-[#FFB7C5] dark:bg-pink-500`,`bg-gradient-to-b from-pink-50 to-white dark:from-pink-900/20 dark:to-slate-800 hover:border-[#FFB7C5] dark:hover:border-pink-500`,`bg-pink-500 hover:bg-pink-600 text-white`)}
                  </div>
              </div>
          `;e(`#playground-root`).html(t),this.bindLobbyEvents()},gameCard(e,t,n,r,i,a){return`
              <div data-game="${e}" class="game-start-card cursor-pointer flex flex-col items-center p-8 text-center ${i} rounded-[40px] shadow-sm hover:shadow-xl transition-all border-2 border-transparent group">
                  <div class="w-20 h-20 ${r} rounded-2xl flex items-center justify-center text-4xl mb-6 transform group-hover:rotate-12 transition-transform shadow-md">${n}</div>
                  <h3 class="font-['Bubblegum_Sans'] text-2xl text-gray-800 dark:text-gray-100 mb-2">${t}</h3>
                  <button class="mt-4 px-6 py-2 w-full rounded-full font-bold transition-colors ${a}">Play Now</button>
              </div>
          `},bindLobbyEvents(){e(`.game-start-card`).on(`click`,t=>{let n=e(t.currentTarget).data(`game`);n===`memory`&&this.startMemoryGame(),n===`catch`&&this.startCatchGame(),n===`balloon`&&this.startBalloonGame()})},startMemoryGame(){this.activeGame=`memory`,this.score=0,this.matchedPairs=0,this.flippedCards=[],this.isBoardLocked=!1;let t=[`🎈`,`🐶`,`🦄`,`🦖`,`🚗`,`🍎`];this.memoryCards=[...t,...t].sort(()=>Math.random()-.5).map((e,t)=>({id:t,icon:e,matched:!1}));let n=`
              <div class="container mx-auto px-4 py-8 animate-in fade-in">
                  <button id="back-to-lobby" class="mb-4 font-bold text-gray-500 hover:text-gray-700 dark:text-gray-400 flex items-center gap-2 px-4 py-2 bg-white/50 dark:bg-slate-800/50 rounded-full shadow-sm hover:bg-white dark:hover:bg-slate-800 transition-colors">← Back to Playground</button>
                  <div class="max-w-2xl mx-auto bg-white dark:bg-slate-800 rounded-[40px] p-8 shadow-xl border border-gray-100 dark:border-slate-700">
                      <div class="flex justify-between items-center mb-8 border-b dark:border-slate-700 pb-4">
                          <h2 class="font-['Bubblegum_Sans'] text-3xl text-gray-800 dark:text-gray-100 flex items-center gap-2">🧠 Memory Match</h2>
                          <span class="font-bold text-gray-600 dark:text-gray-300">Moves: <span id="memory-moves" class="text-[#A8D8EA] dark:text-sky-400 text-xl">0</span></span>
                      </div>
                      
                      <div id="memory-win-screen" class="hidden text-center py-20 animate-in zoom-in">
                          <div class="text-6xl mb-6 animate-bounce">🏆</div>
                          <h2 class="font-['Bubblegum_Sans'] text-4xl text-[#FFB7C5] dark:text-pink-400 mb-4">You Won!</h2>
                          <p class="text-gray-500 dark:text-gray-300 mb-8">Great job matching all the cards!</p>
                          <div class="flex justify-center gap-4">
                              <button id="memory-replay" class="px-6 py-3 bg-[#A8D8EA] hover:bg-sky-300 text-slate-800 font-bold rounded-full transition-colors">Play Again</button>
                          </div>
                      </div>

                      <div id="memory-grid" class="grid grid-cols-3 sm:grid-cols-4 gap-4 perspective-1000">
                          ${this.memoryCards.map(e=>`
                              <div class="memory-card relative aspect-square cursor-pointer transform-style-3d transition-transform duration-500" data-idx="${e.id}" data-icon="${e.icon}">
                                  <div class="card-front absolute inset-0 bg-gradient-to-br from-[#A8D8EA] to-blue-200 dark:from-sky-600 dark:to-blue-800 rounded-2xl flex items-center justify-center shadow-sm backface-hidden">
                                      <span class="font-['Bubblegum_Sans'] text-white text-4xl opacity-50">?</span>
                                  </div>
                                  <div class="card-back absolute inset-0 bg-gray-50 dark:bg-slate-700 rounded-2xl flex items-center justify-center text-5xl shadow-sm backface-hidden rotate-y-180 hidden">
                                      ${e.icon}
                                  </div>
                              </div>
                          `).join(``)}
                      </div>
                  </div>
              </div>
          `;e(`#playground-root`).html(n),e(`#back-to-lobby`).on(`click`,()=>this.renderLobby()),e(`#memory-replay`).on(`click`,()=>this.startMemoryGame()),e(`.memory-card`).on(`click`,t=>{if(this.isBoardLocked)return;let n=e(t.currentTarget);n.hasClass(`flipped`)||this.flipCard(n)})},flipCard(t){t.addClass(`flipped`).css(`transform`,`rotateY(180deg)`),t.find(`.card-front`).addClass(`hidden`),t.find(`.card-back`).removeClass(`hidden`),this.flippedCards.push(t),this.flippedCards.length===2&&(this.isBoardLocked=!0,this.score++,e(`#memory-moves`).text(this.score),this.checkMemoryMatch())},checkMemoryMatch(){let t=this.flippedCards[0],n=this.flippedCards[1];t.data(`icon`)===n.data(`icon`)?(this.matchedPairs++,this.flippedCards=[],this.isBoardLocked=!1,this.matchedPairs===6&&setTimeout(()=>{e(`#memory-grid`).addClass(`hidden`),e(`#memory-win-screen`).removeClass(`hidden`)},500)):setTimeout(()=>{t.removeClass(`flipped`).css(`transform`,``),t.find(`.card-front`).removeClass(`hidden`),t.find(`.card-back`).addClass(`hidden`),n.removeClass(`flipped`).css(`transform`,``),n.find(`.card-front`).removeClass(`hidden`),n.find(`.card-back`).addClass(`hidden`),this.flippedCards=[],this.isBoardLocked=!1},1e3)},startCatchGame(){this.activeGame=`catch`,this.score=0,this.timeLeft=30,this.isPlaying=!1;let t=`
              <div class="container mx-auto px-4 py-8 animate-in fade-in">
                  <button id="back-to-lobby" class="mb-4 font-bold text-gray-500 hover:text-gray-700 dark:text-gray-400 flex items-center gap-2 px-4 py-2 bg-white/50 dark:bg-slate-800/50 rounded-full shadow-sm hover:bg-white dark:hover:bg-slate-800 transition-colors">← Back to Playground</button>
                  <div class="max-w-2xl mx-auto bg-white dark:bg-slate-800 rounded-[40px] p-8 shadow-xl border border-gray-100 dark:border-slate-700">
                      
                      <div class="flex justify-between items-center mb-8 border-b dark:border-slate-700 pb-4">
                          <h2 class="font-['Bubblegum_Sans'] text-3xl text-gray-800 dark:text-gray-100 flex items-center gap-2">
                              🖱️ Catch Ollie
                          </h2>
                          <div class="flex gap-6 text-xl font-bold">
                              <span class="text-gray-600 dark:text-gray-300 flex items-center gap-1"><span id="catch-timer">30</span>s</span>
                              <span class="text-[#B5EAD7] dark:text-emerald-400 text-2xl">Score: <span id="catch-score">0</span></span>
                          </div>
                      </div>

                      <div id="catch-start-screen" class="text-center py-20">
                          <div class="text-8xl mb-6">🐻</div>
                          <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-4">Ready to catch Ollie?</h3>
                          <button id="catch-start-btn" class="mx-auto bg-[#B5EAD7] hover:bg-emerald-400 dark:bg-emerald-500 text-emerald-900 dark:text-white text-xl py-4 px-10 rounded-full font-bold transition-all shadow-md">Start Game</button>
                      </div>

                      <div id="catch-end-screen" class="hidden text-center py-20 animate-in zoom-in">
                          <h2 class="font-['Bubblegum_Sans'] text-5xl text-[#B5EAD7] dark:text-emerald-400 mb-4">Time's Up!</h2>
                          <p class="text-2xl text-gray-600 dark:text-gray-300 mb-8">You caught Ollie <span id="catch-final-score" class="font-bold text-3xl text-gray-800 dark:text-white">0</span> times!</p>
                          <div class="flex justify-center gap-4">
                              <button id="catch-replay" class="px-6 py-3 bg-[#B5EAD7] hover:bg-emerald-400 text-emerald-900 font-bold rounded-full transition-colors">Play Again</button>
                          </div>
                      </div>

                      <div id="catch-grid" class="hidden grid grid-cols-3 gap-4 sm:gap-6 bg-gray-100 dark:bg-slate-900 p-6 rounded-3xl">
                          ${Array(9).fill().map((e,t)=>`
                              <div class="hole relative aspect-square bg-gray-300 dark:bg-slate-800 rounded-full shadow-inner overflow-hidden" data-idx="${t}">
                                  <div class="ollie-character absolute inset-0 flex items-end justify-center text-6xl sm:text-7xl cursor-pointer translate-y-full transition-transform duration-200">🐻</div>
                              </div>
                          `).join(``)}
                      </div>
                  </div>
              </div>
          `;e(`#playground-root`).html(t),e(`#back-to-lobby`).on(`click`,()=>this.renderLobby()),e(`#catch-start-btn`).on(`click`,()=>this.runCatchLoop()),e(`#catch-replay`).on(`click`,()=>this.runCatchLoop()),e(`.ollie-character`).on(`click`,t=>{if(!this.isPlaying)return;let n=e(t.currentTarget);n.hasClass(`translate-y-full`)||(this.score++,e(`#catch-score`).text(this.score),n.addClass(`translate-y-full`))})},runCatchLoop(){this.score=0,this.timeLeft=30,this.isPlaying=!0,e(`#catch-score`).text(this.score),e(`#catch-timer`).text(this.timeLeft).removeClass(`text-red-500 animate-pulse`),e(`#catch-start-screen, #catch-end-screen`).addClass(`hidden`),e(`#catch-grid`).removeClass(`hidden`),this.clearTimers(),this.timerInterval=setInterval(()=>{this.timeLeft--,e(`#catch-timer`).text(this.timeLeft),this.timeLeft<=5&&e(`#catch-timer`).addClass(`text-red-500 animate-pulse`),this.timeLeft<=0&&(this.clearTimers(),this.isPlaying=!1,e(`#catch-grid`).addClass(`hidden`),e(`#catch-end-screen`).removeClass(`hidden`),e(`#catch-final-score`).text(this.score),e(`.ollie-character`).addClass(`translate-y-full`))},1e3),this.gameLoopInterval=setInterval(()=>{this.isPlaying&&(e(`.ollie-character`).addClass(`translate-y-full`),e(`.hole[data-idx="${Math.floor(Math.random()*9)}"] .ollie-character`).removeClass(`translate-y-full`))},700)},startBalloonGame(){this.activeGame=`balloon`,this.score=0,this.timeLeft=30,this.isPlaying=!1,this.balloons=[],e(`#playground-root`).html(`
              <div class="container mx-auto px-4 py-8 animate-in fade-in flex flex-col h-[85vh]">
                  <button id="back-to-lobby" class="mb-4 font-bold text-gray-500 hover:text-gray-700 dark:text-gray-400 flex items-center gap-2 px-4 py-2 bg-white/50 dark:bg-slate-800/50 rounded-full shadow-sm hover:bg-white dark:hover:bg-slate-800 transition-colors w-max">← Back to Playground</button>
                  <div class="w-full max-w-4xl mx-auto flex-grow flex flex-col bg-white dark:bg-slate-800 rounded-[40px] shadow-xl border border-gray-100 dark:border-slate-700 overflow-hidden relative">
                      
                      <div class="flex justify-between items-center p-6 lg:p-8 border-b dark:border-slate-700 relative z-10 bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm">
                          <h2 class="font-['Bubblegum_Sans'] text-3xl text-gray-800 dark:text-gray-100 flex items-center gap-2">
                              🎈 Balloon Pop
                          </h2>
                          <div class="flex gap-6 text-xl font-bold">
                              <span class="text-gray-600 dark:text-gray-300 flex items-center gap-1"><span id="balloon-timer">30</span>s</span>
                              <span class="text-[#FFB7C5] dark:text-pink-400 text-2xl">Score: <span id="balloon-score">0</span></span>
                          </div>
                      </div>

                      <div id="balloon-area" class="flex-grow relative overflow-hidden bg-sky-50 dark:bg-slate-900 bg-[url('https://www.transparenttextures.com/patterns/cloudy-day.png')] dark:bg-blend-multiply">
                          
                          <div id="balloon-start-screen" class="absolute inset-0 flex flex-col items-center justify-center bg-white/50 dark:bg-slate-900/50 backdrop-blur-sm z-20">
                              <div class="text-8xl mb-6">🎈</div>
                              <h3 class="text-3xl font-bold text-gray-800 dark:text-gray-100 mb-6 font-['Bubblegum_Sans']">Pop the balloons before they fly away!</h3>
                              <button id="balloon-start-btn" class="bg-pink-500 hover:bg-pink-600 text-white text-xl py-4 px-10 rounded-full font-bold shadow-lg hover:scale-110 transition-transform">Start Popping!</button>
                          </div>

                          <div id="balloon-end-screen" class="hidden absolute inset-0 flex flex-col items-center justify-center bg-white/80 dark:bg-slate-900/80 backdrop-blur-md z-20 animate-in zoom-in">
                              <h2 class="font-['Bubblegum_Sans'] text-6xl text-[#FFB7C5] dark:text-pink-400 mb-4">Time's Up!</h2>
                              <p class="text-3xl text-gray-600 dark:text-gray-300 mb-8">You popped <span id="balloon-final-score" class="font-bold text-4xl text-gray-800 dark:text-white">0</span> balloons!</p>
                              <div class="flex gap-4">
                                  <button id="balloon-replay" class="bg-pink-500 hover:bg-pink-600 text-white shadow-lg text-lg px-8 py-3 rounded-full font-bold">Play Again</button>
                              </div>
                          </div>

                      </div>
                  </div>
              </div>
          `),e(`#back-to-lobby`).on(`click`,()=>this.renderLobby()),e(`#balloon-start-btn`).on(`click`,()=>this.runBalloonLoop()),e(`#balloon-replay`).on(`click`,()=>this.runBalloonLoop())},runBalloonLoop(){this.score=0,this.timeLeft=30,this.isPlaying=!0,this.balloons=[],e(`#balloon-score`).text(this.score),e(`#balloon-timer`).text(this.timeLeft).removeClass(`text-red-500 animate-pulse`),e(`#balloon-start-screen, #balloon-end-screen`).addClass(`hidden`),e(`.balloon-element`).remove(),this.clearTimers();let t=[`bg-red-400 dark:bg-red-500`,`bg-blue-400 dark:bg-blue-500`,`bg-emerald-400 dark:bg-emerald-500`,`bg-yellow-400 dark:bg-yellow-500`,`bg-purple-400 dark:bg-purple-500`];this.gameLoopInterval=setInterval(()=>{if(!this.isPlaying)return;let n=t[Math.floor(Math.random()*t.length)],r=`balloon-`+Date.now()+Math.random(),i=Math.random()*80+10,a=Math.random()*.5+.3,o=Math.random()*.05+.02,s=Math.random()*Math.PI*2,c=e(`
                  <div id="${r}" class="balloon-element absolute w-16 h-20 rounded-[50%] ${n} cursor-pointer shadow-lg active:scale-0 transition-transform duration-75"
                       style="border-bottom-left-radius: 50%; border-bottom-right-radius: 50%; border-top-left-radius: 40%; border-top-right-radius: 40%; transform-origin: bottom center;">
                      <div class="absolute -bottom-2 left-1/2 -translate-x-1/2 w-2 h-2 ${n.split(` `)[0]} rotate-45"></div>
                      <div class="absolute top-[100%] left-1/2 -translate-x-1/2 w-px h-12 bg-black/20 dark:bg-white/50"></div>
                      <div class="absolute top-2 left-2 w-4 h-6 bg-white/30 rounded-full rotate-12"></div>
                  </div>
              `);c.on(`click`,()=>{this.isPlaying&&(this.score++,e(`#balloon-score`).text(this.score),c.remove(),this.balloons=this.balloons.filter(e=>e.id!==r))}),e(`#balloon-area`).append(c),this.balloons.push({id:r,el:c,x:i,y:-20,speed:a,wobbleSpeed:o,wobbleOffset:s})},800),this.timerInterval=setInterval(()=>{this.timeLeft--,e(`#balloon-timer`).text(this.timeLeft),this.timeLeft<=5&&e(`#balloon-timer`).addClass(`text-red-500 animate-pulse`),this.timeLeft<=0&&(this.isPlaying=!1,this.clearTimers(),e(`#balloon-end-screen`).removeClass(`hidden`),e(`#balloon-final-score`).text(this.score))},1e3);let n=()=>{this.isPlaying&&this.balloons.length>0&&(this.balloons.forEach((e,t)=>{e.y+=e.speed,e.wobble=Math.sin(e.y*e.wobbleSpeed+e.wobbleOffset)*20,e.y>120?(e.el.remove(),this.balloons[t]=null):e.el.css({left:`calc(${e.x}% + ${e.wobble}px)`,bottom:`${e.y}%`})}),this.balloons=this.balloons.filter(e=>e!==null)),this.animationFrameId=requestAnimationFrame(n)};this.animationFrameId=requestAnimationFrame(n)}}.init()}(function(a){a(document).ready(function(){t(a),n(a),e(a),r(a),i(a)})})(jQuery);