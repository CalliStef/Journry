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

        <h1 class="text-[#F8F6F2] text-2xl mb-8"> Forgot Password</h1>
        <!-- <h2 class="text-[#A5A58D] text-sm mb-8 text-center"> Callista Stefanie Taswin & Ilia Abedianamiri</h2> -->
        <div class="w-full max-w-xs">
            <form method="POST" action="/auth/forgot-password" class="bg-[#B7B7A4] shadow-md rounded px-8 pt-6 pb-8 mb-4">
                <div class="mb-4">
                    <label class="block text-[#F8F6F2] text-sm font-bold mb-2" for="username email">
                        Email
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-[#6B705C] leading-tight focus:outline-none focus:shadow-outline" id="username" name="username" type="email" placeholder="Email" required>
                </div>
              
                <div class="flex items-center justify-between">
                    <button class="transition duration-300 ease-in-out bg-[#6B705C] hover:bg-[#A5A58D] text-[#F8F6F2] font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                        Send Password Reset Email
                    </button>
                </div>
            </form>
        </div>
        <a class="text-[#A5A58D] hover:text-[#B7B7A4]" href="/auth/login">
            Go back to login page
        </a>

    </main>

</body>

</html>