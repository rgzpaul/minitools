<!-- v1.0 -->
<!DOCTYPE html>
<head>
    <meta charset="utf-8" />
    <title>tBody Extractor</title>
    <link href="https://minisoft.it/icons/fix.png" rel="shortcut icon" type="image/x-icon" />
    <link href="https://minisoft.it/icons/fix.png" rel="apple-touch-icon" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <link href="https://assets.website-files.com/6246ac7990532afc2998139b/css/bulkr.61864f60c.css" rel="stylesheet" type="text/css" />
    <style>
        textarea { resize: vertical; }
    </style>
</head>

<body>
    <div class="section wf-section">
        <div class="container">
            <h1>tBody Extractor</h1>
            <h2>HTML Table Data Extractor</h2>
        </div>
    </div>
    <div class="section grow wf-section">
        <div class="container">
            <div class="form w-form">
                <form method="post" id="wf-form-" name="wf-form-" class="form">
                    <label for="html" class="field-label">Paste your &lt;tbody&gt; here</label>
                    <textarea name="html" class="text-field area w-input" required></textarea>

                    <label for="columns" class="field-label">Column indices to extract</label>
                    <input type="text" name="columns" class="text-field w-input" placeholder="1,2" required />

                    <input type="submit" value="Extract Data" class="button w-button" />
                </form>

                <?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
                <div class="success-message w-form-done" style="display: block;">
                    <h2 style="color: 
#006e81; text-align: left;">Extracted Data:</h2>
                    <table style="width: 100%; border-collapse: collapse; margin-top: 1rem;">
                        <thead>
                            <tr>
                                <?php 
                                $selectedColumns = explode(',', $_POST['columns']);
                                foreach ($selectedColumns as $index): ?>
                                    <th style="background-color: 
#006e81; color: white; padding: 12px; text-align: left;">
                                        Column <?php echo htmlspecialchars(trim($index)); ?>
                                    </th>
                                <?php endforeach; ?>
                            </tr>
                        </thead>
                        <tbody>
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
                                        echo "<td style='padding: 10px; border: 1px solid rgba(0,0,0,0.1);'>" . 
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
                <?php endif; ?>
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