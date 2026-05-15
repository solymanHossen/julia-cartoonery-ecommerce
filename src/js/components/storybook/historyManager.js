export class StoryHistoryManager {
  constructor() {
    this.boundPopState = null;
  }

  getCurrentState() {
    return window.history.state || null;
  }

  syncInitialState(state) {
    window.history.replaceState(state, '', state.url);
  }

  push(state) {
    window.history.pushState(state, '', state.url);
  }

  replace(state) {
    window.history.replaceState(state, '', state.url);
  }

  onPopState(handler) {
    this.boundPopState = handler;
    window.addEventListener('popstate', handler);
  }

  destroy() {
    if (this.boundPopState) {
      window.removeEventListener('popstate', this.boundPopState);
      this.boundPopState = null;
    }
  }
}
