<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>
    <link href="/dist/output.css" rel="stylesheet">
    <title>Home</title>
</head>

<body>
    <main class="flex flex-col items-center justify-center h-screen bg-[#6b705c]">
        <h1 class="text-5xl font-bold mb-8 text-[#393c31]">Welcome</h1>
        <div class="flex gap-4">
            <a href="/notes" class="w-[30vw] transition relative flex flex-row items-center justify-center md:flex-col rounded-xl bg-[#DDBEA9] px-5 py-7 cursor-pointer hover:shadow-[-5px_5px_0_0_#CB997E] active:shadow-[-3px_3px_0_0_#CB997E] hover:translate-x-[5px] hover:translate-y-[-5px] active:translate-y-[-3px] active:translate-x-[3px] ease-out duration-300">
                <span class='iconify text-[#5c4235] w-24 h-24 mb-2' data-icon='solar:notes-bold-duotone'></span>
                <span class="text-2xl text-[#5c4235]"> Browse your journals </span>
            </a>
            <a href="/note/create" class="w-[30vw] transition relative flex flex-row md:flex-col items-center justify-center rounded-xl bg-[#DDBEA9] px-5 py-7 cursor-pointer hover:shadow-[-5px_5px_0_0_#CB997E] active:shadow-[-3px_3px_0_0_#CB997E] hover:translate-x-[5px] hover:translate-y-[-5px] active:translate-y-[-3px] active:translate-x-[3px] ease-out duration-300'">
                <span class='iconify text-[#5c4235] w-20 h-20 mb-2' data-icon='solar:pen-new-square-bold-duotone'></span>
                <span class="text-2xl text-[#5c4235]"> Create a new entry </span>
            </a>
        </div>
        <a class="transition duration-200 ease-in-out text-[#F8F6F2] bg-[#CB997E] hover:bg-[#DDBEA9] font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 mt-8" href="/auth/logout">
            Log out
        </a>
    </main>
</body>

</html>