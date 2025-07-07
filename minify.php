<!-- v2.2 -->
<?php
// Process form submission
$minified = '';
$original = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['js_code'])) {
    $original = $_POST['js_code'];
    
    // Define the API URL
    $url = 'https://www.toptal.com/developers/javascript-minifier/api/raw';
    
    // Initialize cURL session
    $ch = curl_init();
    
    // Set cURL options
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_HTTPHEADER => ["Content-Type: application/x-www-form-urlencoded"],
        CURLOPT_POSTFIELDS => http_build_query(["input" => $original])
    ]);
    
    // Execute cURL request and get response
    $minified = curl_exec($ch);
    
    // Check for errors
    if (curl_errno($ch)) {
        $error = 'Error: ' . curl_error($ch);
        $minified = '';
    } else {
        // Check if response is a JSON error
        $jsonResponse = json_decode($minified, true);
        if (json_last_error() === JSON_ERROR_NONE && isset($jsonResponse['errors'])) {
            // Extract error details from JSON
            $errorObj = $jsonResponse['errors'][0];
            $error = $errorObj['title'] . ': ' . $errorObj['detail'];
            $minified = '';
        } else {
            // Transform double spaces into single spaces
            $minified = preg_replace('/\s{2,}/', ' ', $minified);
        }
    }
    
    // Close cURL session
    curl_close($ch);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minify</title>
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
            <h1 class="text-3xl font-bold text-center text-gray-800">Minify</h1>
            <p class="text-gray-600 text-center mt-1">JavaScript Minifier</p>
        </div>
    </header>

    <main class="container mx-auto px-4 py-8 max-w-4xl">
        <!-- Instructions Section -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Instructions</h2>
            <div class="bg-slate-50 border-l-4 border-primary p-4 rounded-r">
                <ol class="list-decimal pl-5 space-y-1">
                    <li>Copy JavaScript code to your clipboard</li>
                    <li>Click the "Minify" button to paste and minify your code</li>
                    <li>Use the "Copy" button to copy the minified code</li>
                </ol>
            </div>
        </div>
        
        <!-- Content -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <form method="post" id="minifyForm">
                <textarea 
                    id="js_code" 
                    name="js_code" 
                    required 
                    class="hidden"
                ><?php echo htmlspecialchars($original); ?></textarea>
                
                <div class="flex justify-center">
                    <button 
                        type="button" 
                        id="pasteMinifyBtn" 
                        class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary-dark transition duration-200"
                    >
                        Minify
                    </button>
                </div>
            </form>
        </div>
        
        <?php if ($error): ?>
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Error</h2>
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <?php if (strpos($error, 'Syntax Error') !== false): ?>
                            <p class="text-sm font-medium text-red-800">JavaScript Syntax Error</p>
                            <pre class="mt-2 text-sm text-red-700 bg-red-50 p-2 rounded font-mono overflow-x-auto"><?php echo htmlspecialchars($error); ?></pre>
                            <p class="text-sm text-red-700 mt-2">Please check your JavaScript code for syntax errors.</p>
                        <?php else: ?>
                            <p class="text-sm text-red-700"><?php echo htmlspecialchars($error); ?></p>
                            <p class="text-sm text-red-700 mt-2">Please check your input or try again later.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
        
        <?php if ($minified): ?>
        <div class="bg-white rounded-lg shadow-md p-6" id="resultSection">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Minified Code</h2>
            
            <div class="relative mb-4">
                <input 
                    type="text" 
                    id="minified_code" 
                    value="<?php echo htmlspecialchars($minified); ?>"
                    readonly 
                    class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary font-mono text-sm"
                />
                
                <button 
                    type="button" 
                    id="copyBtn" 
                    class="absolute top-1/2 right-2 transform -translate-y-1/2 px-3 py-1 bg-gray-700 text-white text-sm rounded hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500 transition-colors duration-200"
                >
                    Copy
                </button>
            </div>
            
            <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-gray-50 rounded-lg p-3 text-center">
                    <p class="text-sm text-gray-500">Original</p>
                    <p class="text-lg font-medium text-gray-800"><?php echo number_format(strlen($original)); ?> chars</p>
                </div>
                
                <div class="bg-gray-50 rounded-lg p-3 text-center">
                    <p class="text-sm text-gray-500">Minified</p>
                    <p class="text-lg font-medium text-gray-800"><?php echo number_format(strlen($minified)); ?> chars</p>
                </div>
                
                <div class="bg-green-50 rounded-lg p-3 text-center">
                    <p class="text-sm text-gray-500">Reduction</p>
                    <p class="text-lg font-medium text-green-700">
                        <?php echo round((1 - strlen($minified) / strlen($original)) * 100, 1); ?>%
                    </p>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </main>

    <footer class="bg-white border-t border-gray-200 mt-auto">
        <div class="container mx-auto px-4 py-6 max-w-4xl">
            <p class="text-gray-600 text-center">&copy; <a href="https://minisoft.it/" class="text-primary hover:text-primary-dark">Minisoft</a> — All rights reserved</p>
        </div>
    </footer>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const pasteMinifyBtn = document.getElementById('pasteMinifyBtn');
            const jsCodeTextarea = document.getElementById('js_code');
            const minifyForm = document.getElementById('minifyForm');
            
            // Clipboard paste and minify functionality
            pasteMinifyBtn.addEventListener('click', async function() {
                try {
                    // Read from clipboard
                    const clipboardText = await navigator.clipboard.readText();
                    
                    if (!clipboardText.trim()) {
                        alert('Clipboard is empty. Please copy some JavaScript code first!');
                        return;
                    }
                    
                    // Set the textarea value
                    jsCodeTextarea.value = clipboardText;
                    
                    // Submit the form
                    minifyForm.submit();
                } catch (err) {
                    alert('Clipboard access error. Please ensure you have copied code to your clipboard.');
                }
            });
            
            // Copy to clipboard functionality
            const copyBtn = document.getElementById('copyBtn');
            if (copyBtn) {
                copyBtn.addEventListener('click', function() {
                    const minifiedCode = document.getElementById('minified_code');
                    minifiedCode.select();
                    
                    try {
                        // Modern clipboard API
                        navigator.clipboard.writeText(minifiedCode.value)
                            .then(() => {
                                // Change button text temporarily
                                const originalText = copyBtn.textContent;
                                copyBtn.textContent = 'Copied!';
                                
                                // Reset button text after 2 seconds
                                setTimeout(function() {
                                    copyBtn.textContent = originalText;
                                }, 2000);
                            })
                            .catch(err => {
                                // Fallback to old method if clipboard API fails
                                document.execCommand('copy');
                                
                                // Change button text temporarily
                                const originalText = copyBtn.textContent;
                                copyBtn.textContent = 'Copied!';
                                
                                // Reset button text after 2 seconds
                                setTimeout(function() {
                                    copyBtn.textContent = originalText;
                                }, 2000);
                            });
                    } catch (err) {
                        // Fallback to old method if clipboard API is not available
                        document.execCommand('copy');
                        
                        // Change button text temporarily
                        const originalText = copyBtn.textContent;
                        copyBtn.textContent = 'Copied!';
                        
                        // Reset button text after 2 seconds
                        setTimeout(function() {
                            copyBtn.textContent = originalText;
                        }, 2000);
                    }
                });
            }
        });
    </script>
</body>
</html>