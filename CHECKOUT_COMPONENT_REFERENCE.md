# 🔧 Premium Checkout - Component Reference Guide
## Implementation Code & Specifications

---

## COMPONENT LIBRARY

### 1. PROGRESS INDICATOR

**HTML Structure:**
```html
<div class="progress-indicator">
  <div class="progress-bar">
    <div class="progress-fill" style="width: 25%;"></div>
  </div>
  
  <div class="progress-steps">
    <div class="step-item active" data-step="1">
      <div class="step-badge">1</div>
      <span class="step-label">Contact</span>
    </div>
    
    <div class="step-item" data-step="2">
      <div class="step-badge">2</div>
      <span class="step-label">Address</span>
    </div>
    
    <div class="step-item" data-step="3">
      <div class="step-badge">3</div>
      <span class="step-label">Payment</span>
    </div>
    
    <div class="step-item" data-step="4">
      <div class="step-badge">4</div>
      <span class="step-label">Review</span>
    </div>
  </div>
</div>
```

**CSS Styling:**
```css
.progress-indicator {
  margin-bottom: 2rem;
}

.progress-bar {
  height: 4px;
  background: #e2e8f0;
  border-radius: 2px;
  margin-bottom: 1.5rem;
  overflow: hidden;
}

.progress-fill {
  height: 100%;
  background: linear-gradient(to right, #FFB7C5, #FF9FB3);
  transition: width 300ms cubic-bezier(0.4, 0, 0.2, 1);
}

.progress-steps {
  display: flex;
  justify-content: space-between;
  gap: 1rem;
}

.step-item {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 0.5rem;
  opacity: 0.5;
  transition: opacity 200ms;
}

.step-item.active {
  opacity: 1;
}

.step-item.completed {
  opacity: 1;
}

.step-badge {
  width: 2.5rem;
  height: 2.5rem;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 50%;
  font-weight: 700;
  font-size: 1rem;
  background: #f1f5f9;
  border: 2px solid #e2e8f0;
  color: #64748b;
  transition: all 200ms;
}

.step-item.active .step-badge {
  background: linear-gradient(135deg, #FFB7C5, #FF9FB3);
  border-color: #FFB7C5;
  color: white;
  box-shadow: 0 4px 12px rgba(255, 183, 197, 0.3);
}

.step-item.completed .step-badge {
  background: #22c55e;
  border-color: #22c55e;
  color: white;
}

.step-label {
  font-size: 0.75rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  color: #64748b;
}

/* Responsive - Mobile */
@media (max-width: 768px) {
  .progress-steps {
    gap: 0.5rem;
  }
  
  .step-badge {
    width: 2rem;
    height: 2rem;
    font-size: 0.875rem;
  }
  
  .step-label {
    font-size: 0.625rem;
  }
}
```

---

### 2. CHECKOUT CARD

**HTML Structure:**
```html
<div class="checkout-card" data-step="1">
  <div class="card-header">
    <div class="header-badge">1</div>
    <div class="header-title">Contact Information</div>
    <button class="header-edit" aria-label="Edit step 1">✎</button>
  </div>
  
  <div class="card-body">
    <!-- Form fields -->
    <div class="form-group">
      <label for="email">Email Address</label>
      <input 
        type="email" 
        id="email" 
        name="email"
        class="form-input"
        required
        placeholder="you@example.com"
      />
      <span class="field-hint">We'll send your order confirmation here</span>
      <span class="field-error" style="display: none;"></span>
    </div>
    
    <div class="form-group">
      <label for="phone">Phone Number</label>
      <input 
        type="tel" 
        id="phone" 
        name="phone"
        class="form-input"
        required
        placeholder="(123) 456-7890"
      />
      <span class="field-error" style="display: none;"></span>
    </div>
    
    <div class="form-checkbox">
      <input 
        type="checkbox" 
        id="save-info" 
        name="save_info"
        class="form-checkbox-input"
      />
      <label for="save-info" class="form-checkbox-label">
        Save this information for next time
      </label>
    </div>
  </div>
  
  <div class="card-footer">
    <button class="btn-secondary">← Back</button>
    <button class="btn-primary" disabled>Next Step →</button>
  </div>
</div>
```

