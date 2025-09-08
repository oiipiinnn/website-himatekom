<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - HIMATEKOM UNAND</title>
    <link rel="icon" href="{{ asset('img/logo.png') }}">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Custom Tailwind Config -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'himatekom': {
                            'green': '#006738',
                            'light-green': '#22c55e',
                            'dark': '#1a1a2e',
                        }
                    }
                }
            }
        }
    </script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gradient-to-br from-himatekom-dark via-gray-900 to-himatekom-green min-h-screen">
    <!-- Background Pattern -->
    <div class="absolute inset-0 bg-black/20"></div>
    <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,<svg xmlns=&quot;http://www.w3.org/2000/svg&quot; viewBox=&quot;0 0 100 100&quot;><defs><pattern id=&quot;grid&quot; width=&quot;10&quot; height=&quot;10&quot; patternUnits=&quot;userSpaceOnUse&quot;><path d=&quot;M 10 0 L 0 0 0 10&quot; fill=&quot;none&quot; stroke=&quot;%23006738&quot; stroke-width=&quot;0.5&quot; opacity=&quot;0.1&quot;/></pattern></defs><rect width=&quot;100&quot; height=&quot;100&quot; fill=&quot;url(%23grid)&quot;/></svg>'); opacity: 0.3;"></div>

    <div class="relative min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full">
            <!-- Back to Home -->
            <div class="text-center mb-8">
                <a href="/" class="inline-flex items-center text-white/70 hover:text-white transition-colors duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali ke Beranda
                </a>
            </div>

            <!-- Logo and Title -->
            <div class="text-center mb-8">
                <div class="mx-auto h-20 w-20 mb-4">
                    <img src="{{ asset('img/logo.png') }}" alt="HIMATEKOM Logo" class="h-full w-full object-contain drop-shadow-lg">
                </div>
                <h1 class="text-3xl font-bold text-white mb-2">Selamat Datang</h1>
                <p class="text-white/70">Masuk ke Dashboard HIMATEKOM</p>
            </div>

            <!-- Login Card -->
            <div class="bg-white/10 backdrop-blur-lg rounded-2xl shadow-2xl p-8 border border-white/20">
                <!-- Session Status -->
                @if (session('status'))
                    <div class="mb-6 p-4 bg-himatekom-light-green/20 border border-himatekom-light-green/30 rounded-lg">
                        <p class="text-himatekom-light-green text-sm">{{ session('status') }}</p>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-white mb-2">
                            <i class="fas fa-envelope mr-2"></i>Email Address
                        </label>
                        <div class="relative">
                            <input 
                                id="email" 
                                type="email" 
                                name="email" 
                                value="{{ old('email') }}" 
                                required 
                                autofocus 
                                autocomplete="username"
                                class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-himatekom-light-green focus:border-transparent transition-all duration-200 backdrop-blur-sm"
                                placeholder="Masukkan email Anda"
                            >
                        </div>
                        @error('email')
                            <p class="mt-2 text-sm text-red-400 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-white mb-2">
                            <i class="fas fa-lock mr-2"></i>Password
                        </label>
                        <div class="relative">
                            <input 
                                id="password" 
                                type="password" 
                                name="password" 
                                required 
                                autocomplete="current-password"
                                class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-himatekom-light-green focus:border-transparent transition-all duration-200 backdrop-blur-sm pr-12"
                                placeholder="Masukkan password Anda"
                            >
                            <button 
                                type="button" 
                                onclick="togglePassword()" 
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-white/50 hover:text-white transition-colors"
                            >
                                <i id="toggleIcon" class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-2 text-sm text-red-400 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Remember Me and Forgot Password -->
                    <div class="flex items-center justify-between">
                        <label class="flex items-center">
                            <input 
                                id="remember_me" 
                                type="checkbox" 
                                name="remember"
                                class="h-4 w-4 text-himatekom-light-green bg-white/10 border-white/20 rounded focus:ring-himatekom-light-green focus:ring-2"
                            >
                            <span class="ml-2 text-sm text-white/70">Ingat saya</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a 
                                href="{{ route('password.request') }}" 
                                class="text-sm text-himatekom-light-green hover:text-white transition-colors duration-200"
                            >
                                Lupa password?
                            </a>
                        @endif
                    </div>

                    <!-- Login Button -->
                    <button 
                        type="submit" 
                        class="w-full bg-gradient-to-r from-himatekom-green to-himatekom-light-green text-white py-3 px-6 rounded-xl font-semibold hover:from-himatekom-light-green hover:to-himatekom-green transform hover:scale-[1.02] transition-all duration-200 shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-himatekom-light-green focus:ring-offset-2 focus:ring-offset-transparent"
                    >
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Masuk
                    </button>
                </form>

                <!-- Footer -->
                <div class="mt-8 pt-6 border-t border-white/20 text-center">
                    <p class="text-white/50 text-sm">
                        © {{ date('Y') }} HIMATEKOM UNAND. All rights reserved.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        // Add subtle animation on load
        document.addEventListener('DOMContentLoaded', function() {
            const card = document.querySelector('.backdrop-blur-lg');
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                card.style.transition = 'all 0.6s ease-out';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, 100);
        });
    </script>
</body>
</html>
