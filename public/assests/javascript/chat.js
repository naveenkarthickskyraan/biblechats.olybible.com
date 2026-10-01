// Chat functionality with improved scroll behavior and optimized API calls
const form = document.querySelector(".typing-area");
const incoming_id = form ? form.querySelector(".incoming_id").value : null;
const inputField = form ? form.querySelector(".input-field") : null;
const sendBtn = form ? form.querySelector("button") : null;
const chatBox = document.querySelector(".chat-box");
const loadingIndicator = document.querySelector(".chat-box .loading-indicator");

// Initialize variables
let isScrolling = false;
let isUserScrolling = false;
let autoScrollEnabled = true;
let isChatBoxActive = false; // Track if mouse is in chat area
let fetchInterval = null; // Store interval ID
let lastMessageCount = 0; // Track message changes

// Prevent form default submission
if (form) {
    form.addEventListener('submit', (e) => {
        e.preventDefault();
    });
}

// Input field handlers
if (inputField) {
    inputField.focus();

    // Auto-resize textarea
    inputField.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = Math.min(this.scrollHeight, 120) + 'px';
        
        // Toggle send button active state
        if (sendBtn) {
            sendBtn.classList.toggle("active", this.value.trim() !== "");
        }
    });

    // Allow sending message with Enter key (Shift+Enter for new line)
    inputField.addEventListener('keypress', (e) => {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            if (sendBtn && sendBtn.classList.contains("active")) {
                sendBtn.click();
            }
        }
    });

    // Toggle send button on keyup as well
    inputField.addEventListener('keyup', () => {
        if (sendBtn) {
            sendBtn.classList.toggle("active", inputField.value.trim() !== "");
        }
    });
}

// Send chat message
if (sendBtn) {
    sendBtn.addEventListener('click', () => {
        if (!inputField.value.trim()) return;
        
        const formData = new FormData(form);
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);

        // Disable button temporarily
        sendBtn.disabled = true;
        
        fetch('/insert-chat', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (response.ok) {
                inputField.value = ""; // Clear input field
                inputField.style.height = 'auto'; // Reset height
                if (sendBtn) {
                    sendBtn.classList.remove("active");
                    sendBtn.disabled = false;
                }
                
                // Force immediate fetch after sending
                fetchMessages(true);
                scrollToBottom(true);
            }
        })
        .catch(error => {
            console.error('Error sending message:', error);
            if (sendBtn) {
                sendBtn.disabled = false;
            }
        });
    });
}

// Detect user scrolling
if (chatBox) {
    chatBox.addEventListener('scroll', () => {
        // Check if user is manually scrolling
        const scrollThreshold = 100; // pixels from bottom
        const isNearBottom = chatBox.scrollHeight - chatBox.scrollTop - chatBox.clientHeight < scrollThreshold;
        
        if (!isNearBottom) {
            isUserScrolling = true;
            autoScrollEnabled = false;
            
            // Re-enable auto-scroll after a delay if user stops scrolling
            clearTimeout(window.scrollTimeout);
            window.scrollTimeout = setTimeout(() => {
                isUserScrolling = false;
                
                // Check if we're near bottom again after delay
                const newPosition = chatBox.scrollHeight - chatBox.scrollTop - chatBox.clientHeight;
                if (newPosition < scrollThreshold) {
                    autoScrollEnabled = true;
                }
            }, 2000);
        } else {
            isUserScrolling = false;
            autoScrollEnabled = true;
        }
    });

    // PAUSE API calls when mouse enters chat box
    chatBox.addEventListener('mouseenter', () => {
        isChatBoxActive = true;
        chatBox.classList.add("active");
        pauseFetching();
        console.log('🛑 API calls paused - User is viewing messages');
    });

    // RESUME API calls when mouse leaves chat box
    chatBox.addEventListener('mouseleave', () => {
        isChatBoxActive = false;
        chatBox.classList.remove("active");
        resumeFetching();
        console.log('▶️ API calls resumed');
    });

    // Also pause when user is typing
    if (inputField) {
        inputField.addEventListener('focus', () => {
            pauseFetching();
            console.log('🛑 API calls paused - User is typing');
        });

        inputField.addEventListener('blur', () => {
            // Only resume if mouse is not in chat box
            if (!isChatBoxActive) {
                resumeFetching();
                console.log('▶️ API calls resumed');
            }
        });
    }
}

