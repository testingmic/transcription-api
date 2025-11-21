// Main JavaScript for Transcription App Website

// Mobile menu toggle
function initMobileMenu() {
    const menuBtn = document.getElementById('mobile-menu-btn');
    const menu = document.getElementById('mobile-menu');
    
    if (menuBtn && menu) {
        menuBtn.addEventListener('click', function() {
            const isHidden = menu.classList.contains('hidden');
            menu.classList.toggle('hidden');
            menuBtn.setAttribute('aria-expanded', isHidden ? 'true' : 'false');
            // Animate hamburger icon
            const icon = menuBtn.querySelector('svg');
            if (icon) {
                icon.classList.toggle('rotate-90');
            }
        });
    }
}

// Navbar scroll effect
function initNavbarScroll() {
    const navbar = document.getElementById('navbar');
    
    if (navbar) {
        window.addEventListener('scroll', function() {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    }
}

// Smooth scroll to sections
function initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            if (href === '#' || href === '') return;
            
            e.preventDefault();
            const target = document.querySelector(href);
            
            if (target) {
                const offsetTop = target.offsetTop - 80; // Account for fixed navbar
                window.scrollTo({
                    top: offsetTop,
                    behavior: 'smooth'
                });
                
                // Close mobile menu if open
                const mobileMenu = document.getElementById('mobile-menu');
                if (mobileMenu && !mobileMenu.classList.contains('hidden')) {
                    mobileMenu.classList.add('hidden');
                }
            }
        });
    });
}

// Intersection Observer for fade-in animations
function initScrollAnimations() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                // Optional: stop observing after animation
                // observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // Observe all fade-in elements
    document.querySelectorAll('.fade-in-on-scroll').forEach(el => {
        observer.observe(el);
    });
}

// FAQ Accordion functionality
function initFAQ() {
    const faqItems = document.querySelectorAll('.faq-item');
    
    faqItems.forEach(item => {
        const question = item.querySelector('.faq-question');
        
        if (question) {
            question.addEventListener('click', function() {
                // Close other items
                faqItems.forEach(otherItem => {
                    if (otherItem !== item && otherItem.classList.contains('active')) {
                        otherItem.classList.remove('active');
                        const otherIcon = otherItem.querySelector('.faq-icon');
                        if (otherIcon) {
                            otherIcon.style.transform = 'rotate(0deg)';
                        }
                    }
                });
                
                // Toggle current item
                item.classList.toggle('active');
                const icon = item.querySelector('.faq-icon');
                if (icon) {
                    if (item.classList.contains('active')) {
                        icon.style.transform = 'rotate(180deg)';
                    } else {
                        icon.style.transform = 'rotate(0deg)';
                    }
                }
            });
        }
    });
}

// Form validation for data deletion request
function initDataDeletionForm() {
    const form = document.getElementById('deletion-form');
    
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get form values
            const email = document.getElementById('email').value;
            const confirmDeletion = document.getElementById('confirm-deletion').checked;
            
            // Basic validation
            if (!email || !isValidEmail(email)) {
                showFormError('Please enter a valid email address');
                return;
            }
            
            if (!confirmDeletion) {
                showFormError('Please confirm that you understand this action is permanent');
                return;
            }

            const reason = document.getElementById('reason').value;
            const comments = document.getElementById('comments').value;
            
            // Show loading state
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            submitBtn.disabled = true;
            submitBtn.textContent = 'Submitting...';
            
            // Simulate API call (replace with actual API call)
            setTimeout(() => {
                // Hide form
                form.style.display = 'none';

                // In production, you would send the form data to your server:
                // const formData = new FormData(form);
                fetch(`${baseUrl}/api/general/leave`, {
                    method: 'POST',
                    body: JSON.stringify({
                        email: email,
                        reason: reason,
                        comments: comments
                    })
                })
                .then(response => response.json())
                .then(data => {
                    // Show success message
                    const successMessage = document.getElementById('success-message');
                    if (successMessage) {
                        successMessage.classList.remove('hidden');
                        successMessage.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                    }
                })
                .catch(error => {
                    // Handle error
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;
                    showFormError(error.message || error.data.data);
                });
            }, 1000);
        });
    }
}

// Email validation helper
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// Show form error message
function showFormError(message) {
    // Remove existing error message
    const existingError = document.querySelector('.form-error');
    if (existingError) {
        existingError.remove();
    }
    
    // Create error message
    const errorDiv = document.createElement('div');
    errorDiv.className = 'form-error bg-red-50 border-l-4 border-red-400 p-4 mb-4 rounded';
    errorDiv.innerHTML = `
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-red-700">${message}</p>
            </div>
        </div>
    `;
    
    // Insert error message before form
    const form = document.getElementById('deletion-form');
    if (form) {
        form.parentNode.insertBefore(errorDiv, form);
    }
}

