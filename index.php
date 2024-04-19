<!DOCTYPE html>
<html>
<head>
    <title>File List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 5;
            padding: 0;
        }
        .container {
            position: relative;
        }
        h1 {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 5px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        a {
            text-decoration: none;
            color: #007BFF;
        }
        .thumbnail {
            max-width: 124px;
            max-height: 124px;
        }
        .download-button-container {
            position: absolute;
            top: 15px;
            right: 20px;
        }
        .download-button {
            padding: 10px 20px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .download-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Files in This Directory</h1>
        <form action="download.php" method="post">
            <table>
                <thead>
                    <tr>
                        <th>Select</th>
                        <th>File Name</th>
                        <th>File Size (KB)</th>
                        <th>Thumbnail</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $directory = __DIR__;

                    // These files won't be shown.
                    $excludeFiles = array('.', '..', 'file_list.php');

                    if ($handle = opendir($directory)) {
                        while (false !== ($file = readdir($handle))) {
                            if (!in_array($file, $excludeFiles)) {
                                $filePath = $directory . '/' . $file;
                                if (is_file($filePath)) {
                                    $fileSize = filesize($filePath) / 1024;
                                    $fileSizeMB = filesize($filePath) / 1048576;
                                    echo "<tr>";
                                    echo "<td><input type='checkbox' name='selected_files[]' value='$file'></td>";
                                    echo "<td><a href='$file'>$file</a></td>";
                                    echo "<td>" . number_format($fileSize, 2) . " KB<br><br>" . number_format($fileSizeMB, 2) .  " MB</td>";

                                    $imageExtensions = array('jpg', 'jpeg', 'png', 'gif');
                                    $fileExtension = strtolower(pathinfo($file, PATHINFO_EXTENSION));

                                    echo "<td>";
                                    if (in_array($fileExtension, $imageExtensions)) {
                                        echo "<img src='thumbnail.php?file=$file' alt='Thumbnail' class='thumbnail'>";
                                    }
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            }
                        }
                        closedir($handle);
                    }
                    ?>
                </tbody>
            </table>
            <div class="download-button-container">
                <button type="submit" class="download-button">Download Selected</button>
            </div>
        </form>
    </div>
</body>
</html>