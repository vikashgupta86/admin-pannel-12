
const socialTool = document.getElementById('socialTool');
const socialBtn = document.getElementById('socialBtn');
const panelLinks = socialTool.querySelectorAll('.social-panel a');

let isLocked = false;

function openDropdown(lock = false) {
  socialTool.classList.add('open');
  socialBtn.setAttribute('aria-expanded', 'true');
  if (lock) isLocked = true;
}

function closeDropdown(force = false) {
  if (!isLocked || force) {
    socialTool.classList.remove('open');
    socialBtn.setAttribute('aria-expanded', 'false');
    isLocked = false;
  }
}

socialTool.addEventListener('mouseenter', () => {
  if (!isLocked) openDropdown();
});
socialTool.addEventListener('mouseleave', () => {
  if (!isLocked) closeDropdown();
});
socialBtn.addEventListener('click', e => {
  e.preventDefault();
  e.stopPropagation();
  openDropdown(true);
});
socialBtn.addEventListener('focus', () => {
  if (!isLocked) openDropdown();
});
socialBtn.addEventListener('keydown', e => {
  if (e.key === 'Enter') {
    e.preventDefault();
    openDropdown(true);
    panelLinks[0]?.focus();
  }
  if (e.key === 'Escape') {
    e.preventDefault();
    closeDropdown(true);
  }
});
socialBtn.addEventListener('keyup', e => {
  if (e.key === ' ') {
    e.preventDefault();
    openDropdown(true);
    panelLinks[0]?.focus();
  }
});
panelLinks.forEach(link => {
  link.addEventListener('keydown', e => {
    if (e.key === 'Escape') {
      e.preventDefault();
      closeDropdown(true);
      socialBtn.focus();
    }
  });
});
socialTool.addEventListener('focusout', () => {
  requestAnimationFrame(() => {
    if (!socialTool.contains(document.activeElement) && !isLocked) {
      closeDropdown();
    }
  });
});
document.addEventListener('click', e => {
  if (!socialTool.contains(e.target)) {
    closeDropdown(true);
  }
});




function goBack() {
    // Navigates to the previous page in the browser history
    window.history.back();
}


function printSpecificContent(elementId) {
    const element = document.getElementById(elementId);
    
    if (!element) {
        console.error("Print Error: Element with ID '" + elementId + "' not found.");
        alert("Content area not found for printing.");
        return;
    }

    const content = element.innerHTML;
    const pri = document.createElement('iframe');
    pri.style.position = 'absolute';
    pri.style.top = '-1000px';
    document.body.appendChild(pri);
    
    const priDoc = pri.contentWindow.document;
    priDoc.open();
    priDoc.write(`<html><head><title>Print</title><style>body{font-family:sans-serif;padding:20px;}</style></head><body>${content}</body></html>`);
    priDoc.close();
    
    pri.contentWindow.focus();
    pri.contentWindow.print();
    
    setTimeout(() => { document.body.removeChild(pri); }, 1000);
}