**CSS Styling:**
```css
.checkout-card {
  background: #ffffff;
  border: 1px solid #e2e8f0;
  border-radius: 12px;
  margin-bottom: 1.5rem;
  overflow: hidden;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
  transition: all 200ms;
}

.checkout-card.active {
  box-shadow: 0 4px 16px rgba(255, 183, 197, 0.15);
}

.card-header {
  display: flex;
  align-items: center;
  gap: 1rem;
  padding: 1.5rem;
  background: linear-gradient(135deg, #f8fafc, #f1f5f9);
  border-bottom: 1px solid #e2e8f0;
}

.header-badge {
  width: 2.5rem;
  height: 2.5rem;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 50%;
  background: linear-gradient(135deg, #FFB7C5, #FF9FB3);
  color: white;
  font-weight: 700;
  font-size: 1rem;
}

.header-title {
  flex: 1;
  font-size: 1.125rem;
  font-weight: 600;
  color: #1e293b;
}

.header-edit {
  background: none;
  border: none;
  color: #64748b;
  cursor: pointer;
  font-size: 1.125rem;
  padding: 0.5rem;
  opacity: 0.6;
  transition: opacity 200ms;
}

.header-edit:hover {
  opacity: 1;
}

.card-body {
  padding: 2rem 1.5rem;
}

.card-footer {
  display: flex;
  gap: 1rem;
  padding: 1.5rem;
  background: #f8fafc;
  border-top: 1px solid #e2e8f0;
}

.btn-primary {
  flex: 1;
  padding: 0.875rem 1.5rem;
  background: linear-gradient(135deg, #FFB7C5, #FF9FB3);
  color: white;
  border: none;
  border-radius: 8px;
  font-weight: 600;
  font-size: 0.95rem;
  cursor: pointer;
  transition: all 200ms;
  box-shadow: 0 4px 12px rgba(255, 183, 197, 0.3);
}

.btn-primary:hover:not(:disabled) {
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(255, 183, 197, 0.4);
}

.btn-primary:active:not(:disabled) {
  transform: translateY(0);
}

.btn-primary:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

.btn-secondary {
  padding: 0.875rem 1.5rem;
  background: #f1f5f9;
  color: #1e293b;
  border: 1px solid #e2e8f0;
  border-radius: 8px;
  font-weight: 600;
  cursor: pointer;
  transition: all 200ms;
}

.btn-secondary:hover {
  background: #e2e8f0;
}

/* Dark Mode */
html.dark .checkout-card {
  background: #1e293b;
  border-color: #334155;
}

html.dark .card-header {
  background: linear-gradient(135deg, #0f172a, #1e293b);
}

html.dark .header-title {
  color: #f1f5f9;
}

html.dark .btn-secondary {
  background: #334155;
  color: #f1f5f9;
  border-color: #475569;
}

@media (max-width: 768px) {
  .card-footer {
    flex-direction: column;
  }
}
```

---

### 3. FORM INPUT FIELD

**HTML Structure:**
```html
<div class="form-group">
  <label for="email" class="form-label">Email Address</label>
  
  <input 
    type="email" 
    id="email" 
    name="email"
    class="form-input"
    required
    placeholder="you@example.com"
    autocomplete="email"
    data-validate="email"
  />
  
  <span class="field-hint">
    We'll send your order confirmation here
  </span>
  
  <span class="field-error" style="display: none;">
    Please enter a valid email address
  </span>
  
  <span class="field-success" style="display: none;">
    ✓ Looks good!
  </span>
</div>
```

