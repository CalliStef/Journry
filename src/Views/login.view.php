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
            switch ($error) {
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

            echo "<div class='flex absolute mt-4 mx-auto items-center bg-[#FFE8D6] text-[#CB997E] text-sm font-bold px-4 py-3' role='alert'>
            <svg class='fill-current w-4 h-4 mr-2' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20'><path d='M12.432 0c1.34 0 2.01.912 2.01 1.957 0 1.305-1.164 2.512-2.679 2.512-1.269 0-2.009-.75-1.974-1.99C9.789 1.436 10.67 0 12.432 0zM8.309 20c-1.058 0-1.833-.652-1.093-3.524l1.214-5.092c.211-.814.246-1.141 0-1.141-.317 0-1.689.562-2.502 1.117l-.528-.88c2.572-2.186 5.531-3.467 6.801-3.467 1.057 0 1.233 1.273.705 3.23l-1.391 5.352c-.246.945-.141 1.271.106 1.271.317 0 1.357-.392 2.379-1.207l.6.814C12.098 19.02 9.365 20 8.309 20z'/></svg>
            <p>$notification_message</p>
            </div>";
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
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-[#6B705C] leading-tight focus:outline-none focus:shadow-outline" id="password" name="password" type="text" placeholder="Password" maxlength="8" required>
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