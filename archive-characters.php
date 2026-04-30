<?php
/**
 * The template for displaying Characters Archive
 */
get_header(); ?>

<main class="container mx-auto px-4 lg:px-8 py-12 animate-in fade-in relative">
    
    <!-- Header Section -->
    <div class="text-center mb-12">
        <h1 class="font-['Bubblegum_Sans'] text-5xl text-gray-800 dark:text-gray-100 mb-4">Meet the Characters</h1>
        <p class="text-gray-500 dark:text-gray-400 mb-6">Download high-quality coloring pages and vector art of your favorites!</p>
    </div>

    <!-- Characters Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
            
            <div class="flex flex-col items-center p-8 text-center bg-gradient-to-b from-white to-gray-50 dark:from-slate-800 dark:to-slate-800/80 rounded-[40px] shadow-sm border border-gray-100 dark:border-slate-700 hover:shadow-md transition-shadow">
                
                <!-- Character Image -->
                <div class="w-48 h-48 rounded-full overflow-hidden border-8 border-white dark:border-slate-700 shadow-lg mb-6 bg-[#A8D8EA]/20 dark:bg-sky-900/30">
                    <?php if(has_post_thumbnail()): ?>
                        <img src="<?php the_post_thumbnail_url('medium'); ?>" alt="<?php the_title_attribute(); ?>" class="w-full h-full object-cover mix-blend-multiply dark:mix-blend-normal" />
                    <?php else: ?>
                        <div class="w-full h-full bg-gray-200 dark:bg-slate-700"></div>
                    <?php endif; ?>
                </div>
                
                <h3 class="font-bold text-2xl text-gray-800 dark:text-gray-200 mb-4"><?php the_title(); ?></h3>
                
                <!-- Download Button (Triggers Modal) -->
                <button 
                    class="char-download-btn w-full px-6 py-3 border-2 border-gray-200 dark:border-slate-600 text-gray-700 dark:text-gray-300 rounded-xl hover:bg-gray-50 dark:hover:bg-slate-700 font-bold transition-colors flex items-center justify-center gap-2 group"
                    data-char-name="<?php echo esc_attr(get_the_title()); ?>"
                    data-download-url="<?php echo esc_url(get_permalink()); ?>" <!-- এখানে আপনি চাইলে কাস্টম ফিল্ডের ডাউনলোড লিংকও দিতে পারেন -->
                >
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="group-hover:-translate-y-0.5 transition-transform"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
                    Download Free
                </button>
            </div>

        <?php endwhile; else: ?>
            <p class="text-center text-gray-500 col-span-full">No characters found. Add some from the dashboard!</p>
        <?php endif; ?>
    </div>

    <!-- ============================================== -->
    <!-- SUBSCRIPTION MODAL (Hidden by default)         -->
    <!-- ============================================== -->
    <div id="subModal" class="fixed inset-0 z-50 flex items-center justify-center opacity-0 pointer-events-none transition-opacity duration-300">
        <!-- Backdrop -->
        <div id="modalBackdrop" class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm"></div>
        
        <!-- Modal Content -->
        <div id="modalContent" class="relative bg-white dark:bg-slate-800 p-8 rounded-[40px] shadow-2xl max-w-sm w-full mx-4 transform scale-95 transition-transform duration-300">
            
            <!-- Close Button -->
            <button id="closeModalBtn" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" x2="6" y1="6" y2="18"/><line x1="6" x2="18" y1="6" y2="18"/></svg>
            </button>

            <div class="text-center">
                <div class="w-20 h-20 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center mx-auto mb-6">
                    <!-- YouTube Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-red-500 dark:text-red-400"><path d="M2.5 17a24.12 24.12 0 0 1 0-10 2 2 0 0 1 1.4-1.4 49.56 49.56 0 0 1 16.2 0A2 2 0 0 1 21.5 7a24.12 24.12 0 0 1 0 10 2 2 0 0 1-1.4 1.4 49.55 49.55 0 0 1-16.2 0A2 2 0 0 1 2.5 17"/><path d="m10 15 5-3-5-3z"/></svg>
                </div>
                <h2 class="font-['Bubblegum_Sans'] text-3xl text-gray-800 dark:text-gray-100 mb-4">Subscriber Exclusive!</h2>
                <p class="text-gray-600 dark:text-gray-300 mb-8">
                    To download <strong id="dynamicCharName" class="text-gray-900 dark:text-white">Character</strong>, please subscribe to Julia's Cartoonery on YouTube. It's free and helps us make more cartoons!
                </p>
                
                <!-- Action Buttons Area -->
                <div id="modalActionArea" class="space-y-4">
                    <button onclick="window.open('https://youtube.com', '_blank')" class="w-full bg-[#ff0000] hover:bg-[#cc0000] text-white font-bold py-3 px-4 rounded-xl flex items-center justify-center gap-2 transition-colors shadow-md">
                        1. Subscribe to Channel
                    </button>
                    <button id="verifyBtn" class="w-full bg-gray-800 dark:bg-slate-700 hover:bg-black dark:hover:bg-slate-600 text-white font-bold py-3 px-4 rounded-xl transition-colors disabled:opacity-70 disabled:cursor-not-allowed">
                        <span id="verifyBtnContent">2. I've Subscribed - Verify & Download</span>
                    </button>
                </div>

                <!-- Success Message Area (Hidden initially) -->
                <div id="modalSuccessArea" class="hidden bg-green-50 dark:bg-emerald-900/30 text-green-600 dark:text-emerald-400 p-4 rounded-xl flex items-center justify-center gap-2 font-bold animate-in zoom-in">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m9 11 3 3L22 4"/></svg>
                    Verified! Downloading...
                </div>
            </div>
        </div>
    </div>

    <!-- TOAST NOTIFICATION -->
    <div id="toastNotification" class="fixed bottom-8 right-8 bg-green-500 text-white px-6 py-3 rounded-xl shadow-xl font-bold flex items-center gap-3 transform translate-y-20 opacity-0 transition-all duration-300 z-50">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m9 11 3 3L22 4"/></svg>
        <span id="toastMsg">Success!</span>
    </div>

