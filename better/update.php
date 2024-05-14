<?php
require_once "functions.php";

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: index.php');
    exit;
}

require_once "../better/db.php";

$statement = $pdo->prepare('SELECT * FROM products WHERE Id = :id');
$statement->bindValue(':id', $id);
$statement->execute();
$product = $statement->fetch(PDO::FETCH_ASSOC);

$title = $product['Title'];
$description = $product['Description'];
$price = $product['Price'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    $image = $_FILES['image'] ?? null;
    $imagePath = '';

    if (!is_dir('images')) {
        mkdir('images');
    }

    if ($image) {
        if ($product['Image']) {
            unlink($product['Image']);
        }
        $imagePath = 'images/' . randomString(8) . '/' . $image['name'];
        mkdir(dirname($imagePath));
        move_uploaded_file($image['tmp_name'], $imagePath);
    }

    if (!$title) {
        $errors[] = 'Product title is required';
    }

    if (!$price) {
        $errors[] = 'Product price is required';
    }

    if (empty($errors)) {
        $statement = $pdo->prepare("UPDATE products SET Title = :title, 
                                        Image = :image, 
                                        Description = :description, 
                                        Price = :price WHERE Id = :id");
        $statement->bindValue(':title', $title);
        $statement->bindValue(':image', $imagePath);
        $statement->bindValue(':description', $description);
        $statement->bindValue(':price', $price);
        $statement->bindValue(':id', $id);

        $statement->execute();
        header('Location: index.php');
    }

}

?>
  <?php include_once "../better/views/partials/header.php"; ?>
  
<body>
<p>
    <a href="index.php" type="button" class="btn btn-secondary" style="background-color:#C39BD3;">Back to products</a>
</p>
<h1>Update Product: <b><?php echo $product['Title'] ?></b></h1>

 <?php include_once "../better/views/products/form.php" ?>

</body>
</html>