**CSS Styling:**
```css
.form-group {
  margin-bottom: 1.25rem;
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.form-label {
  font-size: 0.875rem;
  font-weight: 600;
  color: #1e293b;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.form-input {
  padding: 0.75rem 1rem;
  border: 1px solid #cbd5e1;
  border-radius: 8px;
  font-size: 1rem;
  background: #f8fafc;
  color: #1e293b;
  transition: all 150ms cubic-bezier(0.4, 0, 0.2, 1);
  font-family: inherit;
}

.form-input::placeholder {
  color: #cbd5e1;
}

.form-input:focus {
  outline: none;
  border-color: #FFB7C5;
  background: white;
  box-shadow: 0 0 0 3px rgba(255, 183, 197, 0.1), 
              0 4px 12px rgba(255, 183, 197, 0.2);
}

.form-input.valid {
  border-color: #22c55e;
  background: rgba(34, 197, 94, 0.02);
}

.form-input.error {
  border-color: #ef4444;
  background: rgba(239, 68, 68, 0.02);
}

.form-hint {
  font-size: 0.8125rem;
  color: #64748b;
  line-height: 1.4;
}

.field-error {
  font-size: 0.8125rem;
  color: #ef4444;
  font-weight: 500;
  animation: fadeIn 200ms ease-in;
}

.field-success {
  font-size: 0.8125rem;
  color: #22c55e;
  font-weight: 500;
  animation: fadeIn 200ms ease-in;
}

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(-4px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* Textarea variant */
textarea.form-input {
  resize: vertical;
  min-height: 120px;
  line-height: 1.5;
}

/* Dark Mode */
html.dark .form-label {
  color: #f1f5f9;
}

html.dark .form-input {
  background: #334155;
  border-color: #475569;
  color: #f1f5f9;
}

html.dark .form-input:focus {
  box-shadow: 0 0 0 3px rgba(255, 183, 197, 0.1),
              0 4px 12px rgba(255, 183, 197, 0.15);
}
```

---

### 4. ORDER SUMMARY (Sticky)

**HTML Structure:**
```html
<aside class="order-summary">
  <div class="summary-header">
    <h3 class="summary-title">Order Summary</h3>
    <button class="summary-toggle" aria-label="Toggle summary">
      ▼
    </button>
  </div>
  
  <div class="summary-content">
    <div class="summary-items">
      <div class="summary-item">
        <span class="item-name">Custom Character Design</span>
        <span class="item-price">$30.00</span>
      </div>
      
      <div class="summary-item">
        <span class="item-name">Sticker Sheet (10pcs)</span>
        <span class="item-price">$15.00</span>
      </div>
      
      <div class="summary-item">
        <span class="item-name">Shipping</span>
        <span class="item-price">$5.00</span>
      </div>
    </div>
    
    <div class="summary-divider"></div>
    
    <div class="summary-totals">
      <div class="summary-row">
        <span>Subtotal</span>
        <span>$45.00</span>
      </div>
      
      <div class="summary-row">
        <span>Shipping</span>
        <span>$5.00</span>
      </div>
      
      <div class="summary-row">
        <span>Tax</span>
        <span>$4.00</span>
      </div>
      
      <div class="summary-row total">
        <span>Total</span>
        <span class="total-price">$54.00</span>
      </div>
    </div>
    
    <details class="coupon-section">
      <summary class="coupon-toggle">
        + Add Coupon Code
        <span class="toggle-icon">▼</span>
      </summary>
      
      <div class="coupon-content">
        <input 
          type="text" 
          class="form-input coupon-input" 
          placeholder="Coupon code..."
        />
        <button class="btn-apply">Apply</button>
      </div>
    </details>
    
    <div class="summary-trust">
      <div class="trust-item">
        <span class="trust-icon">🔒</span>
        <span class="trust-text">SSL Secure</span>
      </div>
      
      <div class="trust-item">
        <span class="trust-icon">✓</span>
        <span class="trust-text">30-Day Returns</span>
      </div>
    </div>
  </div>
  
  <button class="btn-complete">Complete Purchase</button>
</aside>
```

