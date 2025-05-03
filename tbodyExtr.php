<!-- v1.2 -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>tBody Extractor</title>
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
            <h1 class="text-3xl font-bold text-center text-gray-800">tBody Extractor</h1>
            <p class="text-gray-600 text-center mt-1">HTML Table Data Extractor</p>
        </div>
    </header>

    <main class="container mx-auto px-4 py-8 max-w-6xl flex-grow">
        <!-- Instructions Section -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Instructions</h2>
            <div class="bg-slate-50 border-l-4 border-primary p-4 rounded-r">
                <ol class="list-decimal pl-5 space-y-1">
                    <li>Paste your &lt;tbody&gt; HTML content in the input area below.</li>
                    <li>Specify the column indices you want to extract, separated by commas (e.g., 1,2).</li>
                    <li>Click "Extract Data" to process the table and view the extracted content.</li>
                </ol>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <form method="post" id="extraction-form" class="space-y-4">
                <div>
                    <label for="html" class="block text-sm font-medium text-gray-700 mb-2">Paste your &lt;tbody&gt; here</label>
                    <textarea name="html" class="w-full h-40 p-3 border border-gray-300 rounded-lg resize-y" 
                              required></textarea>
                </div>
                
                <div>
                    <label for="columns" class="block text-sm font-medium text-gray-700 mb-2">Column indices to extract</label>
                    <input type="text" name="columns" class="w-full p-3 border border-gray-300 rounded-lg" 
                           placeholder="1,2" required />
                </div>
                
                <button type="submit" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary-dark transition duration-200">
                    Extract Data
                </button>
            </form>

            <?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
            <div class="mt-8">
                <h2 class="text-xl font-semibold text-primary mb-4 text-left">Extracted Data:</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-primary">
                            <tr>
                                <?php 
                                $selectedColumns = explode(',', $_POST['columns']);
                                foreach ($selectedColumns as $index): ?>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                        Column <?php echo htmlspecialchars(trim($index)); ?>
                                    </th>
                                <?php endforeach; ?>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php
                            $html = $_POST['html'];
                            $dom = new DOMDocument;
                            @$dom->loadHTML($html);
                            $xpath = new DOMXPath($dom);
                            $rows = $xpath->query('//tbody/tr');

                            foreach ($rows as $row):
                                $cells = $row->getElementsByTagName('td');
                                echo "<tr>";
                                foreach ($selectedColumns as $index) {
                                    $index = intval(trim($index)) - 1;
                                    if ($index >= 0 && isset($cells[$index])) {
                                        echo "<td class='px-6 py-4 whitespace-nowrap text-sm text-gray-900'>" . 
                                             htmlspecialchars(trim($cells[$index]->textContent)) . 
                                             "</td>";
                                    }
                                }
                                echo "</tr>";
                            endforeach;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </main>

    <footer class="bg-white border-t border-gray-200 mt-auto">
        <div class="container mx-auto px-4 py-6 max-w-6xl">
            <p class="text-gray-600 text-center">&copy; <a href="https://minisoft.it/" class="text-primary hover:text-primary-dark">Minisoft</a> — All rights reserved</p>
        </div>
    </footer>
</body>

</html>