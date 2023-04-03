<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Teko:wght@500&amp;display=swap" rel="stylesheet">
    <link href="/dist/output.css" rel="stylesheet">
    <title>Journals</title>
</head>

<body class="bg-[#6B705C]">
<main class="w-screen mt-20 flex flex-col items-center justify-center font-mono">

    <div class="fixed w-screen lg:w-2/12 h-1/12 lg:h-screen bg-[#ddbea9] left-0 top-0 flex flex-col p-4 z-10">
        <h2 class="lg:flex-col text-5xl font-teko block text-center pb-4">Journals</h2>
        <div class="flex flex-row lg:flex-col overflow-scroll scrollbar-hide">
            <h3 class="text-xl text-center pb-3">March 2023</h3>
            <?php for ($i = 23; $i >= 1; $i--) { ?>
                <div class="bg-[#6b705c] px-6 py-3 flex items-center pt-5 rounded-full mb-3 group hover:bg-white border-[3px] hover:border-solid hover:border-black transition duration-300 ease-in-out cursor-pointer">
                    <span class="font-teko text-3xl text-white group-hover:text-black"><?= $i ?><?=
                        match ($i % 10) {
                            1 => 'st',
                            2 => 'nd',
                            3 => 'rd',
                            default => 'th',
                        } ?></span>
                </div>
            <?php } ?>
        </div>
    </div>

    <h1 class="text-[#F8F6F2] text-2xl mb-6 mt-32 lg:mt-0">Your Journals</h1>

    <?php 
        
        $notes = $viewData['notes'];

        // echo var_dump($notes);

        isset($notes) ? '' : $notes = [];

        foreach ($notes as $note){
            $full_date = $note['created_date'];
            $full_date_arr = explode('-', $full_date);
            $day = $full_date_arr[2];
            $day = ltrim($day, '0');
            $month = $full_date_arr[1];
            $year = $full_date_arr[0];

            $day_ordinal = match($day % 10){
                1 => 'st',
                2 => 'nd',
                3 => 'rd',
                default => 'th'
            };

            $month_name = date('F', strtotime($month . '-01'));

            $note_images = $note['images'];

            echo "<div id='entry-$full_date' class='w-10/12 md:w-7/12 flex flex-col mb-20'>";
            echo "<h2 class='text-4xl pb-3 md:pb-0'><span class='text-8xl font-teko text-white block md:inline-block'>$day$day_ordinal</span> $month_name, $year</h2>";
            echo "<div class='w-full flex flex-col lg:flex-row rounded-xl bg-white px-5 py-7 cursor-pointer hover:shadow-[-5px_5px_0_0_#ddbea9] active:shadow-[-3px_3px_0_0_#CB997E] hover:translate-x-[5px] hover:translate-y-[-5px] active:translate-y-[-3px] active:translate-x-[3px] ease-out duration-300'>";
            echo "<div class='w-full lg:w-7/12'>";
            echo "<h3 class='text-4xl block font-bold pb-5'>{$note['title']}</h3>";
            echo "<p>{$note['content']}</p>";
            echo "</div>";
            echo "<div class='w-full lg:w-5/12 grid grid-cols-2 p-5 justify-center place-content-center place-items-center gap-2'>";
            foreach($note_images as $image){
                echo "<div class='overflow-hidden relative w-full h-28 rounded border-2 border-[#6B705C] flex justify-center items-center cursor-pointer bg-cover bg-center hover:border-gray-600 bg-gray-100'>";
                echo "<img src='data:image/*;base64,{$image['filename']}' alt='Image'>";
                echo "</div>";
            }
            echo "</div>";
            echo "</div>";
            echo "</div>";

        }
    
    ?>





    <!-- <div id="entry-23-03-2023" class="w-10/12 md:w-7/12 flex flex-col mb-20">
        <h2 class="text-4xl pb-3 md:pb-0"><span class="text-8xl font-teko text-white block md:inline-block">23rd</span>
            Mar, 2023</h2>
        <div class="w-full flex flex-col lg:flex-row rounded-xl bg-white px-5 py-7 cursor-pointer hover:shadow-[-5px_5px_0_0_#ddbea9] active:shadow-[-3px_3px_0_0_#CB997E] hover:translate-x-[5px] hover:translate-y-[-5px] active:translate-y-[-3px] active:translate-x-[3px] ease-out duration-300">
            <div class="w-full lg:w-7/12">
                <h3 class="text-4xl block font-bold pb-5">Journal Entry Title</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Doloremque facilis itaque quasi rem sint
                    suscipit vel. Aut cum cupiditate, iste magni minus nisi numquam obcaecati pariatur, quod quos unde
                    veritatis.</p>
            </div>
            <div class="w-full lg:w-5/12 grid grid-cols-2 p-5 justify-center place-content-center place-items-center gap-2">
                <label for="image3"
                       class="drop-area overflow-hidden relative w-full h-28 rounded border-2 border-[#6B705C] flex justify-center items-center cursor-pointer bg-cover bg-center hover:border-gray-600 bg-gray-100 hover:bg-gray-300">
                    <img src="/public/assets/images/samples/big_sur.jpg" alt="" class="max-w-full max-h-full">
                </label>
                <label for="image3"
                       class="drop-area overflow-hidden relative w-full h-28 rounded flex justify-center items-center bg-cover bg-center hover:border-gray-600 bg-gray-100 hover:bg-gray-300">
                    <img src="" alt="" class="hidden max-w-full max-h-full">
                </label>
                <label for="image3"
                       class="drop-area overflow-hidden relative w-full h-28 rounded flex justify-center items-center bg-cover bg-center hover:border-gray-600 bg-gray-100 hover:bg-gray-300">
                    <img src="" alt="" class="hidden max-w-full max-h-full">
                </label>
                <label for="image3"
                       class="drop-area overflow-hidden relative w-full h-28 rounded flex justify-center items-center bg-cover bg-center hover:border-gray-600 bg-gray-100 hover:bg-gray-300">
                    <img src="" alt="" class="hidden max-w-full max-h-full">
                </label>
            </div>
        </div>
    </div> -->

    <a class="transition duration-200 ease-in-out text-[#F8F6F2] bg-[#CB997E] hover:bg-[#DDBEA9] font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 mt-4"
       href="/auth/logout">
        Log out
    </a>

</main>

</body>
</html>