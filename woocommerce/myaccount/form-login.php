<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

do_action( 'woocommerce_before_customer_login_form' );
$enable_registration = 'yes' === get_option( 'woocommerce_enable_myaccount_registration' );
?>

<div class="max-w-md mx-auto my-16 relative" id="customer_login">
    
    <!-- Decorative background elements -->
    <div class="absolute -top-10 -left-10 w-40 h-40 bg-[#FFB7C5]/30 dark:bg-[#FFB7C5]/10 rounded-full blur-3xl pointer-events-none z-0"></div>
    <div class="absolute -bottom-10 -right-10 w-60 h-60 bg-[#A8D8EA]/30 dark:bg-[#A8D8EA]/10 rounded-full blur-3xl pointer-events-none z-0"></div>

    <div class="relative z-10 bg-white dark:bg-slate-800 rounded-[40px] shadow-[0_20px_60px_-15px_rgba(15,23,42,0.08)] dark:shadow-[0_20px_60px_-15px_rgba(0,0,0,0.5)] overflow-hidden border border-white/50 dark:border-slate-700/50 p-8 lg:p-10">
        
        <?php if ( $enable_registration ) : ?>
            <!-- Tab Toggle -->
            <div class="flex p-1.5 mb-8 bg-slate-100 dark:bg-slate-700/50 rounded-2xl relative">
                <!-- Active background pill -->
                <div id="tab-active-bg" class="absolute top-1.5 bottom-1.5 left-1.5 w-[calc(50%-6px)] bg-white dark:bg-slate-600 rounded-xl shadow-sm transition-transform duration-300 ease-in-out"></div>
                
                <button type="button" id="tab-login" class="relative z-10 flex-1 py-3 text-sm font-bold text-slate-800 dark:text-white transition-colors cursor-pointer">Sign In</button>
                <button type="button" id="tab-register" class="relative z-10 flex-1 py-3 text-sm font-bold text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-white transition-colors cursor-pointer">Create Account</button>
            </div>
        <?php endif; ?>

        <!-- Login Form -->
        <div id="form-login-container" class="transition-all duration-500">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-extrabold text-slate-800 dark:text-white mb-2 font-['Bubblegum_Sans'] tracking-wide"><?php esc_html_e( 'Welcome Back!', 'woocommerce' ); ?></h2>
                <p class="text-sm text-slate-500 dark:text-slate-400 font-medium">Please enter your details to sign in.</p>
            </div>
            
            <form class="woocommerce-form woocommerce-form-login login flex flex-col gap-5" method="post">
                <?php do_action( 'woocommerce_login_form_start' ); ?>
                
                <div class="relative group">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-2" for="username"><?php esc_html_e( 'Email Address', 'woocommerce' ); ?> <span class="text-red-400">*</span></label>
                    <input type="text" class="woocommerce-Input woocommerce-Input--text input-text w-full px-5 py-4 rounded-2xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700/50 text-slate-800 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-[#FFB7C5] focus:bg-white dark:focus:bg-slate-700 transition-all duration-300" name="username" id="username" autocomplete="username" placeholder="john@example.com" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" />
                </div>
                
                <div class="relative group">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-2" for="password"><?php esc_html_e( 'Password', 'woocommerce' ); ?> <span class="text-red-400">*</span></label>
                    <input class="woocommerce-Input woocommerce-Input--text input-text w-full px-5 py-4 rounded-2xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700/50 text-slate-800 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-[#FFB7C5] focus:bg-white dark:focus:bg-slate-700 transition-all duration-300" type="password" name="password" id="password" autocomplete="current-password" placeholder="••••••••" />
                </div>
                
                <?php do_action( 'woocommerce_login_form' ); ?>
                
                <div class="flex items-center justify-between mt-1 mb-2">
                    <label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme flex items-center gap-2.5 cursor-pointer group">
                        <div class="relative flex items-center justify-center w-5 h-5 rounded border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 group-hover:border-[#FFB7C5] transition-colors">
                            <input class="woocommerce-form__input woocommerce-form__input-checkbox opacity-0 absolute inset-0 cursor-pointer peer" name="rememberme" type="checkbox" id="rememberme" value="forever" />
                            <svg class="w-3.5 h-3.5 text-white opacity-0 peer-checked:opacity-100 transition-opacity z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            <div class="absolute inset-0 bg-[#FFB7C5] rounded scale-0 peer-checked:scale-100 transition-transform duration-200 origin-center"></div>
                        </div>
                        <span class="text-sm font-semibold text-slate-600 dark:text-slate-400"><?php esc_html_e( 'Remember me', 'woocommerce' ); ?></span>
                    </label>
                    <a class="text-sm font-bold text-[#FFB7C5] hover:text-[#ff9eaa] transition-colors" href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Forgot password?', 'woocommerce' ); ?></a>
                </div>
                
                <?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
                <button type="submit" class="woocommerce-button button woocommerce-form-login__submit w-full py-4 bg-slate-800 dark:bg-slate-700 hover:bg-[#FFB7C5] dark:hover:bg-[#FFB7C5] text-white rounded-2xl font-bold text-lg transition-all shadow-[0_4px_15px_rgba(15,23,42,0.1)] hover:shadow-[0_4px_20px_rgba(255,183,197,0.4)] flex items-center justify-center gap-2 group" name="login" value="<?php esc_attr_e( 'Log in', 'woocommerce' ); ?>">
                    <?php esc_html_e( 'Sign In', 'woocommerce' ); ?>
                    <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
                
                <?php do_action( 'woocommerce_login_form_end' ); ?>
            </form>
        </div>

        <?php if ( $enable_registration ) : ?>
        <!-- Register Form -->
        <div id="form-register-container" class="hidden opacity-0 transition-all duration-500">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-extrabold text-slate-800 dark:text-white mb-2 font-['Bubblegum_Sans'] tracking-wide"><?php esc_html_e( 'New Here?', 'woocommerce' ); ?></h2>
                <p class="text-sm text-slate-500 dark:text-slate-400 font-medium">Create an account to start shopping.</p>
            </div>
            
            <form method="post" class="woocommerce-form woocommerce-form-register register flex flex-col gap-5" <?php do_action( 'woocommerce_register_form_tag' ); ?> >
                <?php do_action( 'woocommerce_register_form_start' ); ?>
                
                <div class="relative group">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-2" for="reg_email"><?php esc_html_e( 'Email Address', 'woocommerce' ); ?> <span class="text-red-400">*</span></label>
                    <input type="email" class="woocommerce-Input woocommerce-Input--text input-text w-full px-5 py-4 rounded-2xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700/50 text-slate-800 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-[#FFB7C5] focus:bg-white dark:focus:bg-slate-700 transition-all duration-300" name="email" id="reg_email" autocomplete="email" placeholder="john@example.com" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" required />
                    <p class="text-[12px] text-slate-500 font-medium mt-3 leading-relaxed">A password will be sent to your email address.</p>
                </div>
                
                <?php do_action( 'woocommerce_register_form' ); ?>
                <?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
                
                <button type="submit" class="woocommerce-Button woocommerce-button button woocommerce-form-register__submit w-full py-4 mt-2 bg-[#FFB7C5] hover:bg-[#ff9eaa] text-white rounded-2xl font-bold text-lg transition-all shadow-[0_4px_15px_rgba(255,183,197,0.3)] hover:shadow-[0_4px_20px_rgba(255,183,197,0.5)] flex items-center justify-center gap-2 group" name="register" value="<?php esc_attr_e( 'Register', 'woocommerce' ); ?>">
                    <?php esc_html_e( 'Create Account', 'woocommerce' ); ?>
                    <svg class="w-5 h-5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                </button>
                
                <?php do_action( 'woocommerce_register_form_end' ); ?>
            </form>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php if ( $enable_registration ) : ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const btnLogin = document.getElementById('tab-login');
    const btnRegister = document.getElementById('tab-register');
    const formLogin = document.getElementById('form-login-container');
    const formRegister = document.getElementById('form-register-container');
    const bgPill = document.getElementById('tab-active-bg');

    if (!btnLogin || !btnRegister) return;

    // Check URL hash or query param for 'register' to auto-switch
    if (window.location.href.indexOf('#register') > -1 || window.location.search.indexOf('action=register') > -1) {
        showRegister(false);
    }

    btnLogin.addEventListener('click', () => showLogin(true));
    btnRegister.addEventListener('click', () => showRegister(true));

    function showLogin(animate) {
        bgPill.style.transform = 'translateX(0)';
        btnLogin.classList.replace('text-slate-500', 'text-slate-800');
        btnLogin.classList.replace('dark:text-slate-400', 'dark:text-white');
        btnRegister.classList.replace('text-slate-800', 'text-slate-500');
        btnRegister.classList.replace('dark:text-white', 'dark:text-slate-400');
        
        formRegister.classList.add('hidden');
        formLogin.classList.remove('hidden');
        
        if (animate) {
            formLogin.classList.remove('opacity-0');
            formRegister.classList.add('opacity-0');
        } else {
            formLogin.classList.remove('opacity-0');
        }
    }

    function showRegister(animate) {
        bgPill.style.transform = 'translateX(100%)';
        btnRegister.classList.replace('text-slate-500', 'text-slate-800');
        btnRegister.classList.replace('dark:text-slate-400', 'dark:text-white');
        btnLogin.classList.replace('text-slate-800', 'text-slate-500');
        btnLogin.classList.replace('dark:text-white', 'dark:text-slate-400');
        
        formLogin.classList.add('hidden');
        formRegister.classList.remove('hidden');
        
        if (animate) {
            formRegister.classList.remove('opacity-0');
            formLogin.classList.add('opacity-0');
        } else {
            formRegister.classList.remove('opacity-0');
        }
    }
});
</script>
<?php endif; ?>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>