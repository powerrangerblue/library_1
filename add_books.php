<?php
session_start();

// Only allow librarians here
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'librarian') {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Add Books - Librarian</title>
  <style>
    /* Reset & base */
    * {
      box-sizing: border-box;
    }
    body {
      font-family: Arial, sans-serif;
      background: #f9f4f1;
      padding: 2rem;
      margin: 0;
      display: flex;
      justify-content: center;
      min-height: 100vh;
    }

    .container {
      background: white;
      padding: 2rem 2.5rem;
      border-radius: 12px;
      box-shadow: 0 6px 15px rgba(0,0,0,0.1);
      max-width: 600px;
      width: 100%;
    }

    h1 {
      color: #ddbea9;
      margin-bottom: 1.5rem;
      text-align: center;
    }

    form {
      display: grid;
      grid-template-columns: 1fr 2fr;
      gap: 1rem 1.5rem;
      align-items: center;
    }

    label {
      font-weight: 600;
      color: #5a4a42;
    }

    input[type="text"],
    input[type="number"],
    select,
    input[type="file"] {
      width: 100%;
      padding: 8px 10px;
      border: 1px solid #ddd;
      border-radius: 6px;
      font-size: 1rem;
      transition: border-color 0.2s ease;
    }

    input[type="text"]:focus,
    input[type="number"]:focus,
    select:focus,
    input[type="file"]:focus {
      border-color: #ddbea9;
      outline: none;
    }

    .full-width {
      grid-column: 1 / -1;
    }

    input[type="submit"] {
      grid-column: 1 / -1;
      background-color: #ddbea9;
      border: none;
      padding: 12px 0;
      color: black;
      font-weight: 700;
      font-size: 1.1rem;
      border-radius: 10px;
      cursor: pointer;
      transition: background-color 0.3s ease;
      margin-top: 1rem;
    }

    input[type="submit"]:hover {
      background-color: #c7a88d;
    }

    /* Responsive */
    @media (max-width: 480px) {
      form {
        grid-template-columns: 1fr;
      }
      label {
        margin-bottom: 0.3rem;
      }
      input[type="submit"] {
        padding: 14px 0;
      }
    }
  </style>
</head>
<body>

  <div class="container">
    <h1>Add New Book</h1>

    <form method="post" action="process_add_book.php" enctype="multipart/form-data">
      <label for="title">Book Title <span style="color:red">*</span>:</label>
      <input type="text" name="title" id="title" required />

      <label for="author">Author <span style="color:red">*</span>:</label>
      <input type="text" name="author" id="author" required />

      <label for="isbn">ISBN <span style="color:red">*</span>:</label>
      <input type="text" name="isbn" id="isbn" required />

      <label for="publisher">Publisher <span style="color:red">*</span>:</label>
      <input type="text" name="publisher" id="publisher" required />

      <label for="year">Publication Year <span style="color:red">*</span>:</label>
      <input type="number" name="year" id="year" min="1000" max="<?= date('Y') ?>" required />

      <label for="genre">Category / Genre <span style="color:red">*</span>:</label>
      <select name="genre" id="genre" required>
        <option value="" disabled selected>-- Select Genre --</option>
        <option value="Fiction">Fiction</option>
        <option value="Nonfiction">Nonfiction</option>
        <option value="Science">Science</option>
        <option value="History">History</option>
        <option value="Biography">Biography</option>
        <option value="Fantasy">Fantasy</option>
        <option value="Mystery">Mystery</option>
        <option value="Self-Help">Self-Help</option>
        <option value="Other">Other</option>
      </select>

      <label for="copies">Number of Copies <span style="color:red">*</span>:</label>
      <input type="number" name="copies" id="copies" min="1" value="1" required />

      <label for="shelf">Shelf Location <span style="color:red">*</span>:</label>
      <input type="text" name="shelf" id="shelf" placeholder="e.g., A3-12" required />

      <label for="cover_image">Book Cover Image (optional):</label>
      <input type="file" name="cover_image" id="cover_image" accept="image/*" />

      <input type="submit" value="Add Book" />
    </form>
  </div>

</body>
</html>
