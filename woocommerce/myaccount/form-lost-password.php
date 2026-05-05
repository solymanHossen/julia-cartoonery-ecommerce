<?php
/**
 * Lost password form
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_lost_password_form' );
?>

<div class="w-full max-w-md mx-auto px-4 sm:px-0 my-8 lg:my-16 relative">
    
    <!-- Decorative background elements -->
    <div class="absolute -top-10 -left-10 w-40 h-40 bg-[#FFB7C5]/30 dark:bg-[#FFB7C5]/10 rounded-full blur-3xl pointer-events-none z-0 hidden sm:block"></div>
    <div class="absolute -bottom-10 -right-10 w-60 h-60 bg-[#A8D8EA]/30 dark:bg-[#A8D8EA]/10 rounded-full blur-3xl pointer-events-none z-0 hidden sm:block"></div>

    <div class="relative z-10 bg-white dark:bg-slate-800 rounded-[32px] sm:rounded-[40px] shadow-[0_20px_60px_-15px_rgba(15,23,42,0.08)] dark:shadow-[0_20px_60px_-15px_rgba(0,0,0,0.5)] overflow-hidden border border-white/50 dark:border-slate-700/50 p-6 sm:p-8 lg:p-10">
        
        <div class="text-center mb-8">
            <h2 class="text-3xl font-extrabold text-slate-800 dark:text-white mb-2 font-['Bubblegum_Sans'] tracking-wide"><?php esc_html_e( 'Forgot Password?', 'woocommerce' ); ?></h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 font-medium leading-relaxed">
                <?php echo apply_filters( 'woocommerce_lost_password_message', esc_html__( 'Please enter your email address. You will receive a link to create a new password via email.', 'woocommerce' ) ); ?>
            </p>
        </div>

        <form method="post" class="woocommerce-ResetPassword lost_reset_password flex flex-col gap-6">
            
            <div class="relative group">
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-2" for="user_login"><?php esc_html_e( 'Email Address', 'woocommerce' ); ?> <span class="text-red-400">*</span></label>
                <input type="text" class="woocommerce-Input woocommerce-Input--text input-text w-full px-5 py-4 rounded-2xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700/50 text-slate-800 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-[#FFB7C5] focus:bg-white dark:focus:bg-slate-700 transition-all duration-300" name="user_login" id="user_login" autocomplete="username" placeholder="john@example.com" required />
            </div>

            <?php do_action( 'woocommerce_lostpassword_form' ); ?>

            <div class="mt-2">
                <input type="hidden" name="wc_reset_password" value="true" />
                <button type="submit" class="woocommerce-Button button w-full !flex py-4 bg-slate-800 dark:bg-slate-700 hover:bg-[#FFB7C5] dark:hover:bg-[#FFB7C5] text-white rounded-2xl font-bold text-lg transition-all shadow-[0_4px_15px_rgba(15,23,42,0.1)] hover:shadow-[0_4px_20px_rgba(255,183,197,0.4)] items-center justify-center gap-2 group" value="<?php esc_attr_e( 'Reset password', 'woocommerce' ); ?>">
                    <?php esc_html_e( 'Reset Password', 'woocommerce' ); ?>
                    <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
            </div>

            <?php wp_nonce_field( 'lost_password', 'woocommerce-lost-password-nonce' ); ?>
            
            <div class="text-center mt-2">
                <a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="inline-flex items-center gap-1.5 text-sm font-bold text-slate-500 hover:text-[#FFB7C5] transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to Login
                </a>
            </div>

        </form>
    </div>
</div>

<?php do_action( 'woocommerce_after_lost_password_form' ); ?>