**CSS Styling:**
```css
.order-summary {
  background: white;
  border: 1px solid #e2e8f0;
  border-radius: 16px;
  padding: 1.5rem;
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

/* Desktop Sticky */
@media (min-width: 1024px) {
  .order-summary {
    position: sticky;
    top: 2rem;
    max-height: calc(100vh - 4rem);
    overflow-y: auto;
  }
}

.summary-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 1rem;
}

.summary-title {
  font-size: 1.125rem;
  font-weight: 700;
  color: #1e293b;
  margin: 0;
}

.summary-toggle {
  display: none;
  background: none;
  border: none;
  cursor: pointer;
  color: #64748b;
  font-size: 1rem;
  padding: 0;
}

.summary-content {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.summary-items {
  display: flex;
  flex-direction: column;
  gap: 0.75rem;
  max-height: 300px;
  overflow-y: auto;
}

.summary-item {
  display: flex;
  justify-content: space-between;
  font-size: 0.95rem;
  color: #475569;
}

.item-name {
  flex: 1;
}

.item-price {
  font-weight: 600;
  color: #1e293b;
}

.summary-divider {
  height: 1px;
  background: #e2e8f0;
  margin: 0.5rem 0;
}

.summary-totals {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.summary-row {
  display: flex;
  justify-content: space-between;
  font-size: 0.95rem;
  color: #475569;
}

.summary-row.total {
  font-weight: 700;
  font-size: 1.125rem;
  color: #1e293b;
  padding-top: 0.5rem;
  border-top: 2px solid #e2e8f0;
}

.total-price {
  color: #FFB7C5;
  font-size: 1.25rem;
}

/* Coupon Section */
.coupon-section {
  margin: 0.5rem 0;
}

.coupon-toggle {
  display: flex;
  justify-content: space-between;
  align-items: center;
  cursor: pointer;
  color: #FFB7C5;
  font-weight: 600;
  font-size: 0.95rem;
  background: none;
  border: none;
  padding: 0.5rem 0;
  user-select: none;
}

.coupon-toggle:hover {
  color: #FF9FB3;
}

.coupon-content {
  display: flex;
  gap: 0.5rem;
  margin-top: 0.75rem;
}

.coupon-input {
  flex: 1;
  font-size: 0.875rem;
  padding: 0.5rem;
}

.btn-apply {
  padding: 0.5rem 1rem;
  background: #e2e8f0;
  border: none;
  border-radius: 6px;
  color: #1e293b;
  font-weight: 600;
  cursor: pointer;
  font-size: 0.875rem;
  transition: all 150ms;
}

.btn-apply:hover {
  background: #cbd5e1;
}

/* Trust Signals */
.summary-trust {
  display: flex;
  flex-direction: column;
  gap: 0.75rem;
  padding: 1rem;
  background: #f8fafc;
  border-radius: 8px;
}

.trust-item {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  font-size: 0.875rem;
  color: #64748b;
}

.trust-icon {
  font-size: 1.125rem;
}

.btn-complete {
  width: 100%;
  padding: 1rem;
  background: linear-gradient(135deg, #FFB7C5, #FF9FB3);
  color: white;
  border: none;
  border-radius: 8px;
  font-weight: 700;
  font-size: 1rem;
  cursor: pointer;
  transition: all 200ms;
  box-shadow: 0 4px 12px rgba(255, 183, 197, 0.3);
  margin-top: auto;
}

.btn-complete:hover:not(:disabled) {
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(255, 183, 197, 0.4);
}

.btn-complete:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

/* Mobile */
@media (max-width: 1023px) {
  .order-summary {
    border: none;
    background: transparent;
    padding: 1rem 0;
    position: static;
    margin-top: 1.5rem;
  }
  
  .summary-toggle {
    display: block;
  }
  
  .order-summary[open] .toggle-icon {
    transform: rotate(180deg);
  }
}

/* Dark Mode */
html.dark .order-summary {
  background: #1e293b;
  border-color: #334155;
}

html.dark .summary-title {
  color: #f1f5f9;
}

html.dark .trust-item {
  color: #cbd5e1;
}

html.dark .summary-trust {
  background: #334155;
}
```

