<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['selected_files']) && is_array($_POST['selected_files']) && !empty($_POST['selected_files'])) {
        $selectedFiles = $_POST['selected_files'];

        header('Content-Type: application/zip');
        header('Content-Disposition: attachment; filename="selected_files.zip"');

        $zip = new ZipArchive();
        $zipFileName = tempnam(sys_get_temp_dir(), 'selected_files');
        if ($zip->open($zipFileName, ZipArchive::CREATE) === true) {
            foreach ($selectedFiles as $file) {
                if (file_exists(__DIR__ . '/' . $file)) {
                    $zip->addFile(__DIR__ . '/' . $file, $file);
                } else {
                    echo "Error: File '$file' not found.";
                    exit;
                }
            }
            $zip->close();
            
            header('Content-Length: ' . filesize($zipFileName));
            
            readfile($zipFileName);
            
            unlink($zipFileName);
            exit;
        } else {
            echo 'Error: Unable to create zip archive.';
            exit;
        }
    } else {
        echo 'No files selected for download.';
    }
} else {
    echo 'Invalid request.';
}
?>