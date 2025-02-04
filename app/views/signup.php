<?php
include "../app/Helpers/roleValidaiton.php";
$roleValidaitons = new roleValidaiton();
// if (isset($_COOKIE["userROLE"])) {
//     $userRole = $_COOKIE["userROLE"];
//     if ($userRole == "Student") {
//         $roleValidaiton->redirect("./user");
//     }
//     elseif ($userRole == "Teacher") {
//         $roleValidaiton->redirect("./teacher");
//     }
//     elseif ($userRole == "Admine") {
//         $roleValidaiton->redirect("./admine");
//     }
// }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <div class="bg-sky-100 flex justify-center items-center h-screen">
        <!-- Left: Image -->
        <div class="w-1/2 h-screen hidden lg:block">
            <img src="https://img.freepik.com/fotos-premium/imagen-fondo_910766-187.jpg?w=826" alt="Placeholder Image"
                class="object-cover w-full h-full">
        </div>
        <!-- Right: Sign Up Form -->
        <div class="lg:p-36 md:p-52 sm:20 p-8 w-full lg:w-1/2">
            <h1 class="text-2xl font-semibold mb-4">Sign Up</h1>
            <form action="/YoudmyMVC/pages/signUP" method="POST">
                <!-- Username Input -->
                <div class="mb-4 bg-sky-100">
                    <label for="username" class="block text-gray-600">Username</label>
                    <input type="text" id="username" name="username"
                        class="w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:border-blue-500"
                        autocomplete="off">
                </div>
                <!-- Email Input -->
                <div class="mb-4 bg-sky-100">
                    <label for="email" class="block text-gray-600">Email</label>
                    <input type="email" id="email" name="email"
                        class="w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:border-blue-500"
                        autocomplete="off">
                </div>
                <!-- Password Input -->
                <div class="mb-4">
                    <label for="password" class="block text-gray-800">Password</label>
                    <input type="password" id="password" name="password"
                        class="w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:border-blue-500"
                        autocomplete="off">
                </div>
                <!-- User Type Selection -->
                <div class="mb-4">
                    <label class="block text-gray-800 mb-2">User Type</label>
                    <div class="flex gap-4">
                        <div class="flex items-center">
                            <input type="radio" id="student" checked name="user_type" value="Student"
                                class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                            <label for="student" class="ml-2 text-gray-700">Student</label>
                        </div>
                        <div class="flex items-center">
                            <input type="radio" id="teacher" name="user_type" value="Teacher"
                                class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                            <label for="teacher" class="ml-2 text-gray-700">Teacher</label>
                        </div>
                    </div>
                </div>
                <!-- Sign Up Button -->
                <button type="submit"
                    class="bg-red-500 hover:bg-blue-600 text-white font-semibold rounded-md py-2 px-4 w-full">Sign
                    Up</button>
                    <?php 
                    if (isset($data["error"])) {
                        echo "<div class='bg-red-500 text-white p-4 rounded-md shadow-md mt-4'>
                                <strong>Error:</strong>".$data["error"]."
                            </div>";
                    }
                    ?>
            </form>
            <!-- Login Link -->
            <div class="mt-6 text-green-500 text-center">
                <a href="/YoudmyMVC" class="hover:underline">Already have an account? Login Here</a>
            </div>
        </div>
    </div>
</body>
</html>