---

### 5. PRIMARY CTA BUTTON

**HTML:**
```html
<button 
  class="btn-complete" 
  id="place-order-btn"
  aria-label="Complete your purchase"
>
  <span class="btn-text">Complete Purchase</span>
  <span class="btn-loader" style="display: none;">
    <span class="spinner"></span>
  </span>
</button>
```

**CSS:**
```css
.btn-complete {
  position: relative;
  width: 100%;
  padding: 1rem 2rem;
  background: linear-gradient(135deg, #FFB7C5, #FF9FB3);
  color: white;
  border: none;
  border-radius: 8px;
  font-weight: 700;
  font-size: 1rem;
  letter-spacing: 0.3px;
  cursor: pointer;
  transition: all 200ms cubic-bezier(0.4, 0, 0.2, 1);
  box-shadow: 0 10px 25px rgba(255, 183, 197, 0.3);
  text-transform: uppercase;
  min-height: 48px;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.75rem;
}

.btn-complete:hover:not(:disabled) {
  transform: translateY(-2px) scale(1.02);
  box-shadow: 0 15px 35px rgba(255, 183, 197, 0.4);
}

.btn-complete:active:not(:disabled) {
  transform: translateY(0) scale(0.98);
}

.btn-complete:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

.btn-text {
  transition: opacity 150ms;
}

.btn-loader {
  display: flex;
  align-items: center;
  justify-content: center;
}

.spinner {
  display: inline-block;
  width: 16px;
  height: 16px;
  border: 2px solid rgba(255, 255, 255, 0.3);
  border-top-color: white;
  border-radius: 50%;
  animation: spin 1s linear infinite;
}

@keyframes spin {
  to {
    transform: rotate(360deg);
  }
}

.btn-complete.loading .btn-text {
  opacity: 0;
  position: absolute;
}

.btn-complete.loading .btn-loader {
  display: flex;
}

/* Mobile Sticky CTA */
@media (max-width: 768px) {
  .btn-complete.sticky {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    width: 100%;
    border-radius: 0;
    z-index: 40;
    padding: 1rem max(1rem, env(safe-area-inset-left)) 
             1rem max(1rem, env(safe-area-inset-right));
    box-shadow: 0 -4px 12px rgba(0, 0, 0, 0.1);
  }
}

/* Dark Mode */
html.dark .btn-complete {
  box-shadow: 0 10px 25px rgba(255, 183, 197, 0.2);
}
```

---

### 6. VALIDATION SYSTEM

