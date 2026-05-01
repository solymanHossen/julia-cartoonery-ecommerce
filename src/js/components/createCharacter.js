export const initCreateCharacter = ($) => {
    const $root = $('#create-character-root');
    if (!$root.length) return;

    const state = {
        prompt: '',
        selectedStyle: 'Cute 3D',
        styles: ['Cute 3D', 'Watercolor', 'Coloring Book', 'Pixel Art', 'Anime Style'],
        tools: [
            { id: 'craiyon', name: 'Craiyon', color: 'bg-orange-500', urlTemplate: (prompt, style) => `https://www.craiyon.com/?prompt=${encodeURIComponent(prompt + ' in ' + style + ' style')}` },
            { id: 'gemini', name: 'Gemini AI', color: 'bg-blue-500', urlTemplate: () => 'https://gemini.google.com' },
            { id: 'designer', name: 'Microsoft Designer', color: 'bg-purple-600', urlTemplate: () => 'https://designer.microsoft.com' },
        ]
    };

    const icons = {
        sparkles: `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute top-4 right-8 text-white/40 w-16 h-16 animate-pulse"><path d="M9.937 15.5A2 2 0 0 0 8.5 14.063l-6.135-1.582a.5.5 0 0 1 0-.962L8.5 9.936A2 2 0 0 0 9.937 8.5l1.582-6.135a.5.5 0 0 1 .963 0L14.063 8.5A2 2 0 0 0 15.5 9.937l6.135 1.581a.5.5 0 0 1 0 .964L15.5 14.063a2 2 0 0 0-1.437 1.437l-1.582 6.135a.5.5 0 0 1-.963 0z"/><path d="M20 3v4"/><path d="M22 5h-4"/><path d="M4 17v2"/><path d="M5 18H3"/></svg>`,
        image: `<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>`
    };

    const renderSkeleton = () => {
        const html = `
            <div class="container mx-auto px-4 lg:px-8 py-12 animate-in fade-in">
                <div class="max-w-4xl mx-auto bg-white dark:bg-slate-800 rounded-[40px] shadow-xl overflow-hidden border border-gray-100 dark:border-slate-700">
                    <div class="bg-gradient-to-r from-[#A8D8EA] to-[#B5EAD7] dark:from-sky-700 dark:to-emerald-700 p-10 text-center relative overflow-hidden">
                        ${icons.sparkles}
                        <h1 class="font-['Bubblegum_Sans'] text-4xl lg:text-5xl text-white mb-3 relative z-10 drop-shadow-sm">Create Your Character</h1>
                        <p class="text-white/90 font-bold relative z-10">Use free AI tools to bring your imagination to life!</p>
                    </div>

                    <div class="p-8 lg:p-12">
                        <div class="mb-8">
                            <label class="block text-gray-700 dark:text-gray-300 font-bold mb-3 text-lg">Describe your character</label>
                            <textarea 
                                id="prompt-textarea"
                                placeholder="e.g. A cute fluffy bunny wearing a tiny blue backpack, eating a carrot..."
                                class="w-full p-4 rounded-2xl bg-gray-50 dark:bg-slate-900 border-2 border-gray-100 dark:border-slate-700 focus:border-[#A8D8EA] dark:focus:border-sky-500 focus:ring-0 transition-colors outline-none min-h-[120px] resize-y dark:text-white shadow-inner"
                            ></textarea>
                        </div>

                        <div class="mb-10">
                            <label class="block text-gray-700 dark:text-gray-300 font-bold mb-3 text-lg">Choose a style</label>
                            <div id="styles-container" class="flex flex-wrap gap-3"></div>
                        </div>

                        <div class="h-px bg-gray-100 dark:bg-slate-700 w-full mb-10"></div>

                        <div class="mb-4">
                            <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-6 text-center">Select an AI Engine to Generate</h3>
                            <div id="tools-container" class="grid grid-cols-1 md:grid-cols-3 gap-4"></div>
                            <div id="warning-container"></div>
                        </div>
                    </div>
                </div>
            </div>
        `;
        $root.html(html);
    };

    const updateUI = () => {
        const isPromptEmpty = !state.prompt.trim();

        // Update Styles HTML
        const stylesHtml = state.styles.map(style => {
            const isSelected = state.selectedStyle === style;
            const activeClass = isSelected 
                ? 'bg-[#FFB7C5] dark:bg-pink-500 text-white shadow-md transform scale-105' 
                : 'bg-gray-100 dark:bg-slate-700 text-gray-500 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-slate-600';
            return `<button data-style="${style}" class="style-btn px-5 py-2 rounded-full font-bold transition-all ${activeClass}">${style}</button>`;
        }).join('');
        $('#styles-container').html(stylesHtml);

        // Update Tools HTML
        const toolsHtml = state.tools.map(tool => {
            const btnClass = isPromptEmpty 
                ? 'opacity-50 cursor-not-allowed bg-gray-50 dark:bg-slate-800 border-gray-100 dark:border-slate-700' 
                : 'hover:border-[#A8D8EA] dark:hover:border-sky-500 hover:bg-sky-50 dark:hover:bg-slate-700/50 border-gray-100 dark:border-slate-700 bg-white dark:bg-slate-800 cursor-pointer hover:-translate-y-1 hover:shadow-lg';
            
            return `
                <button data-tool="${tool.id}" ${isPromptEmpty ? 'disabled' : ''} class="tool-btn flex flex-col items-center p-6 rounded-3xl border-2 transition-all group ${btnClass}">
                    <div class="w-16 h-16 rounded-2xl ${tool.color} flex items-center justify-center text-white mb-4 shadow-lg group-hover:scale-110 transition-transform duration-500 ease-out">
                        ${icons.image}
                    </div>
                    <span class="font-bold text-gray-800 dark:text-gray-200">${tool.name}</span>
                    <span class="text-xs text-gray-500 dark:text-gray-400 mt-1">Opens in new tab</span>
                </button>
            `;
        }).join('');
        $('#tools-container').html(toolsHtml);

        // Update Warning Text
        const warningHtml = isPromptEmpty ? `<p class="text-center text-sm text-red-400 dark:text-red-500 mt-4 animate-pulse font-bold">Please enter a description first!</p>` : '';
        $('#warning-container').html(warningHtml);
    };

    const bindEvents = () => {
        $('#prompt-textarea').on('input', function() {
            state.prompt = $(this).val();
            updateUI();
        });

        $root.on('click', '.style-btn', function() {
            state.selectedStyle = $(this).data('style');
            updateUI();
        });

        $root.on('click', '.tool-btn', function() {
            if (!state.prompt.trim()) return;
            const toolId = $(this).data('tool');
            const tool = state.tools.find(t => t.id === toolId);
            if (tool) {
                const url = tool.urlTemplate(state.prompt, state.selectedStyle);
                window.open(url, '_blank');
            }
        });
    };

    renderSkeleton();
    updateUI();
    bindEvents();
};
