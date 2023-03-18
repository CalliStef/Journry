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

    <main class="h-screen w-screen flex flex-col items-center justify-center bg-[#6B705C] font-mono">

    <h1 class="text-[#F8F6F2] text-2xl"> PHP Term Project</h1>
    <h2 class="text-[#A5A58D] text-sm mb-8 text-center"> Callista Stefanie Taswin & Ilia Abedianamiri</h2>
        <div class="w-full max-w-xs">
            <form method="POST" action="../src/signup.php" class="bg-[#B7B7A4] shadow-md rounded px-8 pt-6 pb-8 mb-4">
                <div class="mb-4">
                    <label class="block text-[#F8F6F2] text-sm font-bold mb-2" for="username email">
                        Email
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-[#6B705C] leading-tight focus:outline-none focus:shadow-outline" id="username" name="username" type="email" placeholder="Email">
                </div>
                <div class="mb-4">
                    <label class="block text-[#F8F6F2] text-sm font-bold mb-2" for="password">
                        Password
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-[#6B705C] leading-tight focus:outline-none focus:shadow-outline" id="password" name="password" type="text" placeholder="Password">
                </div>
                <div class="flex items-center justify-between">
                    <button class="bg-[#6B705C] hover:bg-[#A5A58D] text-[#F8F6F2] font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button">
                        Sign Up
                    </button>
                    <a class="inline-block align-baseline font-bold text-sm text-[#6B705C] hover:text-[#A5A58D]" href="#">
                        Forgot Password?
                    </a>
                </div>
            </form>
        </div>

    </main>

</body>

</html>