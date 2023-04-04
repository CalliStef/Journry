<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Teko:wght@500&amp;display=swap" rel="stylesheet">
    <script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>
    <link href="/dist/output.css" rel="stylesheet">
    <title>Journals</title>
</head>

<body class="relative bg-[#6B705C]">
    <a href='/home' class="transition absolute flex gap-1 items-center -top-12 left-4 text-xl text-[#CB997E] bg-[#F8F6F2] hover:text-[#F8F6F2] hover:bg-[#DDBEA9] px-4 py-2 rounded-lg">
        <span class='iconify text-[#5c4235] w-8 h-8' data-icon='solar:home-bold-duotone'></span>
        <span class="ml-2 ">Home</span>
    </a>
    <main class="w-screen mt-20 flex flex-col items-center justify-center font-mono">


        <h2 class="lg:flex-col text-5xl font-teko block text-center pb-4 text-[#F8F6F2]">Journals</h2>

        <a href='/note/create' class="transition mt-4 lg:mt-0 mb-4 top-4 right-4 text-xl text-[#CB997E] bg-[#F8F6F2] hover:text-[#F8F6F2] hover:bg-[#DDBEA9] px-4 py-2 rounded-lg">Create a new journal entry</a>

        <?php

        $notes = $viewData['notes'];

        // echo var_dump($notes);

        isset($notes) ? '' : $notes = [];

        foreach ($notes as $note) {
            $full_date = $note['created_date'];
            $full_date_arr = explode('-', $full_date);
            $day = $full_date_arr[2];
            $day = ltrim($day, '0');
            $month = $full_date_arr[1];
            $year = $full_date_arr[0];

            $day_ordinal = match ($day % 10) {
                1 => 'st',
                2 => 'nd',
                3 => 'rd',
                default => 'th'
            };

            $month_name = date('F', strtotime($year . '-' . $month . '-01'));

            $note_images = $note['images'];


            echo "<div id='entry-$full_date' class='w-10/12 md:w-7/12 flex flex-col mb-20'>";
            echo "<h2 class='text-4xl pb-3 md:pb-0'><span class='text-8xl font-teko text-white block md:inline-block'>$day$day_ordinal</span> $month_name, $year</h2>";
            echo "<a href='/note/{$note['id']}'>";
            echo "<div class='w-[60vw] relative flex flex-col lg:flex-row rounded-xl bg-white px-5 py-7 cursor-pointer hover:shadow-[-5px_5px_0_0_#ddbea9] active:shadow-[-3px_3px_0_0_#CB997E] hover:translate-x-[5px] hover:translate-y-[-5px] active:translate-y-[-3px] active:translate-x-[3px] ease-out duration-300'>";
            echo "<div class='icon-button absolute top-0 right-0 transition translate-x-3 -translate-y-4 w-12 h-12 text-[#F8F6F2] bg-[#CB997E] hover:bg-[#DDBEA9] font-medium rounded-full text-sm flex items-center justify-center'><span class='iconify text-[#F8F6F2] w-8 h-8' data-icon='ph:trash-fill'></span></div>";
            echo "<div class='w-full lg:w-7/12'>";
            echo "<h3 class='text-4xl block font-bold pb-5'>{$note['title']}</h3>";
            echo "<p>{$note['content']}</p>";
            echo "</div>";
            echo "<div class='w-full lg:w-5/12 grid grid-cols-2 p-5 justify-center place-content-center place-items-center gap-2'>";
            foreach ($note_images as $image) {
                echo "<div class='overflow-hidden relative w-full h-28 rounded border-2 border-[#6B705C] flex justify-center items-center cursor-pointer bg-cover bg-center hover:border-gray-600 bg-gray-100'>";
                echo "<img src='data:image/*;base64,{$image['filename']}' alt='Image'>";
                echo "</div>";
            }
            echo "</div>";
            echo "</div>";
            echo "</a>";
            echo "</div>";
        }

        ?>

        <a class="transition duration-200 ease-in-out text-[#F8F6F2] bg-[#CB997E] hover:bg-[#DDBEA9] font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 mt-4" href="/auth/logout">
            Log out
        </a>

    </main>

</body>

</html>