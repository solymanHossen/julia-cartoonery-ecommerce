export function initPlaygroundGames($) {
  if ($('#playground-root').length === 0) return;

  const Playground = {
      activeGame: null,
      score: 0,
      timeLeft: 0,
      timerInterval: null,
      gameLoopInterval: null,
      animationFrameId: null,
      
      init() {
          this.renderLobby();
      },

      clearTimers() {
          if (this.timerInterval) clearInterval(this.timerInterval);
          if (this.gameLoopInterval) clearInterval(this.gameLoopInterval);
          if (this.animationFrameId) cancelAnimationFrame(this.animationFrameId);
      },

      // ==========================================
      // 1. MAIN LOBBY
      // ==========================================
      renderLobby() {
          this.clearTimers();
          this.activeGame = null;

          const html = `
              <div class="container mx-auto px-4 lg:px-8 py-12 animate-in fade-in">
                  <div class="text-center mb-16">
                      <div class="w-24 h-24 bg-gradient-to-br from-purple-300 to-pink-300 dark:from-purple-900/50 dark:to-pink-900/50 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg border-4 border-white dark:border-slate-800">
                          <span class="text-4xl text-white">🎮</span>
                      </div>
                      <h1 class="font-['Bubblegum_Sans'] text-5xl md:text-6xl text-gray-800 dark:text-gray-100 mb-4">The Playground</h1>
                      <p class="text-xl text-gray-500 dark:text-gray-400">Choose a fun mini-game to play!</p>
                  </div>
                  <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                      ${this.gameCard('memory', 'Memory Match', '🧠', 'bg-[#A8D8EA] dark:bg-sky-500', 'bg-gradient-to-b from-blue-50 to-white dark:from-sky-900/20 dark:to-slate-800 hover:border-[#A8D8EA] dark:hover:border-sky-500', 'bg-slate-900 text-white hover:bg-slate-800')}
                      ${this.gameCard('catch', 'Catch Ollie', '🖱️', 'bg-[#B5EAD7] dark:bg-emerald-500', 'bg-gradient-to-b from-green-50 to-white dark:from-emerald-900/20 dark:to-slate-800 hover:border-[#B5EAD7] dark:hover:border-emerald-500', 'bg-[#B5EAD7] hover:bg-emerald-300 dark:bg-emerald-500 dark:hover:bg-emerald-600 text-emerald-900 dark:text-white')}
                      ${this.gameCard('balloon', 'Balloon Pop', '🎈', 'bg-[#FFB7C5] dark:bg-pink-500', 'bg-gradient-to-b from-pink-50 to-white dark:from-pink-900/20 dark:to-slate-800 hover:border-[#FFB7C5] dark:hover:border-pink-500', 'bg-pink-500 hover:bg-pink-600 text-white')}
                  </div>
              </div>
          `;
          $('#playground-root').html(html);
          this.bindLobbyEvents();
      },

      gameCard(id, title, icon, iconColor, cardColor, btnColor) {
          return `
              <div data-game="${id}" class="game-start-card cursor-pointer flex flex-col items-center p-8 text-center ${cardColor} rounded-[40px] shadow-sm hover:shadow-xl transition-all border-2 border-transparent group">
                  <div class="w-20 h-20 ${iconColor} rounded-2xl flex items-center justify-center text-4xl mb-6 transform group-hover:rotate-12 transition-transform shadow-md">${icon}</div>
                  <h3 class="font-['Bubblegum_Sans'] text-2xl text-gray-800 dark:text-gray-100 mb-2">${title}</h3>
                  <button class="mt-4 px-6 py-2 w-full rounded-full font-bold transition-colors ${btnColor}">Play Now</button>
              </div>
          `;
      },

      bindLobbyEvents() {
          $('.game-start-card').on('click', (e) => {
              const game = $(e.currentTarget).data('game');
              if(game === 'memory') this.startMemoryGame();
              if(game === 'catch') this.startCatchGame();
              if(game === 'balloon') this.startBalloonGame();
          });
      },

      // ==========================================
      // 2. MEMORY MATCH GAME
      // ==========================================
      startMemoryGame() {
          this.activeGame = 'memory';
          this.score = 0; // Moves
          this.matchedPairs = 0;
          this.flippedCards = [];
          this.isBoardLocked = false;
          
          const emojis = ['🎈', '🐶', '🦄', '🦖', '🚗', '🍎'];
          this.memoryCards = [...emojis, ...emojis]
              .sort(() => Math.random() - 0.5)
              .map((emoji, idx) => ({ id: idx, icon: emoji, matched: false }));

          const html = `
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
                          ${this.memoryCards.map(c => `
                              <div class="memory-card relative aspect-square cursor-pointer transform-style-3d transition-transform duration-500" data-idx="${c.id}" data-icon="${c.icon}">
                                  <div class="card-front absolute inset-0 bg-gradient-to-br from-[#A8D8EA] to-blue-200 dark:from-sky-600 dark:to-blue-800 rounded-2xl flex items-center justify-center shadow-sm backface-hidden">
                                      <span class="font-['Bubblegum_Sans'] text-white text-4xl opacity-50">?</span>
                                  </div>
                                  <div class="card-back absolute inset-0 bg-gray-50 dark:bg-slate-700 rounded-2xl flex items-center justify-center text-5xl shadow-sm backface-hidden rotate-y-180 hidden">
                                      ${c.icon}
                                  </div>
                              </div>
                          `).join('')}
                      </div>
                  </div>
              </div>
          `;
          $('#playground-root').html(html);

          $('#back-to-lobby').on('click', () => this.renderLobby());
          $('#memory-replay').on('click', () => this.startMemoryGame());

          $('.memory-card').on('click', (e) => {
              if(this.isBoardLocked) return;
              const card = $(e.currentTarget);
              if(card.hasClass('flipped')) return;

              this.flipCard(card);
          });
      },

      flipCard(card) {
          card.addClass('flipped').css('transform', 'rotateY(180deg)');
          card.find('.card-front').addClass('hidden');
          card.find('.card-back').removeClass('hidden');

          this.flippedCards.push(card);

          if(this.flippedCards.length === 2) {
              this.isBoardLocked = true;
              this.score++; // Increment moves
              $('#memory-moves').text(this.score);
              this.checkMemoryMatch();
          }
      },

      checkMemoryMatch() {
          const card1 = this.flippedCards[0];
          const card2 = this.flippedCards[1];
          const icon1 = card1.data('icon');
          const icon2 = card2.data('icon');

          if(icon1 === icon2) {
              // Match
              this.matchedPairs++;
              this.flippedCards = [];
              this.isBoardLocked = false;
              if(this.matchedPairs === 6) {
                  setTimeout(() => {
                      $('#memory-grid').addClass('hidden');
                      $('#memory-win-screen').removeClass('hidden');
                  }, 500);
              }
          } else {
              // No Match
              setTimeout(() => {
                  card1.removeClass('flipped').css('transform', '');
                  card1.find('.card-front').removeClass('hidden');
                  card1.find('.card-back').addClass('hidden');

                  card2.removeClass('flipped').css('transform', '');
                  card2.find('.card-front').removeClass('hidden');
                  card2.find('.card-back').addClass('hidden');

                  this.flippedCards = [];
                  this.isBoardLocked = false;
              }, 1000);
          }
      },

      // ==========================================
      // 3. CATCH OLLIE GAME
      // ==========================================
      startCatchGame() {
          this.activeGame = 'catch';
          this.score = 0;
          this.timeLeft = 30;
          this.isPlaying = false;
          
          const html = `
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
                          ${Array(9).fill().map((_, i) => `
                              <div class="hole relative aspect-square bg-gray-300 dark:bg-slate-800 rounded-full shadow-inner overflow-hidden" data-idx="${i}">
                                  <div class="ollie-character absolute inset-0 flex items-end justify-center text-6xl sm:text-7xl cursor-pointer translate-y-full transition-transform duration-200">🐻</div>
                              </div>
                          `).join('')}
                      </div>
                  </div>
              </div>
          `;
          $('#playground-root').html(html);

          $('#back-to-lobby').on('click', () => this.renderLobby());
          $('#catch-start-btn').on('click', () => this.runCatchLoop());
          $('#catch-replay').on('click', () => this.runCatchLoop());

          $('.ollie-character').on('click', (e) => {
              if(!this.isPlaying) return;
              const char = $(e.currentTarget);
              if(!char.hasClass('translate-y-full')) {
                  this.score++;
                  $('#catch-score').text(this.score);
                  char.addClass('translate-y-full'); // hide immediately
              }
          });
      },

      runCatchLoop() {
          this.score = 0;
          this.timeLeft = 30;
          this.isPlaying = true;
          
          $('#catch-score').text(this.score);
          $('#catch-timer').text(this.timeLeft).removeClass('text-red-500 animate-pulse');
          $('#catch-start-screen, #catch-end-screen').addClass('hidden');
          $('#catch-grid').removeClass('hidden');

          this.clearTimers();

          this.timerInterval = setInterval(() => {
              this.timeLeft--;
              $('#catch-timer').text(this.timeLeft);
              if(this.timeLeft <= 5) $('#catch-timer').addClass('text-red-500 animate-pulse');

              if(this.timeLeft <= 0) {
                  this.clearTimers();
                  this.isPlaying = false;
                  $('#catch-grid').addClass('hidden');
                  $('#catch-end-screen').removeClass('hidden');
                  $('#catch-final-score').text(this.score);
                  $('.ollie-character').addClass('translate-y-full');
              }
          }, 1000);

          this.gameLoopInterval = setInterval(() => {
              if(!this.isPlaying) return;
              $('.ollie-character').addClass('translate-y-full'); // Hide all
              const randomHole = Math.floor(Math.random() * 9);
              $(`.hole[data-idx="${randomHole}"] .ollie-character`).removeClass('translate-y-full');
          }, 700);
      },

      // ==========================================
      // 4. BALLOON POP GAME
      // ==========================================
      startBalloonGame() {
          this.activeGame = 'balloon';
          this.score = 0;
          this.timeLeft = 30;
          this.isPlaying = false;
          this.balloons = [];
          
          const html = `
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
          `;
          $('#playground-root').html(html);

          $('#back-to-lobby').on('click', () => this.renderLobby());
          $('#balloon-start-btn').on('click', () => this.runBalloonLoop());
          $('#balloon-replay').on('click', () => this.runBalloonLoop());
      },

      runBalloonLoop() {
          this.score = 0;
          this.timeLeft = 30;
          this.isPlaying = true;
          this.balloons = [];
          
          $('#balloon-score').text(this.score);
          $('#balloon-timer').text(this.timeLeft).removeClass('text-red-500 animate-pulse');
          $('#balloon-start-screen, #balloon-end-screen').addClass('hidden');
          $('.balloon-element').remove(); // clear existing

          this.clearTimers();

          const colors = [
              'bg-red-400 dark:bg-red-500', 
              'bg-blue-400 dark:bg-blue-500', 
              'bg-emerald-400 dark:bg-emerald-500', 
              'bg-yellow-400 dark:bg-yellow-500', 
              'bg-purple-400 dark:bg-purple-500'
          ];

          // Spawner
          this.gameLoopInterval = setInterval(() => {
              if(!this.isPlaying) return;
              
              const color = colors[Math.floor(Math.random() * colors.length)];
              const id = 'balloon-' + Date.now() + Math.random();
              const startX = Math.random() * 80 + 10; // 10-90%
              const speed = Math.random() * 0.5 + 0.3; // Speed factor
              const wobbleSpeed = Math.random() * 0.05 + 0.02;
              const wobbleOffset = Math.random() * Math.PI * 2;

              const balloonEl = $(`
                  <div id="${id}" class="balloon-element absolute w-16 h-20 rounded-[50%] ${color} cursor-pointer shadow-lg active:scale-0 transition-transform duration-75"
                       style="border-bottom-left-radius: 50%; border-bottom-right-radius: 50%; border-top-left-radius: 40%; border-top-right-radius: 40%; transform-origin: bottom center;">
                      <div class="absolute -bottom-2 left-1/2 -translate-x-1/2 w-2 h-2 ${color.split(' ')[0]} rotate-45"></div>
                      <div class="absolute top-[100%] left-1/2 -translate-x-1/2 w-px h-12 bg-black/20 dark:bg-white/50"></div>
                      <div class="absolute top-2 left-2 w-4 h-6 bg-white/30 rounded-full rotate-12"></div>
                  </div>
              `);

              balloonEl.on('click', () => {
                  if(!this.isPlaying) return;
                  this.score++;
                  $('#balloon-score').text(this.score);
                  balloonEl.remove();
                  this.balloons = this.balloons.filter(b => b.id !== id);
              });

              $('#balloon-area').append(balloonEl);

              this.balloons.push({
                  id,
                  el: balloonEl,
                  x: startX,
                  y: -20, // Bottom percentage
                  speed,
                  wobbleSpeed,
                  wobbleOffset
              });

          }, 800);

          // Timer
          this.timerInterval = setInterval(() => {
              this.timeLeft--;
              $('#balloon-timer').text(this.timeLeft);
              if(this.timeLeft <= 5) $('#balloon-timer').addClass('text-red-500 animate-pulse');

              if(this.timeLeft <= 0) {
                  this.isPlaying = false;
                  this.clearTimers();
                  $('#balloon-end-screen').removeClass('hidden');
                  $('#balloon-final-score').text(this.score);
              }
          }, 1000);

          // Animation Loop
          const animate = () => {
              if(this.isPlaying && this.balloons.length > 0) {
                  this.balloons.forEach((b, index) => {
                      b.y += b.speed;
                      b.wobble = Math.sin(b.y * b.wobbleSpeed + b.wobbleOffset) * 20;
                      
                      if(b.y > 120) {
                          b.el.remove();
                          this.balloons[index] = null;
                      } else {
                          b.el.css({
                              left: `calc(${b.x}% + ${b.wobble}px)`,
                              bottom: `${b.y}%`
                          });
                      }
                  });
                  this.balloons = this.balloons.filter(b => b !== null);
              }
              this.animationFrameId = requestAnimationFrame(animate);
          };
          this.animationFrameId = requestAnimationFrame(animate);
      }
  };

  Playground.init();
}
