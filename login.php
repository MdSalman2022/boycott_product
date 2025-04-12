<?php
require_once 'config/db.php';
require_once 'models/user.php';
require_once 'includes/header.php';

$error_message = '';

// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//     $phone = $_POST['phone'];
//     $password = $_POST['password'];

//     $user = User::getUserByPhone($phone);
    
//     if ($user && password_verify($password, $user['password'])) {
//         session_start();
//         $_SESSION['user_id'] = $user['id'];
//         $_SESSION['name']    = $user['name'];
//         $_SESSION['phone']   = $user['phone'];
//         $_SESSION['role']    = $user['role'];

//         // Redirect to last page or fallback to homepage
//         $redirect_to = isset($_SESSION['redirect_to']) ? $_SESSION['redirect_to'] : 'index.php';
//         unset($_SESSION['redirect_to']);
//         header("Location: " . $redirect_to);
//         exit();
//     } else {
//         $error_message = "Invalid phone number or password.";
//     }
// }
// ?>

<div class="min-h-screen bg-gray-100 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
            Sign in to your account
        </h2>
        <p class="mt-2 text-center text-sm text-gray-600">
            Join us in the movement for ethical consumer choices
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
            <?php if ($error_message): ?>
                <div class="mb-4 bg-red-50 border-l-4 border-red-500 p-4 text-red-700">
                    <p><?php echo $error_message; ?></p>
                </div>
            <?php endif; ?>
            
            <form class="space-y-6" action="login.php" method="POST">
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

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember_me" name="remember_me" type="checkbox" 
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="remember_me" class="ml-2 block text-sm text-gray-900">
                            Remember me
                        </label>
                    </div>

                    <div class="text-sm">
                        <a href="forgot-password.php" class="font-medium text-blue-600 hover:text-blue-500">
                            Forgot your password?
                        </a>
                    </div>
                </div>

                <div>
                    <button type="submit" 
                            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md 
                                   shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 
                                   focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Sign in
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
                            Don't have an account?
                        </span>
                    </div>
                </div>

                <div class="mt-6">
                    <a href="signup.php" 
                       class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md 
                              shadow-sm text-sm font-medium text-blue-600 bg-white hover:bg-gray-50 
                              focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Create new account
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require_once 'includes/footer.php';
?>