**JavaScript Logic:**
```javascript
const ValidationRules = {
  email: {
    pattern: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
    message: 'Please enter a valid email address',
    example: 'example@mail.com'
  },
  phone: {
    pattern: /^[\d\s\-\+\(\)]{10,}$/,
    message: 'Please enter a valid phone number',
    example: '(123) 456-7890'
  },
  zipCode: {
    pattern: /^\d{5}(-\d{4})?$/,
    message: 'Please enter a valid ZIP code',
    example: '12345 or 12345-6789'
  },
  address: {
    minLength: 5,
    message: 'Please enter a complete address'
  }
};

class FormValidator {
  constructor(formElement) {
    this.form = formElement;
    this.setupListeners();
  }
  
  setupListeners() {
    this.form.addEventListener('blur', (e) => {
      if (e.target.classList.contains('form-input')) {
        this.validateField(e.target);
      }
    }, true);
    
    this.form.addEventListener('input', (e) => {
      if (e.target.classList.contains('form-input')) {
        this.clearFieldError(e.target);
      }
    });
  }
  
  validateField(field) {
    const fieldType = field.getAttribute('data-validate') || field.type;
    const rule = ValidationRules[fieldType];
    
    if (!rule) return true;
    
    const isValid = this.checkValidation(field.value, rule);
    
    if (!isValid) {
      this.showFieldError(field, rule.message);
      return false;
    } else {
      this.showFieldSuccess(field);
      return true;
    }
  }
  
  checkValidation(value, rule) {
    if (rule.pattern) {
      return rule.pattern.test(value);
    }
    if (rule.minLength) {
      return value.length >= rule.minLength;
    }
    return true;
  }
  
  showFieldError(field, message) {
    field.classList.remove('valid');
    field.classList.add('error');
    
    const errorSpan = field.nextElementSibling?.classList.contains('field-error')
      ? field.nextElementSibling
      : field.parentElement?.querySelector('.field-error');
    
    if (errorSpan) {
      errorSpan.textContent = message;
      errorSpan.style.display = 'block';
    }
  }
  
  showFieldSuccess(field) {
    field.classList.remove('error');
    field.classList.add('valid');
    
    const errorSpan = field.parentElement?.querySelector('.field-error');
    if (errorSpan) {
      errorSpan.style.display = 'none';
    }
  }
  
  clearFieldError(field) {
    field.classList.remove('error', 'valid');
    const errorSpan = field.parentElement?.querySelector('.field-error');
    if (errorSpan) {
      errorSpan.style.display = 'none';
    }
  }
  
  validateAll() {
    const fields = this.form.querySelectorAll('input[required], textarea[required]');
    let isValid = true;
    
    fields.forEach(field => {
      if (!this.validateField(field)) {
        isValid = false;
      }
    });
    
    return isValid;
  }
}

// Usage
const checkoutForm = document.querySelector('form.checkout-form');
const validator = new FormValidator(checkoutForm);
```

---

## MOBILE-SPECIFIC ENHANCEMENTS

### Sticky Bottom CTA

```javascript
class StickyCTA {
  constructor(buttonElement, triggerOffset = 200) {
    this.button = buttonElement;
    this.triggerOffset = triggerOffset;
    this.handleScroll = this.handleScroll.bind(this);
    this.setupListeners();
  }
  
  setupListeners() {
    window.addEventListener('scroll', this.handleScroll, { passive: true });
    window.addEventListener('resize', this.handleScroll);
  }
  
  handleScroll() {
    const isFormBelowViewport = 
      document.querySelector('form').getBoundingClientRect().bottom < window.innerHeight;
    
    if (isFormBelowViewport) {
      this.button.classList.add('sticky');
    } else {
      this.button.classList.remove('sticky');
    }
  }
  
  destroy() {
    window.removeEventListener('scroll', this.handleScroll);
    window.removeEventListener('resize', this.handleScroll);
  }
}
```

---

## ACCESSIBILITY CHECKLIST

- [ ] Form labels properly associated with inputs (id/for)
- [ ] ARIA labels on icon-only buttons
- [ ] ARIA live regions for validation messages
- [ ] Keyboard navigation (Tab through form fields)
- [ ] Focus indicators visible (pink outline)
- [ ] Color not sole indicator (success state uses checkmark too)
- [ ] Contrast ratios meet WCAG AA (4.5:1 for text)
- [ ] Error messages linked to fields with aria-describedby
- [ ] Loading states announced with aria-label
- [ ] Form submit prevented with aria-disabled while processing

---

## PERFORMANCE OPTIMIZATION

**Critical metrics:**
- First Input Delay (FID): < 100ms
- Cumulative Layout Shift (CLS): < 0.1
- Largest Contentful Paint (LCP): < 2.5s

**Recommendations:**
- Debounce validation (200ms)
- Lazy load payment gateway iframes
- Minimize reflows during form interactions
- Use `will-change: transform` on CTA button
- Compress form assets

---

**Version**: 1.0 Component Reference  
**Last Updated**: May 6, 2026
