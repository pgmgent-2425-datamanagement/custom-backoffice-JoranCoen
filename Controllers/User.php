<?php

namespace App\Controllers;

use App\Models\User;

class UserController extends BaseController {
    public static function update() {
        $userModel = new User();
        $user_id = $_POST['user_id'] ?? null;

        $user = $userModel->findById($user_id);

        if (!$user) {
            self::loadView('/error', [
                'title' => 'Error',
                'message' => 'User not found.'
            ]);
            exit();
        }

        $username = $_POST['username'] ?? null;
        $email = $_POST['email'] ?? null;
        $role = $_POST['role'] ?? null;
        $status = $_POST['status'] ?? null;

        if (!$username || !$email || !$role || !$status) {
            self::loadView('/error', [
                'title' => 'Error',
                'message' => 'Invalid input data.'
            ]);
            exit();
        }

        $profilePicturePath = $user->profile_picture; 
        if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../public/uploads/';
            $uploadedFile = $_FILES['profile_picture'];
            $filename = uniqid() . '-' . basename($uploadedFile['name']);
            $targetFilePath = $uploadDir . $filename;

            $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
            $fileMimeType = mime_content_type($uploadedFile['tmp_name']);
            if (!in_array($fileMimeType, $allowedMimeTypes)) {
                self::loadView('/error', [
                    'title' => 'Error',
                    'message' => 'Invalid file type.'
                ]);
                exit();
            }

            if (move_uploaded_file($uploadedFile['tmp_name'], $targetFilePath)) {
                $profilePicturePath = '/uploads/' . $filename;
            } else {
                self::loadView('/error', [
                    'title' => 'Error',
                    'message' => 'File upload failed.'
                ]);
                exit();
            }
        }

        $userModel->update($user_id, [
            'username' => htmlspecialchars($username),
            'email' => htmlspecialchars($email),
            'role' => htmlspecialchars($role),
            'status' => htmlspecialchars($status),
            'profile_picture' => htmlspecialchars($profilePicturePath),
        ]);

        if (isset($_SESSION['user']) && $_SESSION['user']['user_id'] == $user_id) {
            $_SESSION['user']['username'] = htmlspecialchars($username);
            $_SESSION['user']['email'] = htmlspecialchars($email);
            $_SESSION['user']['role'] = htmlspecialchars($role);
            $_SESSION['user']['status'] = htmlspecialchars($status);
            $_SESSION['user']['profile_picture'] = htmlspecialchars($profilePicturePath);
        }

        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }
}