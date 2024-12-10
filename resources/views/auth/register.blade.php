<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    @vite('resources/css/app.css')
    <!-- CDN for Inter Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body class="flex min-h-screen font-poppins flex-col md:flex-row">
    <!-- Left Side: Branding or Additional Content -->
    <div class="w-full md:w-1/2 bg-[#B2C7F0] flex items-center justify-center">
        <div class="flex flex-col items-start gap-12 mx-30 mt-16 mb-16">
            <!-- Add any branding or images here -->
            <img src="{{ asset('images/bigbox.png') }}" alt="Bigbox Logo">
            <div class="text-[#1A1A1A] font-bold text-2xl leading-8">
                <p>Effortless Lead Tracking</p>
                <p class="text-[#16A34A]">with Automated Insights</p>
            </div>
            <img src="{{ asset('images/ilust-login.png') }}" alt="Illustration" class="w-full">
        </div>
    </div>

    <!-- Right Side: Registration Form -->
    <div class="w-full md:w-1/2 bg-[#FAFAFA] flex items-center justify-center">
        <div class="flex flex-col items-start gap-4 w-[600px] px-10 py-12">
            <!-- Form Header -->
            <div class="mb-8">
                <h1 class="text-[#1A1A1A] font-semibold text-2xl">Daftar Akun</h1>
                <p class="text-[#A5A5A5] text-lg">Buat akun untuk mulai menjelajah</p>
            </div>

            <!-- Registration Form -->
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name Input -->
                <div class="relative mb-4 w-[500px]">
                    <input id="name" type="text" name="name" value="{{ old('name') }}" placeholder="Masukkan nama lengkap" required class="w-full border border-gray-300 rounded-lg p-3 pl-12 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <img src="{{ asset('icons/profile.svg') }}" alt="User Icon" class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400">
                </div>

                <!-- Email Input -->
                <div class="relative mb-4 w-[500px]">
                    <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="Masukkan alamat email anda" required class="w-full border border-gray-300 rounded-lg p-3 pl-12 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <img src="{{ asset('icons/email.svg') }}" alt="Email Icon" class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400">
                </div>

                <!-- Password Input -->
                <div class="relative mb-4 w-[500px]">
                    <input id="password" type="password" name="password" placeholder="Masukkan kata sandi anda" required class="w-full border border-gray-300 rounded-lg p-3 pl-12 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <img src="{{ asset('icons/password.svg') }}" alt="Password Icon" class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400">
                    <button type="button" id="togglePassword" class="absolute right-3 top-1/2 transform -translate-y-1/2">
                        <i class="fa fa-eye text-gray-400"></i> <!-- Tailwind CSS or Font Awesome eye icon -->
                    </button>
                </div>

                <!-- Confirm Password Input -->
                <div class="relative mb-4 w-[500px]">
                    <input id="password-confirm" type="password" name="password_confirmation" placeholder="Masukkan ulang kata sandi anda" required class="w-full border border-gray-300 rounded-lg p-3 pl-12 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <img src="{{ asset('icons/password.svg') }}" alt="Password Icon" class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400">
                </div>

                <!-- Role Input -->
                <div class="relative mb-4 w-[500px]">
                    <select id="role" name="role" required class="w-full border border-gray-300 rounded-lg p-3 pl-12 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="user">User</option>
                        <option value="manager">Manager</option>
                        <option value="admin">Admin</option>
                    </select>
                    <img src="{{ asset('icons/role.svg') }}" alt="Role Icon" class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400">
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full bg-blue-600 text-white rounded-lg py-3 mt-4 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Daftar</button>
            </form>

            <!-- Link to Login Page -->
            <div class="text-center mt-6">
                <p class="text-[#767676] text-lg">Sudah punya akun? <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Masuk</a></p>
            </div>
        </div>
    </div>
</body>
</html>
