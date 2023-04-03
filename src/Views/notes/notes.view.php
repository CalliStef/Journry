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

<body class="bg-[#6B705C]">
    <main class="w-screen mt-20 flex flex-col items-center justify-center font-mono">

        <div class="fixed w-screen lg:w-2/12 h-1/12 lg:h-screen bg-[#ddbea9] left-0 top-0 flex flex-col p-4 z-10">
            <h2 class="lg:flex-col text-5xl font-teko block text-center pb-4">Journals</h2>
            <div class="flex flex-row lg:flex-col overflow-scroll scrollbar-hide">
            <?php 
                $note_months = [];
                foreach ($viewData['notes'] as $note) {
                    $full_date = $note['created_date'];
                    $full_date_arr = explode('-', $full_date);
                    $month = $full_date_arr[1];
                    $year = $full_date_arr[0];
                    if (!isset($note_months[$year])) {
                        $note_months[$year] = [];
                    }
                    if (!isset($note_months[$year][$month])) {
                        $note_months[$year][$month] = [];
                    }
                    $note_months[$year][$month][] = $note;
                }
                
                // Sort the months by year and month
                krsort($note_months);

                foreach ($note_months as $year => $months) {
                    krsort($months);
                    foreach ($months as $month => $notes) {
                        // echo var_dump($month); // 04
                        $month_name = date('F', strtotime($year . '-' . $month . '-01'));

                        echo "<div class='flex flex-row lg:flex-col items-center justify-center'>";
                        echo "<h3 class='text-xl text-center pb-3'>" . $month_name . " " . $year . "</h3>";
                        foreach ($notes as $note) {
                            $note_date = $note['created_date'];
                            $note_date_arr = explode('-', $note_date);
                            $note_day = $note_date_arr[2];
                            $note_day = ltrim($note_day, '0');

                            $note_day_ordinal = match ($note_day % 10) {
                                1 => 'st',
                                2 => 'nd',
                                3 => 'rd',
                                default => 'th'
                            };

                            echo "<div class='bg-[#6b705c] px-6 py-3 flex items-center pt-5 rounded-full mb-3 group hover:bg-white border-[3px] hover:border-solid hover:border-black transition duration-300 ease-in-out cursor-pointer'>";
                            echo "<span class='font-teko text-3xl text-white group-hover:text-black'>$note_day$note_day_ordinal</span>";
                            echo "</div>";
                        }
                        echo "</div>";
                    }
                }


                
                
            ?>
            </div>
        </div>

        <a href='/note' class="transition mt-32 lg:mt-0 mb-4 top-4 right-4 text-xl text-[#CB997E] bg-[#F8F6F2] hover:text-[#F8F6F2] hover:bg-[#DDBEA9] px-4 py-2 rounded-lg">Create a new journal entry</a>

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