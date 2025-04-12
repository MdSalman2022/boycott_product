<?php
// signup.php
require_once 'config/db.php';
require_once 'models/user.php';
require_once 'includes/header.php';

$error_message = '';
$success_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    // Password hashing for security
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Check if the phone already exists
    $user = User::getUserByPhone($phone);
    if ($user) {
        $error_message = "User already exists with this phone number.";
    } else {
        // Insert the new user into the database
        $success = User::addUser($name, $phone, $hashedPassword);
        if ($success) {
            $success_message = "Signup successful! You can now log in.";
        } else {
            $error_message = "An error occurred during registration. Please try again.";
        }
    }
}
?>

<div class="min-h-screen bg-gray-100 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
            Create your account
        </h2>
        <p class="mt-2 text-center text-sm text-gray-600">
            Join us in making ethical consumer choices
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
            <?php if ($error_message): ?>
                <div class="mb-4 bg-red-50 border-l-4 border-red-500 p-4 text-red-700">
                    <p><?php echo $error_message; ?></p>
                </div>
            <?php endif; ?>
            
            <?php if ($success_message): ?>
                <div class="mb-4 bg-green-50 border-l-4 border-green-500 p-4 text-green-700">
                    <p><?php echo $success_message; ?></p>
                    <p class="mt-2">
                        <a href="login.php" class="font-medium text-green-700 underline">Log in now</a>
                    </p>
                </div>
            <?php endif; ?>
            
            <form class="space-y-6" action="signup.php" method="POST">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">
                        Full Name
                    </label>
                    <div class="mt-1">
                        <input id="name" name="name" type="text" required 
                               class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md 
                                      shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 
                                      focus:border-blue-500 sm:text-sm">
                    </div>
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700">
                        Phone Number
                    </label>
                    <div class="mt-1">
                        <input id="phone" name="phone" type="text" required 
                               class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md 
                                      shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 
                                      focus:border-blue-500 sm:text-sm">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">
                        Password
                    </label>
                    <div class="mt-1">
                        <input id="password" name="password" type="password" required 
                               class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md 
                                      shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 
                                      focus:border-blue-500 sm:text-sm">
                    </div>
                </div>

                <div>
                    <button type="submit" 
                            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md 
                                   shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 
                                   focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Sign up
                    </button>
                </div>
            </form>

            <div class="mt-6">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">
                            Already have an account?
                        </span>
                    </div>
                </div>

                <div class="mt-6">
                    <a href="login.php" 
                       class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md 
                              shadow-sm text-sm font-medium text-blue-600 bg-white hover:bg-gray-50 
                              focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Sign in instead
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require_once 'includes/footer.php';
?>