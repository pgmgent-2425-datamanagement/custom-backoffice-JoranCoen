<?php

namespace App\Controllers;

class FileManagerController extends BaseController {
    public static function upload() {
        if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../public/uploads/';
            $uploadedFile = $_FILES['file'];
            $filename = uniqid() . '-' . basename($uploadedFile['name']);
            $targetFilePath = $uploadDir . $filename;

            $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif', 'application/pdf', 'text/plain'];
            $fileMimeType = mime_content_type($uploadedFile['tmp_name']);

            if (!in_array($fileMimeType, $allowedMimeTypes)) {
                self::loadView('/error', [
                    'title' => 'Error',
                    'message' => 'Invalid file type.'
                ]);
                exit();
            }

            if (move_uploaded_file($uploadedFile['tmp_name'], $targetFilePath)) {
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                exit();
            } else {
                self::loadView('/error', [
                    'title' => 'Error',
                    'message' => 'File upload failed.'
                ]);
            }
        } else {
            self::loadView('/error', [
                'title' => 'Error',
                'message' => 'No file uploaded or an error occurred.'
            ]);
        }
        exit();
    }

    public static function delete() {
        $file = $_POST['file'] ?? null;
        if (!$file) {
            self::loadView('/error', [
                'title' => 'Error',
                'message' => 'File not specified.'
            ]);
            exit();
        }

        $filePath = __DIR__ . '/../public/uploads/' . basename($file);
        if (file_exists($filePath)) {
            if (unlink($filePath)) {
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                exit();
            } else {
                self::loadView('/error', [
                    'title' => 'Error',
                    'message' => 'Failed to delete the file.'
                ]);
            }
        } else {
            self::loadView('/error', [
                'title' => 'Error',
                'message' => 'File does not exist.'
            ]);
        }
        exit();
    }
}