</main>

<!-- Interaction Logic (Replacing React State) -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('subModal');
    const modalContent = document.getElementById('modalContent');
    const backdrop = document.getElementById('modalBackdrop');
    const closeBtn = document.getElementById('closeModalBtn');
    
    const actionArea = document.getElementById('modalActionArea');
    const successArea = document.getElementById('modalSuccessArea');
    const verifyBtn = document.getElementById('verifyBtn');
    const verifyBtnContent = document.getElementById('verifyBtnContent');
    const charNameSpan = document.getElementById('dynamicCharName');
    
    const toast = document.getElementById('toastNotification');
    const toastMsg = document.getElementById('toastMsg');
    
    let activeDownloadUrl = '';
    let isVerifying = false;

    // 1. Open Modal Logic
    document.querySelectorAll('.char-download-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const charName = this.getAttribute('data-char-name');
            activeDownloadUrl = this.getAttribute('data-download-url');
            
            // Set dynamic data
            charNameSpan.innerText = charName;
            
            // Show modal
            modal.classList.remove('opacity-0', 'pointer-events-none');
            modalContent.classList.replace('scale-95', 'scale-100');
            
            // Reset modal states
            actionArea.classList.remove('hidden');
            successArea.classList.add('hidden');
            verifyBtn.disabled = false;
            verifyBtnContent.innerHTML = "2. I've Subscribed - Verify & Download";
        });
    });

    // 2. Close Modal Logic
    function closeModal() {
        if (isVerifying) return; // Prevent closing while verifying
        modal.classList.add('opacity-0', 'pointer-events-none');
        modalContent.classList.replace('scale-100', 'scale-95');
    }
    
    closeBtn.addEventListener('click', closeModal);
    backdrop.addEventListener('click', closeModal);

    // 3. Verify & Download Logic (Simulating React's setTimeout)
    verifyBtn.addEventListener('click', function() {
        isVerifying = true;
        this.disabled = true;
        
        // Show Loading Spinner
        verifyBtnContent.innerHTML = `
            <span class="flex items-center justify-center gap-2">
                <div class="w-5 h-5 border-2 border-white border-t-transparent rounded-full animate-spin"></div> 
                Verifying...
            </span>
        `;
        
        // Step 1: Simulate Network Request (2 seconds)
        setTimeout(() => {
            isVerifying = false;
            actionArea.classList.add('hidden');
            successArea.classList.remove('hidden');
            
            // Step 2: Show Success and trigger Toast (1.5 seconds later)
            setTimeout(() => {
                closeModal();
                showToast(`Downloading ${charNameSpan.innerText} High-Res PNG!`);
                
                // Optional: Actually redirect to download URL
                // window.location.href = activeDownloadUrl;
                
            }, 1500);
            
        }, 2000);
    });

    // 4. Toast Notification Logic
    function showToast(message) {
        toastMsg.innerText = message;
        toast.classList.remove('translate-y-20', 'opacity-0');
        
        setTimeout(() => {
            toast.classList.add('translate-y-20', 'opacity-0');
        }, 3500);
    }
});
</script>

<?php get_footer(); ?>