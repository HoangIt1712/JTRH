<?php 
    session_start();
    $cart = isset($_SESSION["cart"])?$_SESSION["cart"]:[];
    require_once("./functions/db.php");
    $categories = select("select * from categories");
?>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/">Home</a>
        </li>
        <?php foreach($categories as $item):?>
        <li class="nav-item">
          <a class="nav-link" href="/category.php?id=<?php echo $item["id"];?>"><?php echo $item["NAME"];?></a>
        </li>
        <?php endforeach;?>
      </ul>
      <form action="/search.php" method="get" class="d-flex" role="search">
        <input name="query" class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
      <a href="/cart.php" class="btn btn-outline-dark ms-1">
        <i class="bi bi-cart"></i>
        <span class="badge rounded-pill text-bg-dark"><?php echo count($cart);?></span>
      </a>
    </div>
  </div>
</nav>