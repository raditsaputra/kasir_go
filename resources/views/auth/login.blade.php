<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="shortcut icon" href="https://cdn.vectorstock.com/i/1000v/51/51/initial-gs-letter-royal-luxury-logo-template-vector-42835151.jpg" type="image/x-icon">

</head>
<body>
<div class="min-h-screen bg-gray-50 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-6xl w-full">
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
            <div class="flex flex-col md:flex-row">
                <!-- Left side with brand image - Dark Blue Background -->
                <div class="md:w-1/2 bg-navy-900 text-white p-8 md:p-12 relative overflow-hidden">
                    <div class="relative z-10">
                        <div class="mb-6">
                        <img src="https://cdn.vectorstock.com/i/1000v/51/51/initial-gs-letter-royal-luxury-logo-template-vector-42835151.jpg" alt="PIO Logo" class="h-16 w-16 object-cover rounded-full">
                        </div>
                        <div class="space-y-6">
                            <h3 class="text-sm font-light">Retail dan grosir sistem kasir <span class="font-bold">marketing</span></h3>
                            <h2 class="text-3xl font-bold leading-tight">
                            Kurangi yang biasa.<br>
                                <span class="text-gold-400">Tingkatkan yang istimewa.</span>
                            </h2>
                            <p class="text-sm text-gray-300 max-w-md">
                            Dari toko kecil hingga bisnis yang berkembang, kami adalah mitra Anda dalam mengelola transaksi, stok, dan data pelanggan dengan mudah dan elegan melalui aplikasi kasir Gold Sales.                            </p>
                        </div>
                    </div>
                    <div class="absolute -bottom-20 -right-20 opacity-80">
                        <img src="https://cdn.vectorstock.com/i/1000v/51/51/initial-gs-letter-royal-luxury-logo-template-vector-42835151.jpg" alt="Monkey Mascot" class="w-80 transform rotate-6 rounded">
                    </div>
                    <!-- Decorative elements -->
                    <div class="absolute top-0 left-0 w-full h-full">
                        <div class="absolute top-10 left-10 w-20 h-20 rounded-full bg-navy-800 opacity-30"></div>
                    </div>
                </div>
                
                <!-- Right side with login form -->
                <div class="md:w-1/2 bg-white p-8 md:p-12">
                    <div class="max-w-md mx-auto">
                        <div class="text-center mb-8">
                            <h2 class="text-3xl font-bold text-gray-800">Selamat Datang!</h2>
                        </div>
                        
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="mb-6">
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <input id="email" type="email" class="pl-10 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-navy-500 focus:border-navy-500" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Masukan email">
                                </div>
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-6">
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">sandi</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                    </div>
                                    <input id="password" type="password" class="pl-10 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-navy-500 focus:border-navy-500" name="password" required autocomplete="current-password" placeholder="Masukan password">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                        <button type="button" onclick="togglePasswordVisibility()" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 toggle-eye" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                @error('password')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex items-center justify-between mb-6">
                                <div class="flex items-center">
                                    <input id="remember" name="remember" type="checkbox" class="h-4 w-4 text-navy-600 focus:ring-navy-500 border-gray-300 rounded" {{ old('remember') ? 'checked' : '' }}>
                                    <label for="remember" class="ml-2 block text-sm text-gray-700">
                                        Ingat Saya
                                    </label>
                                </div>
                                <div class="text-sm">
                                    <a href="#" class="font-medium text-navy-600 hover:text-navy-500">
                                        Dapatkan password?
                                    </a>
                                </div>
                            </div>

                            <div>
                                <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent rounded-lg text-white bg-navy-600 hover:bg-navy-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-navy-500 transition duration-150 ease-in-out shadow-md">
                                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-navy-300 group-hover:text-navy-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                        </svg>
                                    </span>
                                    Masuk
                                </button>
                            </div>
                        </form>
                        
                        <div class="mt-8 relative">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-gray-200"></div>
                            </div>
                            <div class="relative flex justify-center text-sm">
                                <span class="px-4 bg-white text-gray-500">or</span>
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            <button type="button" class="w-full flex justify-center items-center py-3 px-4 border border-gray-300 rounded-lg shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-navy-500 transition duration-150 ease-in-out">
                                <svg class="h-5 w-5 mr-2" viewBox="0 0 24 24" width="24" height="24" xmlns="http://www.w3.org/2000/svg">
                                    <g transform="matrix(1, 0, 0, 1, 27.009001, -39.238998)">
                                        <path fill="#4285F4" d="M -3.264 51.509 C -3.264 50.719 -3.334 49.969 -3.454 49.239 L -14.754 49.239 L -14.754 53.749 L -8.284 53.749 C -8.574 55.229 -9.424 56.479 -10.684 57.329 L -10.684 60.329 L -6.824 60.329 C -4.564 58.239 -3.264 55.159 -3.264 51.509 Z"/>
                                        <path fill="#34A853" d="M -14.754 63.239 C -11.514 63.239 -8.804 62.159 -6.824 60.329 L -10.684 57.329 C -11.764 58.049 -13.134 58.489 -14.754 58.489 C -17.884 58.489 -20.534 56.379 -21.484 53.529 L -25.464 53.529 L -25.464 56.619 C -23.494 60.539 -19.444 63.239 -14.754 63.239 Z"/>
                                        <path fill="#FBBC05" d="M -21.484 53.529 C -21.734 52.809 -21.864 52.039 -21.864 51.239 C -21.864 50.439 -21.724 49.669 -21.484 48.949 L -21.484 45.859 L -25.464 45.859 C -26.284 47.479 -26.754 49.299 -26.754 51.239 C -26.754 53.179 -26.284 54.999 -25.464 56.619 L -21.484 53.529 Z"/>
                                        <path fill="#EA4335" d="M -14.754 43.989 C -12.984 43.989 -11.404 44.599 -10.154 45.789 L -6.734 42.369 C -8.804 40.429 -11.514 39.239 -14.754 39.239 C -19.444 39.239 -23.494 41.939 -25.464 45.859 L -21.484 48.949 C -20.534 46.099 -17.884 43.989 -14.754 43.989 Z"/>
                                    </g>
                                </svg>
                                Sign in with Google
                            </button>
                        </div>
                        
                        <div class="mt-8 text-center">
                            <p class="text-sm text-gray-600">
                                Tidak punya akun? 
                                <a href="#" class="font-medium text-navy-600 hover:text-navy-500">
                                    Daftar disini
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Custom colors */
    .bg-navy-900 {
        background-color: #0A1A3B;
    }
    .bg-navy-800 {
        background-color: #102552;
    }
    .bg-navy-700 {
        background-color: #15336A;
    }
    .bg-navy-600 {
        background-color: #1A4183;
    }
    .bg-navy-500 {
        background-color: #1F4F9C;
    }
    .text-navy-600 {
        color: #1A4183;
    }
    .text-navy-500 {
        color: #1F4F9C;
    }
    .text-navy-300 {
        color: #6D8CD0;
    }
    .text-navy-200 {
        color: #8BA3DA;
    }
    .text-gold-400 {
        color: #D4AF37;
    }
    .bg-gold-500 {
        background-color: #C5A028;
    }
    .focus\:ring-navy-500:focus {
        --tw-ring-color: #1F4F9C;
    }
    .focus\:border-navy-500:focus {
        border-color: #1F4F9C;
    }
    .hover\:bg-navy-700:hover {
        background-color: #15336A;
    }
    .hover\:text-navy-500:hover {
        color: #1F4F9C;
    }
</style>

<script>
function togglePasswordVisibility() {
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.querySelector('.toggle-eye');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
        `;
    } else {
        passwordInput.type = 'password';
        toggleIcon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
        `;
    }
}
</script>    
</body>
</html>