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
        <div class="container mx-auto px-4 py-6 max-w-4xl">
            <h1 class="text-3xl font-bold text-center text-gray-800">Minitools</h1>
            <p class="text-gray-600 text-center mt-1">Utilities Collection <span class="opacity-50">v2.2</span></p>
        </div>
    </header>

    <main class="container mx-auto px-4 py-8 max-w-md flex-grow">
        <ul class="grid md:grid-cols-3 gap-4">
            <?php
            // Define groups and their files
            $groups = [
                'HTML Table tools' => ['magicTable.html', 'tabParse.html', 'tbodyExtr.html'],
                'QR-Code tools' => ['bulkr.html', 'qrGen.html'],
                'Extracting tools' => ['contentExtr.html', 'filesExtr.html', 'rangExtr.html']
                // Add more groups as needed
            ];
            
            if ($handle = opendir($directory)) {
                $files = array();
                $groupedFiles = array();
                
                // Collect all valid files
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
                
                // Categorize files
                foreach ($groups as $groupName => $groupFiles) {
                    $groupedFiles[$groupName] = array_intersect($files, $groupFiles);
                    $files = array_diff($files, $groupFiles);
                }
                
                // Add remaining files to "Other tools"
                if (!empty($files)) {
                    sort($files);
                    $groupedFiles['Other tools'] = $files;
                }
                
                // Output grouped files
                foreach ($groupedFiles as $groupName => $groupFiles) {
                    if (!empty($groupFiles)) {
                        echo "<li class='md:col-span-3'><h2 class='text-lg font-semibold text-gray-700 mb-2 pb-1 border-b border-gray-300'>$groupName</h2></li>";
                        
                        foreach ($groupFiles as $file) {
                            $fileName = pathinfo($file, PATHINFO_FILENAME);
                            $filePath = htmlspecialchars($file);
                            echo "<li class='text-center'><a href='$filePath' class='inline-block w-full px-4 py-3 border border-gray-300 rounded-lg bg-white text-primary hover:scale-105 hover:shadow-md hover:bg-gray-50 transition duration-200'>$fileName</a></li>";
                        }
                    }
                }
            } else {
                echo "<p class='text-center text-gray-700 md:col-span-3'>Could not open directory.</p>";
            }
            ?>
        </ul>
    </main>

    <footer class="bg-white border-t border-gray-200 mt-auto">
        <div class="container mx-auto px-4 py-6 max-w-4xl">
            <p class="text-gray-600 text-center">&copy; <a href="https://minisoft.it/" class="text-primary hover:text-primary-dark">Minisoft</a> — All rights reserved</p>
        </div>
    </footer>
</body>

</html>