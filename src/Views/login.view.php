<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/dist/output.css" rel="stylesheet">
    <title>Login</title>
</head>

<body>

    <main class="h-screen w-screen relative flex flex-col items-center justify-center bg-[#6B705C] font-mono">

        <?php

        // check for query errors

        $notification = $_GET['notification'] ?? null;

        if ($notification) {

            $notification_message = '';
            switch ($notification) {
                case 'activation':
                    $notification_message = 'Your account has not been activated. Please check your email for the activation link.';
                    break;
                case 'wrong-input':
                    $notification_message = 'Invalid username or password.';
                    break;
                case 'locked-out':
                    $notification_message = 'Your account has been locked out. We have sent an email with a new password for you to log in.';
                    break;
                case 'password-reset':
                    $notification_message = 'Your password has been reset. Please check your email for the new password.';
                    break;
                case 'registered':
                    $notification_message = 'Your account has been created. Please check your email for the activation link.';
                    break;
            }

            echo "<p class='text-sm mb-4' style='color:#FFE8D6;'>💡 $notification_message 💡</p>"; 
           
        }


        ?>

        <h1 class="text-[#F8F6F2] text-2xl mb-8"> Log In</h1>
        <!-- <h2 class="text-[#A5A58D] text-sm mb-8 text-center"> Callista Stefanie Taswin & Ilia Abedianamiri</h2> -->
        <div class="w-full max-w-xs">
            <form method="POST" action="/auth/login" class="bg-[#B7B7A4] shadow-md rounded px-8 pt-6 pb-8 mb-4">
                <div class="mb-4">
                    <label class="block text-[#F8F6F2] text-sm font-bold mb-2" for="username email">
                        Email
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-[#6B705C] leading-tight focus:outline-none focus:shadow-outline" id="username" name="username" type="email" placeholder="Email" required>
                </div>
                <div class="mb-4">
                    <label class="block text-[#F8F6F2] text-sm font-bold mb-2" for="password">
                        Password
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-[#6B705C] leading-tight focus:outline-none focus:shadow-outline" id="password" name="password" type="password" placeholder="Password" maxlength="8" required>
                </div>
                <div class="flex items-center justify-between">
                    <button class="bg-[#6B705C] hover:bg-[#A5A58D] text-[#F8F6F2] font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                        Log In
                    </button>
                    <a class="inline-block align-baseline font-bold text-sm text-[#6B705C] hover:text-[#A5A58D]" href="#">
                        Forgot Password?
                    </a>
                </div>
            </form>
        </div>
        <a class="text-[#A5A58D] hover:text-[#B7B7A4]" href="/auth/signup">
            New here? Create account
        </a>

    </main>

</body>

</html>