// Copy email to clipboard
function initCopyEmail() {
    const emailLinks = document.querySelectorAll('[data-copy-email]');
    
    emailLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const email = this.getAttribute('data-copy-email') || this.textContent.trim();
            
            navigator.clipboard.writeText(email).then(() => {
                // Show feedback
                const originalText = this.textContent;
                this.textContent = 'Copied!';
                this.classList.add('text-green-600');
                
                setTimeout(() => {
                    this.textContent = originalText;
                    this.classList.remove('text-green-600');
                }, 2000);
            }).catch(err => {
                console.error('Failed to copy email:', err);
            });
        });
    });
}

// Lazy load images
function initLazyLoading() {
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    if (img.dataset.src) {
                        img.src = img.dataset.src;
                        img.classList.remove('lazy');
                        imageObserver.unobserve(img);
                    }
                }
            });
        });

        document.querySelectorAll('img.lazy').forEach(img => {
            imageObserver.observe(img);
        });
    }
}

// Contact form handler
function initContactForm() {
    const form = document.getElementById('contact-form');
    const messageField = document.getElementById('message');
    const charCount = document.getElementById('char-count');
    
    if (!form) return;
    
    // Character counter
    if (messageField && charCount) {
        messageField.addEventListener('input', function() {
            const count = this.value.length;
            charCount.textContent = `${count} / 2000 characters`;
        });
    }
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const submitBtn = document.getElementById('submit-btn');
        const submitText = document.getElementById('submit-text');
        const submitLoading = document.getElementById('submit-loading');
        const formError = document.getElementById('form-error');
        const successMessage = document.getElementById('success-message');
        
        // Reset errors
        formError.classList.add('hidden');
        document.querySelectorAll('.text-red-600').forEach(el => {
            el.classList.add('hidden');
        });
        
        // Get form data
        const formData = new FormData(form);
        const data = Object.fromEntries(formData);
        
        // Basic validation
        let hasErrors = false;
        if (!data.name || data.name.length < 2) {
            showFieldError('name', 'Name must be at least 2 characters');
            hasErrors = true;
        }
        if (!data.email || !isValidEmail(data.email)) {
            showFieldError('email', 'Please enter a valid email address');
            hasErrors = true;
        }
        if (!data.subject) {
            showFieldError('subject', 'Please select a subject');
            hasErrors = true;
        }
        if (!data.message || data.message.length < 10) {
            showFieldError('message', 'Message must be at least 10 characters');
            hasErrors = true;
        }
        
        if (hasErrors) return;
        
        // Show loading state
        submitBtn.disabled = true;
        submitText.classList.add('hidden');
        submitLoading.classList.remove('hidden');
        
        // Submit form
        fetch(`${baseUrl}contact`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                form.reset();
                if (charCount) charCount.textContent = '0 / 2000 characters';
                successMessage.classList.remove('hidden');
                successMessage.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            } else {
                showFormError(data.message || 'An error occurred. Please try again.');
            }
        })
        .catch(error => {
            showFormError('Network error. Please check your connection and try again.');
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitText.classList.remove('hidden');
            submitLoading.classList.add('hidden');
        });
    });
}

function showFieldError(fieldName, message) {
    const errorEl = document.getElementById(`${fieldName}-error`);
    if (errorEl) {
        errorEl.textContent = message;
        errorEl.classList.remove('hidden');
    }
}

// Newsletter form handler
function initNewsletterForm() {
    const form = document.getElementById('newsletter-form');
    if (!form) return;
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const email = document.getElementById('newsletter-email').value;
        
        if (!isValidEmail(email)) {
            alert('Please enter a valid email address');
            return;
        }
        
        // TODO: Implement newsletter subscription API call
        alert('Thank you for subscribing!');
        form.reset();
    });
}

// Cookie consent handler
function initCookieConsent() {
    const consentBanner = document.getElementById('cookie-consent');
    const acceptBtn = document.getElementById('cookie-accept');
    const declineBtn = document.getElementById('cookie-decline');
    
    if (!consentBanner) return;
    
    // Check if user has already made a choice
    const consent = localStorage.getItem('cookieConsent');
    if (consent) {
        return; // Don't show banner if choice already made
    }
    
    // Show banner after a short delay
    setTimeout(() => {
        consentBanner.classList.remove('hidden');
    }, 1000);
    
    if (acceptBtn) {
        acceptBtn.addEventListener('click', function() {
            localStorage.setItem('cookieConsent', 'accepted');
            consentBanner.classList.add('hidden');
        });
    }
    
    if (declineBtn) {
        declineBtn.addEventListener('click', function() {
            localStorage.setItem('cookieConsent', 'declined');
            consentBanner.classList.add('hidden');
        });
    }
}


// Initialize all features when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    initMobileMenu();
    initNavbarScroll();
    initSmoothScroll();
    initScrollAnimations();
    initFAQ();
    initDataDeletionForm();
    initContactForm();
    initNewsletterForm();
    initCookieConsent();
    initCopyEmail();
    initLazyLoading();
    
    // Add stagger delay to feature cards
    const featureCards = document.querySelectorAll('.feature-card');
    featureCards.forEach((card, index) => {
        card.style.transitionDelay = `${index * 0.1}s`;
    });
});

// Handle page load animations
window.addEventListener('load', function() {
    document.body.classList.add('loaded');
});

