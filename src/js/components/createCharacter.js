/**
 * Julia's Cartoonery - AI Character Creator Logic
 * Version: 2.0 (Ultra-Premium, XSS-Protected, URL-Injected)
 */

export const initCreateCharacter = ($) => {
    const $root = $('#create-character-root');
    if (!$root.length) return;

    // --- Utility: XSS Sanitization for User Safety ---
    const sanitize = (str) => {
        const temp = document.createElement('div');
        temp.textContent = str;
        return temp.innerHTML;
    };

    // --- State Management ---
    const state = {
        prompt: '',
        selectedStyle: 'Cute 3D 🧸',
        styles: ['Cute 3D 🧸', 'Watercolor 🎨', 'Coloring Book 🖍️', 'Pixel Art 👾', 'Anime Style 🌸'],
        tools: [
            {
                id: 'craiyon',
                name: 'Craiyon',
                desc: 'Best for fun art!',
                color: 'bg-gradient-to-br from-orange-400 to-red-500 shadow-orange-300',
                urlTemplate: (prompt, style) => `https://www.craiyon.com/?prompt=${encodeURIComponent(prompt + ' in ' + style + ' style')}`
            },
            {
                id: 'chatgpt',
                name: 'ChatGPT (DALL-E)',
                desc: 'Super smart AI!',
                color: 'bg-gradient-to-br from-emerald-400 to-teal-500 shadow-emerald-300',
                urlTemplate: (prompt, style) => `https://chatgpt.com/?q=${encodeURIComponent('Create a highly detailed image of: ' + prompt + '. Must use ' + style + ' style.')}`
            },
            {
                id: 'designer',
                name: 'MS Designer',
                desc: 'Ultra high quality!',
                color: 'bg-gradient-to-br from-purple-500 to-indigo-600 shadow-purple-300',
                urlTemplate: (prompt, style) => `https://www.bing.com/images/create?q=${encodeURIComponent(prompt + ' in ' + style + ' style')}`
            },
            {
                id: 'gemini',
                name: 'Gemini AI',
                desc: 'Google Magic!',
                color: 'bg-gradient-to-br from-blue-400 to-indigo-500 shadow-blue-300',
                // FIXED: Using unofficial prompt injection for Gemini
                urlTemplate: (prompt, style) => `https://gemini.google.com/app?q=${encodeURIComponent('Please generate an image of: ' + prompt + ', using a ' + style + ' art style.')}`
            }
        ]
    };

    // --- Magical Icons ---
    const icons = {
        sparkles: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="absolute top-6 right-10 text-white/60 w-20 h-20 animate-[spin_4s_linear_infinite]"><path d="M9.937 15.5A2 2 0 0 0 8.5 14.063l-6.135-1.582a.5.5 0 0 1 0-.962L8.5 9.936A2 2 0 0 0 9.937 8.5l1.582-6.135a.5.5 0 0 1 .963 0L14.063 8.5A2 2 0 0 0 15.5 9.937l6.135 1.581a.5.5 0 0 1 0 .964L15.5 14.063a2 2 0 0 0-1.437 1.437l-1.582 6.135a.5.5 0 0 1-.963 0z"/><path d="M20 3v4"/><path d="M22 5h-4"/><path d="M4 17v2"/><path d="M5 18H3"/></svg>`,
        magicWand: `<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mb-2"><path d="m15 5 4 4"/><path d="M13 7 8.7 2.7a2.41 2.41 0 0 0-3.4 0L2.7 5.3a2.41 2.41 0 0 0 0 3.4L7 13"/><path d="m8 6 2-2"/><path d="m2 22 5.5-1.5L21.1 6.9a2.41 2.41 0 0 0 0-3.4l-2.6-2.6a2.41 2.41 0 0 0-3.4 0L1.5 14.5Z"/></svg>`,
        cloud: `<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="white" opacity="0.1" class="absolute -left-4 top-4"><path d="M17.5 19c-2.5 0-4.5-2-4.5-4.5a4.5 4.5 0 0 1 1-2.8A5 5 0 0 0 4 12a5 5 0 0 0 5 5h8.5A2.5 2.5 0 0 0 20 14.5c0-1.2-.9-2.2-2-2.4a4.5 4.5 0 0 0-.5-8.1v.1Z"/></svg>`
    };

    // --- 1. Initial Skeleton Render ---
    const renderSkeleton = () => {
        const html = `
            <div class="max-w-5xl my-6 md:my-8 lg:my-12  mx-auto bg-white dark:bg-slate-800 rounded-[50px] shadow-[0_20px_60px_-15px_rgba(0,0,0,0.1)] dark:shadow-none overflow-hidden border-4 border-white dark:border-slate-700">
                
                <!-- Magical Header -->
                <div class="bg-gradient-to-r from-[#FFB7C5] via-[#A8D8EA] to-[#B5EAD7] p-12 text-center relative overflow-hidden">
                    ${icons.cloud}
                    ${icons.sparkles}
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
        `;
        $root.html(html);
    };

    // --- 2. Dynamic UI Update Logic ---
    const updateUI = () => {
        const isPromptEmpty = !state.prompt.trim();

        // Styles Generator
        const stylesHtml = state.styles.map(style => {
            const isSelected = state.selectedStyle === style;
            const activeClass = isSelected
                ? 'bg-pink-400 dark:bg-pink-500 text-white shadow-[0_10px_20px_-5px_rgba(244,114,182,0.5)] transform scale-110 -translate-y-2 border-2 border-white'
                : 'bg-white dark:bg-slate-800 text-slate-500 dark:text-slate-300 hover:bg-pink-50 dark:hover:bg-slate-700 border-2 border-slate-100 dark:border-slate-700 hover:-translate-y-1 hover:shadow-lg';
            return `<button data-style="${style}" class="style-btn px-6 py-3 rounded-full font-bold transition-all duration-300 ${activeClass}">${style}</button>`;
        }).join('');
        $('#styles-container').html(stylesHtml);

        // Engines/Tools Generator
        const toolsHtml = state.tools.map(tool => {
            const btnClass = isPromptEmpty
                ? 'opacity-40 cursor-not-allowed filter grayscale bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700'
                : 'bg-white dark:bg-slate-800 border-slate-100 dark:border-slate-700 hover:border-transparent hover:shadow-[0_20px_40px_-10px_rgba(0,0,0,0.1)] dark:hover:shadow-[0_20px_40px_-10px_rgba(0,0,0,0.5)] cursor-pointer hover:-translate-y-2 active:scale-95 group relative overflow-hidden';

            const iconBg = isPromptEmpty ? 'bg-slate-300 dark:bg-slate-600' : tool.color;

            return `
                <button data-tool="${tool.id}" ${isPromptEmpty ? 'disabled' : ''} aria-label="Open in ${tool.name}" class="tool-btn flex flex-col items-center p-8 rounded-[40px] border-4 transition-all duration-300 ease-out ${btnClass}">
                    <div class="w-20 h-20 rounded-full ${iconBg} flex items-center justify-center text-white mb-6 shadow-lg group-hover:scale-110 transition-transform duration-500 ease-out border-4 border-white/20 relative z-10">
                        ${icons.magicWand}
                    </div>
                    <span class="font-black text-xl text-slate-800 dark:text-white font-['Bubblegum_Sans'] tracking-wide relative z-10">${tool.name}</span>
                    <span class="text-sm font-bold text-slate-400 dark:text-slate-500 mt-2 relative z-10">${tool.desc}</span>
                </button>
            `;
        }).join('');
        $('#tools-container').html(toolsHtml);

        // Warning / Call to Action Generator
        const warningHtml = isPromptEmpty
            ? `<span class="px-4 py-2 bg-rose-100 text-rose-500 rounded-full text-sm font-bold animate-bounce inline-block border-2 border-rose-200">↑ Type something first!</span>`
            : `<span class="px-4 py-2 bg-emerald-100 text-emerald-600 rounded-full text-sm font-bold inline-block border-2 border-emerald-200 shadow-sm animate-pulse">Ready to magic! ✨</span>`;
        $('#warning-container').html(warningHtml);
    };

    // --- 3. Event Listeners (Optimized Delegation) ---
    const bindEvents = () => {
        // Typing interaction with Debounce-like feel for UI
        $('#prompt-textarea').on('input', function () {
            const val = $(this).val();
            // Sanitize input to prevent XSS attacks before saving to state
            state.prompt = sanitize(val);

            const $counter = $('#char-counter');
            $counter.text(`${val.length} chars`);

            // Color changing logic for counter
            if (val.length > 150) $counter.addClass('text-emerald-400').removeClass('text-slate-300 text-rose-400');
            else if (val.length > 0) $counter.addClass('text-rose-400').removeClass('text-slate-300 text-emerald-400');
            else $counter.addClass('text-slate-300').removeClass('text-rose-400 text-emerald-400');

            updateUI();
        });

        // Style selection
        $root.on('click', '.style-btn', function () {
            state.selectedStyle = $(this).data('style');

            // Playful pop animation on textarea
            const $textArea = $('#prompt-textarea');
            $textArea.addClass('scale-[1.02] shadow-[0_10px_40px_-10px_rgba(168,216,234,0.5)] border-[#A8D8EA]');
            setTimeout(() => {
                $textArea.removeClass('scale-[1.02] shadow-[0_10px_40px_-10px_rgba(168,216,234,0.5)] border-[#A8D8EA]');
            }, 300);

            updateUI();
        });

        // AI Engine Action with visual feedback
        $root.on('click', '.tool-btn', function (e) {
            e.preventDefault();
            if (!state.prompt.trim()) return;

            const toolId = $(this).data('tool');
            const tool = state.tools.find(t => t.id === toolId);

            if (tool) {
                // Visual explosion effect on click
                const $btn = $(this);
                $btn.append('<div class="absolute inset-0 bg-white/40 rounded-[40px] animate-ping pointer-events-none z-0"></div>');

                setTimeout(() => {
                    const url = tool.urlTemplate(state.prompt, state.selectedStyle);
                    window.open(url, '_blank', 'noopener,noreferrer');
                }, 400); // Slight delay to let kids see the animation
            }
        });
    };

    // Initialize the Magic
    renderSkeleton();
    updateUI();
    bindEvents();
};