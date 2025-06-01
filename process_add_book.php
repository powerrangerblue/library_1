<?php
session_start();

// Only allow librarians here
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'librarian') {
    header("Location: login.php");
    exit;
}

// Database connection
$host = 'localhost';
$user = 'root'; // your DB username
$pass = '';     // your DB password
$dbname = 'librarydb';

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Sanitize and validate inputs
$title = trim($_POST['title']);
$author = trim($_POST['author']);
$isbn = trim($_POST['isbn']);
$publisher = trim($_POST['publisher']);
$year = intval($_POST['year']);
$genre = trim($_POST['genre']);
$total_copies = intval($_POST['copies']);
$shelf = trim($_POST['shelf']);

// Cover image upload handling
$cover_image_path = null;
if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['cover_image']['tmp_name'];
    $fileName = $_FILES['cover_image']['name'];
    $fileSize = $_FILES['cover_image']['size'];
    $fileType = $_FILES['cover_image']['type'];
    $fileNameCmps = explode(".", $fileName);
    $fileExtension = strtolower(end($fileNameCmps));

    $allowedfileExtensions = ['jpg', 'jpeg', 'png', 'gif'];
    if (in_array($fileExtension, $allowedfileExtensions)) {
        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
        $uploadFileDir = './uploads/';
        if (!is_dir($uploadFileDir)) {
            mkdir($uploadFileDir, 0755, true);
        }
        $dest_path = $uploadFileDir . $newFileName;

        if(move_uploaded_file($fileTmpPath, $dest_path)) {
            $cover_image_path = $dest_path;
        } else {
            // Handle upload error
            echo "Error moving the uploaded file.";
            exit;
        }
    } else {
        echo "Upload failed. Allowed file types: " . implode(", ", $allowedfileExtensions);
        exit;
    }
}

// Insert into database
$stmt = $conn->prepare("INSERT INTO books (title, author, isbn, publisher, year, genre, total_copies, available_copies, shelf, cover_image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

$available_copies = $total_copies; // Initially all copies are available

$stmt->bind_param(
    "sssssisiss",
    $title,
    $author,
    $isbn,
    $publisher,
    $year,
    $genre,
    $total_copies,
    $available_copies,
    $shelf,
    $cover_image_path
);

if ($stmt->execute()) {
    // Success - redirect to add book page or show success message
    header("Location: add_book.php?success=1");
    exit;
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
