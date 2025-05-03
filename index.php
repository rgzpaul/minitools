<!-- v1.0 -->
<?php
// Directory to scan
$directory = __DIR__;
// Get the name of this script to exclude it
$self = basename(__FILE__);
?>
<!DOCTYPE html>

<head>
    <meta charset="utf-8" />
    <title>Minitools</title>
    <link href="https://minisoft.it/icons/fix.png" rel="shortcut icon" type="image/x-icon" />
    <link href="https://minisoft.it/icons/fix.png" rel="apple-touch-icon" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <link href="https://assets.website-files.com/6246ac7990532afc2998139b/css/bulkr.61864f60c.css" rel="stylesheet" type="text/css" />
    <style>
        ul {
            margin: 0;
            padding: 0;
        }

        .tools-list {
            list-style-type: none;
            text-align: center;
        }

        .tools-list li {
            margin: 16px 0;
        }

        .tools-list a {
            display: inline-block;
            color: #006e81;
            text-decoration: none;
            padding: 10px;
            border: 1px solid rgba(0, 0, 0, 0.1);
            background: #fafafa;
            width: 100%;
            box-sizing: border-box;
            transition: background-color 0.2s;
        }

        .tools-list a:hover {
            background: #f5f5f5;
        }
    </style>
</head>

<body>
    <div class="section wf-section">
        <div class="container">
            <h1>Minitools</h1>
            <h2>Utilities Collection</h2>
        </div>
    </div>
    <div class="section grow wf-section">
        <div class="container">
            <div class="form w-form">
                <ul class="tools-list">
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
                            echo "<li><a href='$filePath'>$fileName</a></li>";
                        }
                    } else {
                        echo "<p>Could not open directory.</p>";
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="section wf-section">
        <div class="container">
            <div>© <a href="https://minisoft.it/">Minisoft</a> — All rights reserved</div>
        </div>
    </div>
</body>

</html>