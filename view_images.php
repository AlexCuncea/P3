<?php
session_start();
if (!isset($_SESSION['username']) && isset($_COOKIE['username'])) {
    $_SESSION['username'] = $_COOKIE['username'];
}
if (!isset($_SESSION['username'])) {
    header("Location: login_page.php");
    exit();
}

require 'vendor/autoload.php'; // Include autoload-ul Composer

$client = new MongoDB\Client("mongodb://127.0.0.1:27017");
$database = $client->selectDatabase('amitdb');
$collection = $database->selectCollection('imagini');

$images = $collection->find(['username' => $_SESSION['username']]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Imaginile Mele</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container">
        <h1>Imaginile Mele</h1>
        <?php if ($images): ?>
            <div class="row">
                <?php foreach ($images as $image): ?>
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <img src="view_image.php?id=<?= $image['_id'] ?>" class="card-img-top" alt="<?= htmlspecialchars($image['name']) ?>">
                            <div class="card-body">
                                <p class="card-text"><?= htmlspecialchars($image['name']) ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>Nu aveți nicio imagine încărcată.</p>
        <?php endif; ?>
    </div>
</body>
</html>
