<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="/dist/output.css" rel="stylesheet">
    <title>Home</title>
</head>

<body>
    <main class="h-screen w-screen flex flex-col items-center justify-center bg-[#6B705C] font-mono">

        <h1 class="text-[#F8F6F2] text-2xl mb-8">Write your today's journal</h1>

        <div class="bg-gray-100 p-4 border border-gray-300 font-mono leading-6 w-96 shadow">
            <form class="p-2">
                <div class="h-40 overflow-y-scroll">
                    <textarea class="resize-none w-full h-full bg-transparent outline-none" placeholder="Enter text here..."></textarea>
                </div>
                <h2 class="text-[#6B705C] text-base mb-4">Add images</h2>
                <div class="grid grid-cols-2 gap-4">

                    <label for="image1" class="relative w-full h-36 rounded border-2 border-[#6B705C] flex justify-center items-center cursor-pointer bg-cover bg-center hover:border-gray-600 hover:bg-gray-100">
                        <input type="file" id="image1" name="image1" accept="image/*" class="absolute w-full h-full opacity-0 cursor-pointer">
                        <span class="text-[#6B705C] text-lg font-bold">+</span>
                        <img src="" alt="" class="hidden">
                    </label>
                    <label for="image2" class="relative w-full h-36 rounded border-2 border-[#6B705C] flex justify-center items-center cursor-pointer bg-cover bg-center hover:border-gray-600 hover:bg-gray-100">
                        <input type="file" id="image2" name="image2" accept="image/*" class="absolute w-full h-full opacity-0 cursor-pointer">
                        <span class="text-[#6B705C] text-lg font-bold">+</span>
                        <img src="" alt="" class="hidden">
                    </label>
                    <label for="image3" class="relative w-full h-36 rounded border-2 border-[#6B705C] flex justify-center items-center cursor-pointer bg-cover bg-center hover:border-gray-600 hover:bg-gray-100">
                        <input type="file" id="image3" name="image3" accept="image/*" class="absolute w-full h-full opacity-0 cursor-pointer">
                        <span class="text-[#6B705C] text-lg font-bold">+</span>
                        <img src="" alt="" class="hidden">
                    </label>
                    <label for="image4" class="relative w-full h-36 rounded border-2 border-[#6B705C] flex justify-center items-center cursor-pointer bg-cover bg-center hover:border-gray-600 hover:bg-gray-100">
                        <input type="file" id="image4" name="image4" accept="image/*" class="absolute w-full h-full opacity-0 cursor-pointer">
                        <span class="text-[#6B705C] text-lg font-bold">+</span>
                        <img src="" alt="" class="hidden">
                    </label>
                </div>
            </form>
        </div>

        <a class="text-[#F8F6F2] bg-[#CB997E] hover:bg-[#DDBEA9] font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 mt-4" href="/auth/logout">
            Log out
        </a>

    </main>


</body>

</html>