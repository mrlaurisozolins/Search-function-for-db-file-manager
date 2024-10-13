<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once '/var/webserver/www/classes/config.php';

function searchFilesAndDirectoriesByID($directories, $searchTerm) {
    $entriesFound = [];

    if (!preg_match('/^\d{6,8}$/', $searchTerm)) {
        return []; 
    }

    foreach ($directories as $directory) {
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($directory, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($iterator as $entry) {
            $entryName = $entry->getFilename();
            $relativePath = str_replace($directory, '', $entry->getPathname());

            if (preg_match('/\b' . preg_quote($searchTerm, '/') . '\b/', $entryName)) {
                if ($entry->isDir()) {
                    $path = (strpos($directory, 'scan') !== false) 
                            ? 'scan://' . ltrim($relativePath, '/') 
                            : 'faili://' . ltrim($relativePath, '/');
                    $url = 'http://192.168.111.200/faili/' . ltrim(dirname($relativePath), '/') . '/?highlight=' . urlencode($searchTerm);
                    $entriesFound[] = [
                        'type' => 'directory',
                        'path' => $path,
                        'url' => $url
                    ];
                } elseif ($entry->isFile()) {
                    $path = (strpos($directory, 'scan') !== false)
                            ? 'scan://' . ltrim($relativePath, '/') 
                            : 'faili://' . ltrim($relativePath, '/');
                    $url = 'http://192.168.111.200/faili/' . ltrim(dirname($relativePath), '/') . '/?highlight=' . urlencode($searchTerm);
                    $entriesFound[] = [
                        'type' => 'file',
                        'path' => $path,
                        'url' => $url
                    ];
                }
            }
        }
    }

    return $entriesFound;
}

$directories = [
    '/var/webserver/share/main/scan/',
    '/var/webserver/share/main/files/'
];

if (isset($_POST['searchName'])) {
    $searchTerm = $_POST['searchName'];

    if (!empty($searchTerm)) {
        $foundEntries = searchFilesAndDirectoriesByID($directories, $searchTerm);

        if (count($foundEntries) > 0) {
            $jsonResponse = json_encode([
                'success' => true,
                'entries' => $foundEntries
            ]);

            if (json_last_error() !== JSON_ERROR_NONE) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Kļūda, apstrādājot JSON atbildi: ' . json_last_error_msg()
                ]);
            } else {
                echo $jsonResponse;
            }
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Fails vai direktorija ar ID ' . htmlspecialchars($searchTerm) . ' netika atrasta.'
            ]);
        }
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Meklēšanas termins nav norādīts.'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Nav norādīts meklēšanas termins.'
    ]);
}
