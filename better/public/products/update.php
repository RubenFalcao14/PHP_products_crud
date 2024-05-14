<?php
require_once "../../functions.php";
require_once "../../better/db.php";

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: index.php');
    exit;
}


$statement = $pdo->prepare('SELECT * FROM products WHERE Id = :id');
$statement->bindValue(':id', $id);
$statement->execute();
$product = $statement->fetch(PDO::FETCH_ASSOC);

$title = $product['Title'];
$description = $product['Description'];
$price = $product['Price'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    require_once "../better/validate_products.php";

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
  <?php include_once "../../better/views/partials/header.php"; ?>
  
<body>
<p>
    <a href="index.php" type="button" class="btn btn-secondary" style="background-color:#C39BD3;">Back to products</a>
</p>
<h1>Update Product: <b><?php echo $product['Title'] ?></b></h1>

 <?php include_once "../../better/views/products/form.php" ?>

</body>
</html>
