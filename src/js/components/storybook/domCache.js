export class StoryPageCache {
  constructor(maxEntries = 8) {
    this.maxEntries = maxEntries;
    this.entries = new Map();
  }

  get(url) {
    if (!this.entries.has(url)) {
      return null;
    }

    const value = this.entries.get(url);
    this.entries.delete(url);
    this.entries.set(url, value);
    return value;
  }

  set(url, value) {
    if (this.entries.has(url)) {
      this.entries.delete(url);
    }

    this.entries.set(url, value);

    while (this.entries.size > this.maxEntries) {
      const oldestKey = this.entries.keys().next().value;
      this.entries.delete(oldestKey);
    }

    return value;
  }

  has(url) {
    return this.entries.has(url);
  }

  clear() {
    this.entries.clear();
  }
}
