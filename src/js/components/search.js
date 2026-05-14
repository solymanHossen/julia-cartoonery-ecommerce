/**
 * Modern Search Modal Component
 * Handles search functionality with real-time results
 */

class SearchModal {
    constructor() {
        this.modal = document.getElementById('search-modal');
        this.modalContent = document.getElementById('search-modal-content');
        this.openBtn = document.getElementById('search-modal-open');
        this.closeBtn = document.getElementById('search-modal-close');
        this.input = document.getElementById('search-input');
        this.resultsContainer = document.getElementById('search-results-container');
        this.emptyState = document.getElementById('search-empty-state');
        this.loadingState = document.getElementById('search-loading-state');
        this.resultsList = document.getElementById('search-results-list');
        this.noResults = document.getElementById('search-no-results');
        this.noResultsQuery = document.getElementById('search-no-results-query');
        
        this.searchTimeout = null;
        this.selectedIndex = -1;
        this.results = [];
        
        this.init();
    }

    init() {
        // Open modal
        this.openBtn?.addEventListener('click', () => this.open());
        
        // Close modal
        this.closeBtn?.addEventListener('click', () => this.close());
        this.modal?.addEventListener('click', (e) => {
            if (e.target === this.modal) this.close();
        });

        // Search input
        this.input?.addEventListener('input', (e) => this.handleInput(e));
        this.input?.addEventListener('keydown', (e) => this.handleKeydown(e));

        // Close on ESC
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.isOpen()) this.close();
        });

        // Cmd+K or Ctrl+K shortcut
        document.addEventListener('keydown', (e) => {
            if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                e.preventDefault();
                this.open();
            }
        });
    }

    open() {
        if (this.isOpen()) return;
        
        this.modal.classList.remove('opacity-0', 'pointer-events-none');
        this.modalContent.classList.remove('scale-95', 'opacity-0');
        this.input.focus();
        document.body.style.overflow = 'hidden';
    }

    close() {
        this.modal.classList.add('opacity-0', 'pointer-events-none');
        this.modalContent.classList.add('scale-95', 'opacity-0');
        this.input.value = '';
        this.selectedIndex = -1;
        this.results = [];
        this.showEmptyState();
        document.body.style.overflow = '';
    }

    isOpen() {
        return !this.modal.classList.contains('opacity-0');
    }

    handleInput(e) {
        const query = e.target.value.trim();
        
        // Clear previous timeout
        clearTimeout(this.searchTimeout);
        
        if (!query) {
            this.showEmptyState();
            this.selectedIndex = -1;
            return;
        }

        // Show loading state with delay
        this.searchTimeout = setTimeout(() => {
            this.performSearch(query);
        }, 300);
    }

    handleKeydown(e) {
        switch (e.key) {
            case 'ArrowDown':
                e.preventDefault();
                this.selectNext();
                break;
            case 'ArrowUp':
                e.preventDefault();
                this.selectPrev();
                break;
            case 'Enter':
                e.preventDefault();
                this.selectCurrent();
                break;
        }
    }

    async performSearch(query) {
        this.showLoadingState();
        
        try {
            const response = await fetch(`${window.location.origin}/wp-json/julias/v1/search?q=${encodeURIComponent(query)}`);
            const data = await response.json();
            
            this.results = data.results || [];
            
            if (this.results.length === 0) {
                this.showNoResults(query);
            } else {
                this.showResults();
            }
            
            this.selectedIndex = -1;
        } catch (error) {
            console.error('Search error:', error);
            this.showNoResults(query);
        }
    }

    showEmptyState() {
        this.emptyState.classList.remove('hidden');
        this.loadingState.classList.add('hidden');
        this.resultsList.classList.add('hidden');
        this.noResults.classList.add('hidden');
    }

    showLoadingState() {
        this.emptyState.classList.add('hidden');
        this.loadingState.classList.remove('hidden');
        this.resultsList.classList.add('hidden');
        this.noResults.classList.add('hidden');
    }

    showResults() {
        this.emptyState.classList.add('hidden');
        this.loadingState.classList.add('hidden');
        this.resultsList.classList.remove('hidden');
        this.noResults.classList.add('hidden');
        
        this.renderResults();
    }

    showNoResults(query) {
        this.emptyState.classList.add('hidden');
        this.loadingState.classList.add('hidden');
        this.resultsList.classList.add('hidden');
        this.noResults.classList.remove('hidden');
        this.noResultsQuery.textContent = `No results for "${query}"`;
    }

    renderResults() {
        this.resultsList.innerHTML = '';
        
        this.results.forEach((result, index) => {
            const item = document.createElement('a');
            item.href = result.url;
            item.className = `block p-4 md:p-5 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors cursor-pointer group ${
                index === this.selectedIndex ? 'bg-slate-100 dark:bg-slate-700' : ''
            }`;
            item.dataset.index = index;
            
            item.addEventListener('click', () => {
                window.location.href = result.url;
            });

            item.addEventListener('mouseenter', () => {
                this.selectedIndex = index;
                this.updateSelection();
            });

            // Build content based on result type
            let icon = '';
            let typeLabel = '';
            
            if (result.type === 'product') {
                icon = '🛍️';
                typeLabel = 'Product';
            } else if (result.type === 'character') {
                icon = '👤';
                typeLabel = 'Character';
            } else if (result.type === 'story') {
                icon = '📖';
                typeLabel = 'Story';
            } else if (result.type === 'post') {
                icon = '📝';
                typeLabel = 'Blog Post';
            } else {
                icon = '📄';
                typeLabel = 'Page';
            }

            item.innerHTML = `
                <div class="flex items-start gap-4">
                    <div class="text-xl md:text-2xl flex-shrink-0">${icon}</div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 mb-1">
                            <h3 class="font-semibold text-slate-800 dark:text-slate-100 truncate group-hover:text-[#A8D8EA] dark:group-hover:text-sky-400 transition-colors">
                                ${this.escapeHtml(result.title)}
                            </h3>
                            <span class="text-xs px-2 py-1 bg-slate-100 dark:bg-slate-600 text-slate-600 dark:text-slate-300 rounded-full whitespace-nowrap">
                                ${typeLabel}
                            </span>
                        </div>
                        ${result.excerpt ? `<p class="text-xs md:text-sm text-slate-600 dark:text-slate-400 line-clamp-2">${this.escapeHtml(result.excerpt)}</p>` : ''}
                    </div>
                </div>
            `;
            
            this.resultsList.appendChild(item);
        });
    }

    selectNext() {
        if (this.results.length === 0) return;
        this.selectedIndex = (this.selectedIndex + 1) % this.results.length;
        this.updateSelection();
    }

    selectPrev() {
        if (this.results.length === 0) return;
        this.selectedIndex = this.selectedIndex <= 0 ? this.results.length - 1 : this.selectedIndex - 1;
        this.updateSelection();
    }

    selectCurrent() {
        if (this.selectedIndex >= 0 && this.results[this.selectedIndex]) {
            window.location.href = this.results[this.selectedIndex].url;
        }
    }

    updateSelection() {
        document.querySelectorAll('[data-index]').forEach((el, index) => {
            if (index === this.selectedIndex) {
                el.classList.add('bg-slate-100', 'dark:bg-slate-700');
                el.scrollIntoView({ block: 'nearest' });
            } else {
                el.classList.remove('bg-slate-100', 'dark:bg-slate-700');
            }
        });
    }

    escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
}

// Initialize when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        new SearchModal();
    });
} else {
    new SearchModal();
}
