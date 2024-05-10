<?php 
// to create connection to db

$pdo = new PDO('mysql:host=localhost;port=3306;dbname=php_products_crud', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 
$search = $_GET['search'] ?? '';
if($search){
  $statement = $pdo->prepare('SELECT * FROM products WHERE Title LIKE :title ORDER BY create_date DESC');
  $statement->bindValue(':title', "%$search%");
}
else{
  $statement = $pdo->prepare('SELECT * FROM products ORDER BY create_date DESC');
  
}

$statement->execute();
$products = $statement->fetchAll(PDO::FETCH_ASSOC); 
 
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products CRUD</title>
    <link href="style.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    
 <!----------------- table ------------------------>
 <h1>Products CRUD</h1>
  <br>

  
<!----------------------------------- search------------------------ -->
 <form action="" method="get">

    <div class="input-group mb-3" style="width:95%">
      <input type="text" class="form-control" placeholder="Search for products" name="search">
      <div class="input-group-append">
         <button class="btn btn-outline-secondary" type="submit">Search</button>
      </div>
    </div>
    
 </form>
 <br>

 <table class="table">
  <thead>
    <tr>
        
      <th scope="col">S.No</th>
      <th scope="col">Image</th>
      <th scope="col">Title</th>
      <th scope="col">Price</th>
      <th scope="col">Create Date</th>
      <th scope="col">Action</th>
    </tr>
  </thead>

  <tbody>
  <?php foreach ($products as $i => $product) { ?>
    <tr>
      <th scope="row"> <?php echo $i + 1 ?> </th>

      <td>
            <?php if ($product['Image']): ?>
                <img src="<?php echo $product['Image'] ?>" alt="<?php echo $product['Title'] ?>" class="product-img">
            <?php endif; ?>
      </td>
      <td> <?php echo $product['Title'] ?> </td>
      <td> <?php echo $product['Price'] ?> </td>
      <td> <?php echo $product['Create_date'] ?> </td>
    
    <td>
        <a style="display: inline-block" href="update.php?id=<?php echo $product['Id'] ?>" class="btn btn-sm btn-outline-primary">Edit</a>

        <form method="post" action="delete.php" style="display: inline-block">           
            <input  type="hidden" name="id" value="<?php echo $product['Id'] ?>"/>
            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>  
        </form>

        
    </td>
    </tr>

    </tr>
    <?php } ?> 

    
  </tbody>
</table>
<p style="padding:10px;">
  <a href="create_products.php" style="padding: 8px 15px;" type="button" class="btn btn-sm btn-success" >Add New Product</a>
</p>

</body>
</html>
