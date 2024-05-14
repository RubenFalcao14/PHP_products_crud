<?php 
require_once "../../functions.php";
// to create connection to db

require_once "../better/db.php";



// save data in mysql by post method

$errors = [];

$title = '';
$description = '';
$price = '';
$product = [
    'image' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    require_once "../../better/validate_products.php";

    if (empty($errors)) {
        $statement = $pdo->prepare("INSERT INTO products (title, image, description, price, create_date)
                VALUES (:title, :image, :description, :price, :date)");
        $statement->bindValue(':title', $title);
        $statement->bindValue(':image', $imagePath);
        $statement->bindValue(':description', $description);
        $statement->bindValue(':price', $price);
        $statement->bindValue(':date', date('Y-m-d H:i:s'));

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
 <!----------------- table ------------------------>
 <h1>Create New Product</h1>

 <?php include_once "../../better/views/products/form.php" ?>

</body>
</html>
