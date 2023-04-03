<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="/dist/output.css" rel="stylesheet">
    <script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>
    <title>Home</title>
</head>

<body>
    <main class="relative h-screen w-screen flex flex-col items-center justify-center bg-[#6B705C] font-mono">
        <a href='/notes' class="absolute top-4 right-4 text-xl text-[#CB997E] bg-[#F8F6F2] hover:text-[#F8F6F2] hover:bg-[#DDBEA9] px-4 py-2 rounded-lg">JOURNALS >></a>

        <?=
            isset($viewData['journalData'])  
            ? "<h1 class='text-[#F8F6F2] text-2xl mb-2'>Edit your journal</h1><h2 class='text-sm text-[#DDBEA9] mb-2'>Created at: " . $viewData['journalData']['created_date'] . "</h2>"
            : "<h1 class='text-[#F8F6F2] text-2xl mb-4'>Write your today's journal</h1>"
        ?>
        <div class="relative bg-gray-100 p-4 border border-gray-300 font-mono leading-6 w-96 shadow">
        <a href="/note/delete/<?= $viewData['journalData']['id']?>" class='icon-button absolute top-0 right-0 translate-x-3 -translate-y-4 w-12 h-12 text-[#F8F6F2] bg-[#CB997E] hover:bg-[#DDBEA9] font-medium rounded-full text-sm flex items-center justify-center'><span class='iconify text-[#F8F6F2] w-8 h-8' data-icon='ph:trash-fill'></span></a>
            <form method="POST" action="/note<?= isset($viewData['journalData']['id']) ? "/update/" . $viewData['journalData']['id'] : '' ?>" class="p-2 flex flex-col" enctype="multipart/form-data">
                <label class="mb-2" for="title">
                    <input class="w-full h-full bg-transparent outline-none text-center text-xl" type=text name="title" placeholder="Journal Title" value="<?= $viewData['journalData']['title'] ?? '' ?>">
                </label>
                <div class="h-40 overflow-y-scroll">
                    <textarea class="resize-none w-full h-full bg-transparent outline-none" name="content" placeholder="Enter text here..."><?= $viewData['journalData']['content'] ?? '' ?></textarea>
                </div>
                <h2 class="text-[#6B705C] text-base mb-4">Add images</h2>
                <div class="grid grid-cols-2 gap-4">
                    <?php
                    for ($i = 0; $i < 4; $i++) {

                        echo "<label for='image$i' class='drop-area relative w-full h-36 rounded border-2 border-[#6B705C] flex justify-center items-center cursor-pointer bg-cover bg-center hover:border-gray-600 hover:bg-gray-100'>";
                        if(isset($viewData['journalData']['images'][$i])) {
                            echo "<img src='data:image/*;base64," . ($viewData['journalData']['images'][$i]['filename'] ?? '') . "' alt='' class='max-w-full max-h-full'>";
                            echo "<a href='/image/delete/{$viewData['journalData']['images'][$i]['id']}' class='image-button absolute top-0 right-0 translate-x-3 -translate-y-4 w-8 h-8 text-[#F8F6F2] bg-[#CB997E] hover:bg-[#DDBEA9] font-medium rounded-full text-sm flex items-center justify-center'><span class='iconify text-[#F8F6F2] w-4 h-4' data-icon='ph:trash-fill'></span></a>";
                        } else {
                            echo "<input type='file' id='image$i' name='images[]' accept='image/*' class='absolute w-full h-full opacity-0 cursor-pointer'>
                                    <span class='text-[#6B705C] text-lg font-bold'>+ </span>
                                    <img src='data:image/*;base64," . ($viewData['journalData']['images'][$i]['filename'] ?? '') . "' alt='' class='hidden max-w-full max-h-full'>";
                        }
                        echo "</label>";

                    }
                    ?>
                </div>
                <button class="transition duration-200 ease-in-out text-[#F8F6F2] bg-[#CB997E] hover:bg-[#DDBEA9] font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 mt-4" type="submit">
                   <?= isset($viewData['journalData']) ? 'Update' : 'Save' ?> Journal
                </button>
            </form>
        </div>

        <a class="transition duration-200 ease-in-out text-[#F8F6F2] bg-[#CB997E] hover:bg-[#DDBEA9] font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 mt-4" href="/auth/logout">
            Log out
        </a>

    </main>

    <script>
        // Get all file input elements
        const dropAreas = document.querySelectorAll('.drop-area');

        dropAreas.forEach(dropArea => {
            // Add dragover event listener to the drop area
            dropArea.addEventListener('dragover', e => {
                e.preventDefault();
                dropArea.classList.add('dragover');
            });

            // Add dragleave event listener to the drop area
            dropArea.addEventListener('dragleave', e => {
                e.preventDefault();
                dropArea.classList.remove('dragover');
            });

            // Add drop event listener to the drop area
            dropArea.addEventListener('drop', e => {
                e.preventDefault();
                dropArea.classList.remove('dragover');

                // Get the dropped files
                const files = e.dataTransfer.files;

                // Check if any files were dropped
                if (files.length > 0) {
                    // Display the first file in the drop area as a preview
                    const file = files[0];
                    const reader = new FileReader();
                    reader.onload = () => {
                        dropArea.querySelector('img').src = reader.result;
                        dropArea.querySelector('span').classList.add('hidden');
                        dropArea.querySelector('img').classList.remove('hidden');
                    };
                    reader.readAsDataURL(file);

                }
            });

            dropArea.addEventListener('change', (e) => {
                e.preventDefault();
                dropArea.classList.remove('dragover');

                // Get the dropped files
                const files = e.target.files;

                // Check if any files were dropped
                if (files.length > 0) {
                    // Display the first file in the drop area as a preview
                    const file = files[0];
                    const reader = new FileReader();
                    reader.onload = () => {
                        dropArea.querySelector('img').src = reader.result;
                        dropArea.querySelector('span').classList.add('hidden');
                        dropArea.querySelector('img').classList.remove('hidden');
                    };
                    reader.readAsDataURL(file);

                }
            })
        });
    </script>

</body>

</html>