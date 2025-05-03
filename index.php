<!-- v1.1 -->
<?php
// Directory to scan
$directory = __DIR__;
// Get the name of this script to exclude it
$self = basename(__FILE__);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minitools</title>
    <link href="https://minisoft.it/icons/fix.png" rel="shortcut icon" type="image/x-icon" />
    <link href="https://minisoft.it/icons/fix.png" rel="apple-touch-icon" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#006E81',
                        'primary-dark': '#006E81',
                        secondary: '#814000',
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-gray-100 flex flex-col min-h-screen">
    <header class="bg-white border-b border-gray-200">
        <div class="container mx-auto px-4 py-6 max-w-6xl">
            <h1 class="text-3xl font-bold text-center text-gray-800">Minitools</h1>
            <p class="text-gray-600 text-center mt-1">Utilities Collection</p>
        </div>
    </header>

    <main class="container mx-auto px-4 py-8 max-w-6xl flex-grow">
        <ul class="space-y-4">
            <?php
            if ($handle = opendir($directory)) {
                $files = array();

                // First collect all valid files
                while (false !== ($file = readdir($handle))) {
                    if (
                        $file != $self
                        && $file != "index.php"
                        && $file[0] != "."
                        && !(is_dir($directory . "/" . $file) && $file[0] == ".")
                        && !preg_match('/\.md$/', $file)
                    ) {
                        $files[] = $file;
                    }
                }
                closedir($handle);

                // Sort files alphabetically
                sort($files);

                // Then output the links
                foreach ($files as $file) {
                    $fileName = pathinfo($file, PATHINFO_FILENAME);
                    $filePath = htmlspecialchars($file);
                    echo "<li class='text-center'><a href='$filePath' class='inline-block w-full px-4 py-3 border border-gray-300 rounded-lg bg-white text-primary hover:bg-gray-50 transition duration-200'>$fileName</a></li>";
                }
            } else {
                echo "<p class='text-center text-gray-700'>Could not open directory.</p>";
            }
            ?>
        </ul>
    </main>

    <footer class="bg-white border-t border-gray-200 mt-auto">
        <div class="container mx-auto px-4 py-6 max-w-6xl">
            <p class="text-gray-600 text-center">&copy; <a href="https://minisoft.it/" class="text-primary hover:text-primary-dark">Minisoft</a> — All rights reserved</p>
        </div>
    </footer>
</body>

</html>