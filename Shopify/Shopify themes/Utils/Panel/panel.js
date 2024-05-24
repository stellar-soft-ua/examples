class Panel extends HTMLElement {
  constructor() {
    super();

    this.isOpen = this.getAttribute('default-open') === 'true';
    this.alignment = this.getAttribute('alignment') || 'right';
    this.additionalClasses = this.getAttribute('additionalClasses') || '';
    this.context = this.getAttribute('context');

    this.updatePanelClass();

    this.handleOpenEvent = this.handleOpenEvent.bind(this);
    this.handleCloseEvent = this.handleCloseEvent.bind(this);
    this.handleToggleEvent = this.handleToggleEvent.bind(this);
  }

  slidePanelOpen() {
    document.querySelectorAll('[slidePanelOpen]').forEach(btn => {
      btn.addEventListener('click', () => {
        document.querySelector('html').classList.add('overflow');
        const triggerID = btn.getAttribute('slidePanelOpen');
        const slidePanel = document.querySelector(`slide-panel[slidePanelID="${triggerID}"]`);
        slidePanel.handleOpenEvent();
      });
    });
  }

  slidePanelClose() {
    document.querySelectorAll('[slidePanelClose]').forEach(btn => {
      btn.addEventListener('click', () => {
        const panel = btn.closest('slide-panel');
        if (panel) {
          document.querySelector('html').classList.remove('overflow');
          panel.handleCloseEvent();
        }
      });
    });
  }

  connectedCallback() {
    this.slidePanelOpen();
    this.slidePanelClose();

    this.triggers = {
      openTriggerEl: document.querySelector(this.getAttribute('openTriggerSelector')),
      closeTriggerEl: document.querySelector(this.getAttribute('closeTriggerSelector')),
      toggleEl: document.querySelector(this.getAttribute('toggleSelector')),
    };

    const { openTriggerEl, closeTriggerEl, toggleEl } = this.triggers;

    if (openTriggerEl) openTriggerEl.addEventListener('click', this.handleOpenEvent);
    if (closeTriggerEl) closeTriggerEl.addEventListener('click', this.handleCloseEvent);
    if (toggleEl) toggleEl.addEventListener('click', this.handleToggleEvent);
    if (this.context) {
      document.addEventListener(`${this.context}:open`, this.handleOpenEvent);
      document.addEventListener(`${this.context}:close`, this.handleCloseEvent);
    }
  }

  attributeChangedCallback(name, oldValue, newValue) {
    if (name === 'default-open') {
      this.isOpen = newValue === 'true';
      this.updatePanelClass();
    }
  }

  disconnectedCallback() {
    const { openTriggerEl, closeTriggerEl, toggleEl } = this.triggers;

    if (openTriggerEl) openTriggerEl.removeEventListener('click', this.handleOpenEvent);
    if (closeTriggerEl) closeTriggerEl.removeEventListener('click', this.handleCloseEvent);
    if (toggleEl) toggleEl.removeEventListener('click', this.handleToggleEvent);

    if (this.context) {
      document.removeEventListener(`${this.context}:open`, this.handleOpenEvent);
      document.removeEventListener(`${this.context}:close`, this.handleCloseEvent);
    }
  }

  handleOpenEvent() {
    this.isOpen = true;
    this.updatePanelClass();
  }

  handleCloseEvent() {
    this.isOpen = false;
    this.updatePanelClass();
  }

  handleToggleEvent() {
    this.isOpen = !this.isOpen;
    this.updatePanelClass();
  }

  static get observedAttributes() {
    return ['default-open'];
  }

  updatePanelClass() {
    let closedClass;
    let alignmentClass;
  
    if (this.alignment === 'popup') {
      alignmentClass = 'right-0 left-0 scale-0';
      closedClass = '';
    } else if (this.alignment === 'left') {
      alignmentClass = 'left-0 max-w-panel';
      closedClass = '-translate-x-full';
    } else if (this.alignment === 'right') {
      alignmentClass = 'right-0 max-w-panel';
      closedClass = 'translate-x-full';
    }
  
    this.className = `
      block
      w-full h-full
      fixed
      top-0
      bottom-0
      transition-transform
      z-40
      bg-white
      ${alignmentClass}
      ${this.isOpen ? 'translate-x-0 active' : closedClass}
      ${this.additionalClasses}`;
  }
}

customElements.define('slide-panel', Panel);
