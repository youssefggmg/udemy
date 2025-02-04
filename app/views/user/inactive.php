<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Inactive | ECOURSES</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Main Container -->
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="max-w-md w-full bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Top Icon -->
            <div class="bg-yellow-50 px-4 py-8 text-center">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-yellow-100 mb-4">
                    <i class="fas fa-user-clock text-3xl text-yellow-600"></i>
                </div>
                <h1 class="text-2xl font-bold text-gray-800 mb-2">Account Inactive</h1>
                <p class="text-gray-600">Your account is currently pending activation</p>
            </div>

            <!-- Content -->
            <div class="p-6">
                <div class="space-y-4">
                    <!-- Status Message -->
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-circle text-yellow-400"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-yellow-700">
                                    Your account needs to be activated before you can access all features.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- What to do next -->
                    <div class="space-y-3">
                        <h2 class="text-lg font-semibold text-gray-800">What to do next:</h2>
                        <ul class="space-y-2">
                            <li class="flex items-center text-gray-600">
                                <i class="fas fa-envelope text-blue-500 mr-2"></i>
                                Check your email for activation instructions
                            </li>
                            <li class="flex items-center text-gray-600">
                                <i class="fas fa-clock text-blue-500 mr-2"></i>
                                Allow up to 24 hours for account review
                            </li>
                            <li class="flex items-center text-gray-600">
                                <i class="fas fa-inbox text-blue-500 mr-2"></i>
                                Check your spam folder if you haven't received the email
                            </li>
                        </ul>
                    </div>

                    <!-- Action Buttons -->
                    <div class="space-y-3 pt-4">
                        <button class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-200">
                            Resend Activation Email
                        </button>
                        <button class="w-full bg-white border border-gray-300 text-gray-700 py-2 px-4 rounded-lg hover:bg-gray-50 transition duration-200">
                            Contact Support
                        </button>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="px-6 py-4 bg-gray-50 border-t">
                <div class="flex justify-between items-center">
                    <a href="index.php" class="text-blue-600 hover:text-blue-700 flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Return to Home
                    </a>
                    <a href="support.php" class="text-gray-600 hover:text-gray-700">
                        Need Help?
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>