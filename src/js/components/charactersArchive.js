export function initCharactersArchive($) {
    if ($('.char-download-btn').length === 0) return;

    const $modal = $('#subModal');
    const $modalContent = $('#modalContent');
    const $backdrop = $('#modalBackdrop');
    const $closeBtn = $('#closeModalBtn');
    
    const $actionArea = $('#modalActionArea');
    const $successArea = $('#modalSuccessArea');
    const $verifyBtn = $('#verifyBtn');
    const $verifyBtnContent = $('#verifyBtnContent');
    const $charNameSpan = $('#dynamicCharName');
    
    const $toast = $('#toastNotification');
    const $toastMsg = $('#toastMsg');
    
    let activeDownloadUrl = '';
    let isVerifying = false;

    // 1. Open Modal Logic
    $('.char-download-btn').on('click', function(e) {
        e.preventDefault();
        const $this = $(this);
        const charName = $this.data('char-name');
        activeDownloadUrl = $this.data('download-url');
        
        // Set dynamic data
        $charNameSpan.text(charName);
        
        // Show modal
        $modal.removeClass('opacity-0 pointer-events-none');
        // Add entry animation classes
        setTimeout(() => {
            $modalContent.removeClass('scale-90 translate-y-8').addClass('scale-100 translate-y-0');
        }, 10);
        
        // Reset modal states
        $actionArea.removeClass('hidden');
        $successArea.addClass('hidden');
        $verifyBtn.prop('disabled', false);
        $verifyBtnContent.html("2. I've Subscribed - Verify & Download");
    });

    // 2. Close Modal Logic
    function closeModal() {
        if (isVerifying) return; // Prevent closing while verifying
        
        // Add exit animation classes
        $modalContent.removeClass('scale-100 translate-y-0').addClass('scale-90 translate-y-8');
        
        setTimeout(() => {
            $modal.addClass('opacity-0 pointer-events-none');
        }, 300); // Wait for transition
    }
    
    $closeBtn.on('click', closeModal);
    $backdrop.on('click', closeModal);

    // 3. Verify & Download Logic
    $verifyBtn.on('click', function() {
        if (isVerifying) return;
        isVerifying = true;
        $verifyBtn.prop('disabled', true);
        
        // Show Loading Spinner
        $verifyBtnContent.html(`
            <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Verifying...
        `);
        
        // Step 1: Simulate Network Request (2 seconds)
        setTimeout(() => {
            isVerifying = false;
            
            // Fade out action area, fade in success area
            $actionArea.addClass('hidden');
            $successArea.removeClass('hidden');
            
            // Step 2: Show Success and trigger Toast (1.5 seconds later)
            setTimeout(() => {
                closeModal();
                showToast(`Downloading ${$charNameSpan.text()} High-Res PNG!`);
                
                // window.location.href = activeDownloadUrl; // Uncomment to actual download
                
            }, 1800);
            
        }, 2000);
    });

    // 4. Toast Notification Logic
    function showToast(message) {
        $toastMsg.text(message);
        // Slide up and fade in
        $toast.removeClass('translate-y-24 opacity-0');
        
        setTimeout(() => {
            // Slide down and fade out
            $toast.addClass('translate-y-24 opacity-0');
        }, 4000);
    }
}
