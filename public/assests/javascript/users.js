/**
 * Users List Management with Auto-Scroll to Active User
 * Fixed and optimized scroll logic
 */

$(document).ready(function() {
    const $searchBar = $(".search input");
    const $searchIcon = $(".search button");
    const $usersList = $(".users-list");
    
    // SCROLL CONFIGURATION - Perfect Center Alignment
    const SCROLL_CONFIG = {
        centerOffset: -150,        // 0 = Perfect center
        animationSpeed: 800,    // Smooth animation
        scrollBlock: 'center',  // Center alignment
        debug: true            // Show console logs
    };
    
    /**
     * Scroll active user to center of users list
     * Fixed version with better position calculation
     */
    function scrollActiveUserToCenter() {
        // Get active user ID from hidden input and clean it
        let activeUserId = $('.incoming_id').val();
        
        console.log('Attempting to scroll to user:', activeUserId); // Debug log
        
        // Exit if no active user ID
        if (!activeUserId) {
            console.log('No active user ID found');
            return;
        }
        
        // Clean the user ID - trim whitespace
        activeUserId = String(activeUserId).trim();
        console.log('Cleaned user ID:', activeUserId);
        
        // Find active user element using attribute selector (safer for IDs with special chars)
        let $activeUser = $usersList.find(`a[id="${activeUserId}"]`);
        if (!$activeUser.length) {
            $activeUser = $usersList.find(`a.cdd_${activeUserId}`);
        }
        
        console.log('Active user element found:', $activeUser.length > 0); // Debug log
        
        // Check if active user exists in list and list container exists
        if ($activeUser.length && $usersList.length) {
            try {
                // Get the active user's position within the scrollable container
                const userPosition = $activeUser.position().top;
                const currentScroll = $usersList.scrollTop();
                
                // Get dimensions
                const containerHeight = $usersList.outerHeight();
                const elementHeight = $activeUser.outerHeight();
                
                // Calculate target scroll position with configurable offset
                // Position the top of the element at: (containerHeight / 2) - (elementHeight / 2) + offset
                const centerPosition = (containerHeight / 2) - (elementHeight / 2);
                const targetScroll = currentScroll + userPosition - centerPosition + SCROLL_CONFIG.centerOffset;
                
                console.log('Scroll calculation:', {
                    userPosition: userPosition,
                    currentScroll: currentScroll,
                    containerHeight: containerHeight,
                    elementHeight: elementHeight,
                    centerPosition: centerPosition,
                    centerOffset: SCROLL_CONFIG.centerOffset,
                    targetScroll: targetScroll,
                    finalScroll: Math.max(0, targetScroll)
                }); // Debug log
                
                // Smooth scroll to calculated position (prevent negative scroll)
                $usersList.animate({
                    scrollTop: Math.max(0, targetScroll)
                }, SCROLL_CONFIG.animationSpeed, 'swing', function() {
                    console.log('Scroll completed'); // Debug log
                });
                
            } catch (error) {
                console.error('Error during scroll calculation:', error);
            }
        } else {
            console.log('Active user or list not found in DOM');
        }
    }
    
    /**
     * Alternative scroll method using scrollIntoView
     * More reliable cross-browser solution
     */
    function scrollActiveUserToCenter_Alternative() {
        let activeUserId = $('.incoming_id').val();
        
        if (!activeUserId) return;
        
        // Clean the user ID
        activeUserId = String(activeUserId).trim();
        
        let $activeUser = $usersList.find(`a[id="${activeUserId}"]`);
        if (!$activeUser.length) {
            $activeUser = $usersList.find(`a.cdd_${activeUserId}`);
        }
        
        if ($activeUser.length) {
            const element = $activeUser[0];
            
            // Use native scrollIntoView with smooth behavior
            element.scrollIntoView({
                behavior: 'smooth',
                block: 'center',
                inline: 'nearest'
            });
        }
    }
    
    /**
     * Robust scroll function that tries multiple methods
     */
    function scrollToActiveUser() {
        let activeUserId = $('.incoming_id').val();
        
        if (!activeUserId) {
            console.log('No active user ID');
            return;
        }
        
        // Clean the user ID - remove spaces and special characters that break selectors
        activeUserId = String(activeUserId).trim();
        
        console.log('Cleaned active user ID:', activeUserId);
        
        // Wait for DOM to be ready
        setTimeout(function() {
            // Use attribute selector instead of ID selector to handle special characters
            let $activeUser = $usersList.find(`a[id="${activeUserId}"]`);
            if (!$activeUser.length) {
                $activeUser = $usersList.find(`a.cdd_${activeUserId}`);
            }
            
            if ($activeUser.length) {
                console.log('Active user found, scrolling...'); // Debug
                
                // Method 1: Try jQuery animate with improved calculation
                try {
                    const userPosition = $activeUser.position().top;
                    const containerHeight = $usersList.height();
                    const elementHeight = $activeUser.outerHeight();
                    const currentScroll = $usersList.scrollTop();
                    
                    // Center calculation with configurable offset
                    const centerPosition = (containerHeight / 2) - (elementHeight / 2);
                    const scrollTo = currentScroll + userPosition - centerPosition + SCROLL_CONFIG.centerOffset;
                    
                    console.log('Scroll details:', {
                        userPosition,
                        containerHeight,
                        elementHeight,
                        currentScroll,
                        centerPosition,
                        offset: SCROLL_CONFIG.centerOffset,
                        scrollTo: Math.max(0, scrollTo)
                    });
                    
                    $usersList.stop().animate({
                        scrollTop: Math.max(0, scrollTo)
                    }, SCROLL_CONFIG.animationSpeed);
                    
                } catch (e) {
                    console.log('jQuery scroll failed, trying native method');
                    
                    // Method 2: Fallback to native scrollIntoView
                    try {
                        $activeUser[0].scrollIntoView({
                            behavior: 'smooth',
                            block: SCROLL_CONFIG.scrollBlock
                        });
                    } catch (e2) {
                        console.error('Both scroll methods failed', e2);
                    }
                }
            } else {
                console.log('Active user not found in list');
            }
        }, 100);
    }
    
    /**
     * Toggle search bar visibility
     */
    $searchIcon.on('click', function() {
        $searchBar.toggleClass("show").focus();
        $searchIcon.toggleClass("active");
        
        if (!$searchBar.hasClass("show")) {
            $searchBar.val("").removeClass("active");
            fetchUsers();
        }
    });
    
    /**
     * Handle search input
    */
    $searchBar.on('keyup', function() {
        const searchTerm = $searchBar.val().trim();
        $searchBar.toggleClass("active", searchTerm !== "");
        
        if (searchTerm !== "") {
            searchUsers(searchTerm);
        } else {
            fetchUsers();
        }
    });
    
    /**
     * Search users by name
     */
    const searchUsers = (searchTerm) => {
        $.ajax({
            url: "/users-search",
            type: "POST",
            data: {
                searchTerm: searchTerm,
                _token: $("meta[name='csrf-token']").attr("content")
            },
            success: function(data) {
                $usersList.html(data);
                // Scroll after search results are rendered
                setTimeout(scrollToActiveUser, 200);
            },
            error: function(xhr, status, error) {
                console.error('Error searching users:', error);
            }
        });
    };
    
    /**
     * Fetch all users from server
     */
    function fetchUsers() {
        if ($searchBar.val().trim() === "") {
            $.ajax({
                url: '/users-list',
                method: 'GET',
                success: function(response) {
                    $usersList.empty();
    
                    if (response.message) {
                        $usersList.append("<p>" + response.message + "</p>");
                    } else {
                        response.forEach(user => {
                            let userElement = `
                                <a class="cdd_${user.user_id}  mb-4 mt-4" id="${user.user_id}" href="chats?user_id=${user.user_id}">
                                    <div class="content">
                                        <img src="${user.img}" alt="${user.name}">
                                        <div class="details cdsd_${user.user_id}">
                                            <span>${user.name}</span>
                                            <p>${user.msg}</p>
                                        </div>
                                    </div>
                                </a>
                            `;
                            $usersList.append(userElement);
                        });
                        
                        // Scroll after users are rendered
                        setTimeout(scrollToActiveUser, 250);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching users:', error);
                }
            });
        }
    }
    
    /**
     * Auto-refresh users list every 50 seconds
     */
    setInterval(fetchUsers, 50000);
    
    /**
     * Initial page load
     */
    fetchUsers();
    
    // Additional initial scroll attempts
    setTimeout(scrollToActiveUser, 500);
    setTimeout(scrollToActiveUser, 1000);
    setTimeout(scrollToActiveUser, 1500);
    
    /**
     * Handle window resize
     */
    let resizeTimer;
    $(window).on('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(scrollToActiveUser, 250);
    });
    
    /**
     * Handle user click
     */
    $(document).on('click', '.users-list a', function(e) {
        const userId = $(this).attr('id');
        sessionStorage.setItem('scrollToUser', userId);
    });
    
    /**
     * Check for pending scroll request
     */
    const scrollToUser = sessionStorage.getItem('scrollToUser');
    if (scrollToUser) {
        setTimeout(function() {
            scrollToActiveUser();
            sessionStorage.removeItem('scrollToUser');
        }, 800);
    }
    
    /**
     * Manual trigger button (for debugging)
     * Add this button to your HTML: <button id="scrollDebug">Scroll to Active</button>
     */
    $(document).on('click', '#scrollDebug', function() {
        console.log('Manual scroll triggered');
        scrollToActiveUser();
    });
    
    /**
     * Expose scroll function globally
     */
    window.scrollToActiveUser = scrollToActiveUser;
    
    // Log active user ID on page load for debugging
    console.log('Page loaded. Active user ID:', $('.incoming_id').val());
});