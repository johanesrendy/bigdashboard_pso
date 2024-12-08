<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    @vite('resources/css/app.css')
    <!-- CDN for Poppins Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">

</head>

<body class="flex min-h-screen font-poppins flex-col md:flex-row">
    <div class="w-full md:w-1/2 bg-[#B2C7F0] flex items-center justify-center">
        <div class="flex flex-col items-start gap-12 mx-30 mt-16 mb-16">
            <img src="{{ asset('images/bigbox.png') }}" alt="Bigbox Logo">
            <div class="text-[#040303] font-bold text-2xl leading-8">
                <p>Effortless Lead Tracking</p>
                <p class="text-[#16A34A]">with Automated Insights</p>
            </div>
            <img src="{{ asset('images/ilust-login.png') }}" alt="Illustration" class="w-full">
        </div>
    </div>

    <div class="w-full md:w-1/2 bg-[#FAFAFA] flex items-center justify-center">
        <div class="flex flex-col items-start gap-4 w-[600px] px-10 py-12">
            <div class="text-[#292929] w-[600px] font-bold text-2xl leading-8">
                Selamat datang di BIGBOX CRM Dashboard!
            </div>
            <div class="text-[#A5A5A5] font-medium text-m leading-7">
                Silakan masuk dengan akun Anda untuk melanjutkan.
            </div>

            <form method="POST" action="{{ route('login') }}" class="flex flex-col gap-6 w-full">
                @csrf

                <!-- Email Input -->
                <div class="relative mb-4 w-full">
                    <input id="email" type="email" name="email" value="{{ old('email') }}"
                        placeholder="Masukkan email anda" required
                        class="w-full border border-gray-300 rounded-lg p-3 pl-12 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <img src="{{ asset('icons/email.svg') }}" alt="Email Icon"
                        class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400">
                    @error('email')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password Input -->
                <div class="relative mb-4 w-full">
                    <input id="password" type="password" name="password" placeholder="Masukkan kata sandi Anda"
                        required
                        class="w-full border border-gray-300 rounded-lg p-3 pl-12 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <img src="{{ asset('icons/password.svg') }}" alt="Password Icon"
                        class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400">
                    <button type="button" id="togglePassword"
                        class="absolute right-3 top-1/2 transform -translate-y-1/2">
                        <i class="fa fa-eye text-gray-400"></i> <!-- Tailwind CSS or Font Awesome eye icon -->
                    </button>
                    @error('password')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Forgot Password -->
                <a href="#" class="text-[#F54A45] text-lg font-medium leading-6">Lupa kata sandi?</a>

                <!-- Submit Button -->
                <button type="submit" class="bg-[#0549CF] text-white font-bold text-lg py-3 rounded-md w-full">
                    Masuk
                </button>

                <!-- Divider Text -->
                <div class="text-[#A5A5A5] text-sm text-center font-medium">
                    atau masuk dengan
                </div>

                <!-- Google Login Button -->
                <button type="button"
                    class="bg-[#D0D5DD] text-[#575757] font-medium text-lg py-3 rounded-md flex items-center justify-center gap-4 w-full">
                    <img src="{{ asset('icons/google.png') }}" alt="Google Icon" class="w-6 h-6">
                    Akun Google
                </button>

                <!-- Register Link -->
                <div class="text-[#767676] text-sm text-center font-medium">
                    Belum punya akun? <a href="{{ route('register') }}" class="text-[#FF931E]">Buat akun</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Snackbar Notification for Error -->
    @if (session('error'))
        <div id="snackbar" class="fixed bottom-4 right-4 bg-red-500 text-white px-6 py-3 rounded-md shadow-lg">
            <div class="flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M18.364 5.636L6.343 17.657m12.021-12.021L6.343 5.636m6.364 6.364h.01M12 3v9m0 0v9m0-9H3m9 0h9" />
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        </div>
        <script>
            setTimeout(function() {
                document.getElementById('snackbar').style.display = 'none';
            }, 4000);
        </script>
    @endif
</body>

</html>