// Fetch messages function
function fetchMessages(forceScroll = false) {
    if (!incoming_id) return;
    
    fetch('/get-chat', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `incoming_id=${incoming_id}`
    })
    .then(response => response.text())
    .then(data => {
        if (chatBox) {
            const oldScrollHeight = chatBox.scrollHeight;
            const oldScrollTop = chatBox.scrollTop;
            const wasAtBottom = oldScrollTop + chatBox.clientHeight >= oldScrollHeight - 50;
            
            // Count messages to detect new ones
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = data;
            const newMessageCount = tempDiv.querySelectorAll('.chat').length;
            const hasNewMessages = newMessageCount > lastMessageCount;
            lastMessageCount = newMessageCount;
            
            chatBox.innerHTML = data;
            
            // Hide loading indicator
            if (loadingIndicator) {
                loadingIndicator.style.display = 'none';
            }
            
            // Smart scroll logic
            if (forceScroll || (autoScrollEnabled && !isUserScrolling && (wasAtBottom || hasNewMessages))) {
                setTimeout(() => scrollToBottom(true), 100);
            } else {
                // Maintain scroll position when new messages load
                const newScrollHeight = chatBox.scrollHeight;
                const heightDifference = newScrollHeight - oldScrollHeight;
                
                if (heightDifference > 0) {
                    chatBox.scrollTop = oldScrollTop + heightDifference;
                }
            }
        }
    })
    .catch(error => console.error('Error fetching messages:', error));
}

// Start fetching messages
function startFetching() {
    if (fetchInterval) return; // Already running
    
    // Fetch immediately first
    fetchMessages();
    
    // Then set interval
    fetchInterval = setInterval(() => {
        fetchMessages();
    }, 1000); // Check every second
    
    console.log('✅ Message fetching started');
}

// Pause fetching
function pauseFetching() {
    if (fetchInterval) {
        clearInterval(fetchInterval);
        fetchInterval = null;
        console.log('⏸️ Message fetching paused');
    }
}

// Resume fetching
function resumeFetching() {
    if (!fetchInterval && incoming_id) {
        startFetching();
        console.log('▶️ Message fetching resumed');
    }
}

// Scroll the chat box to the bottom
function scrollToBottom(animate = true) {
    if (!chatBox || isScrolling) return;
    
    isScrolling = true;
    
    if (animate) {
        chatBox.scrollTo({
            top: chatBox.scrollHeight,
            behavior: 'smooth'
        });
        
        // Reset scrolling flag after animation
        setTimeout(() => {
            isScrolling = false;
        }, 300);
    } else {
        chatBox.scrollTop = chatBox.scrollHeight;
        isScrolling = false;
    }
}

// Expose functions globally for potential use by other scripts
window.scrollToBottom = scrollToBottom;
window.enableAutoScroll = () => { autoScrollEnabled = true; };
window.disableAutoScroll = () => { autoScrollEnabled = false; };
window.pauseChatFetching = pauseFetching;
window.resumeChatFetching = resumeFetching;

// Initial setup on page load
document.addEventListener('DOMContentLoaded', function() {
    // Initial scroll to bottom
    setTimeout(() => {
        scrollToBottom(false);
    }, 500);
    
    // Start fetching if we have an incoming_id
    if (incoming_id) {
        startFetching();
    }
});

// Cleanup on page unload
window.addEventListener('beforeunload', function() {
    pauseFetching();
});

// Handle visibility change (tab switching)
document.addEventListener('visibilitychange', function() {
    if (document.hidden) {
        // Tab is hidden, pause fetching
        pauseFetching();
        console.log('🌙 Tab hidden - API calls paused');
    } else {
        // Tab is visible again, resume if not in chat area
        if (!isChatBoxActive && !inputField?.matches(':focus')) {
            resumeFetching();
            console.log('☀️ Tab visible - API calls resumed');
        }
    }
});

// Optional: Add visual indicator when API is paused (for debugging)
if (chatBox) {
    const indicator = document.createElement('div');
    indicator.style.cssText = `
        position: fixed;
        bottom: 20px;
        right: 20px;
        background: rgba(255, 107, 107, 0.9);
        color: white;
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        display: none;
        z-index: 9999;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        animation: fadeIn 0.3s ease;
    `;
    indicator.textContent = '⏸️ Auto-refresh paused';
    indicator.id = 'api-pause-indicator';
    document.body.appendChild(indicator);
    
    // Show/hide indicator
    chatBox.addEventListener('mouseenter', () => {
        indicator.style.display = 'block';
    });
    
    chatBox.addEventListener('mouseleave', () => {
        indicator.style.display = 'none';
    });
    
    if (inputField) {
        inputField.addEventListener('focus', () => {
            indicator.style.display = 'block';
        });
        
        inputField.addEventListener('blur', () => {
            if (!isChatBoxActive) {
                indicator.style.display = 'none';
            }
        });
    }
}

console.log('💬 Chat system initialized with smart API management');