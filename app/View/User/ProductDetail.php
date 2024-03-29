<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
  <div class="container-fluid m-3">
    <a class="navbar-brand fab fa-apple ms-3 me-5" href="/toko_online/public/" style="letter-spacing: 0.2rem;"><?= $model['logo'] ?? '' ?></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto gap-5">
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="/toko_online/public/users/listProduct?category=<?= $category = 'iPhone'; ?>">iPhone</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="/toko_online/public/users/listProduct?category=<?= $category = 'iPad'; ?>">iPad</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="/toko_online/public/users/listProduct?category=<?= $category = 'Mac'; ?>">Mac</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="/toko_online/public/users/listProduct?category=<?= $category = 'Watch'; ?>">Watch</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="/toko_online/public/users/listProduct?category=<?= $category = 'Tv'; ?>">Tv</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="/toko_online/public/users/about">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link fa-solid fa-cart-shopping mt-1" aria-current="page" href="/toko_online/public/users/cart?category=<?= $category = 'Cart'; ?>"></a>
        </li>
      </ul>
      <form class="d-flex" role="search">
        <input class="form-control form-control-sm me-2" type="text" placeholder="Search" aria-label="Search">
        <button class="btn btn-primary" type="submit">Search</button>
      </form>
      <ul class="navbar-nav ms-5 me-5">
        <li class="nav-item me-2 dropdown">
          <a class="nav-link fa-solid fa-user" aria-current="page" data-bs-toggle="dropdown" aria-expanded="false"></a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="/toko_online/public/users/dashboard">Profile</a></li>
            <li><a class="dropdown-item" href="/toko_online/public/users/logout">Logout</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
<div class="alerttt">
  <?php
  if ($model['error'] != null) :
  ?>
    <div class="alert alert-danger text-center" role="alert">
      <?= $model['error'] ?? null ?>
    </div>
  <?php
  endif;
  ?>
</div>
<div class="containerrr">
  <form action="/toko_online/public/users/productDetail" method="POST">
    <div class="row gap-0 column-gap-3 my-5" style="justify-content:center;">
      <!-- product image -->
      <div class="container-fluid col-2 m-2" style="border: 1px solid  #dee2e6; height:30vh;">
        <div style="justify-content:center; align-items:center; display:flex; height:30vh">
          <img src="http://localhost/toko_online/public/assets/images/products/<?= $model['productImage'] ?? '' ?>" alt="<?= $model['productName'] ?? '' ?>" style="width:150px;">
        </div>
      </div>
      <!-- form product -->
      <div class="container-fluid col-5 m-2" style="border: 1px solid  #dee2e6; height:auto;">
        <h2 class="text-center m-4"><?= $model['productName'] ?? null ?></h2>
        <input type="text" name="id" value="<?= $model['productId'] ?? null ?>" hidden>
        <input type="text" name="stock" value="<?= $model['productStock'] ?? null ?>" hidden>
        <hr>
        <div class="row mt-5 mb-4 ms-4 gap-0 row-gap-3">
          <?php if ($model['productStock'] >= 1) { ?>
            <p class="col-12"> <span class="fa-solid fa-check"></span> Product Available</p>
          <?php } else if ($model['productStock'] <= 0) { ?>
            <p class="col-12"> <span class="fa-solid fa-xmark"></span> Product Isn't Available</p>
          <?php
          }
          ?>
          <label for="color">Color :</label>
          <select class="form-select" name="color" id="color" aria-label="Default select example" style="width: 300px;">
            <option value="<?= $model['productColor'] ?? '' ?>"><?= $model['productColor'] ?? '' ?></option>
          </select>
          <label for="capacity">Capacity :</label>
          <select class="form-select" name="capacity" id="capacity" aria-label="Default select example" style="width: 300px;">
            <option value="<?= $model['productCapacity'] ?? '' ?>"><?= $model['productCapacity'] ?? '' ?></option>
          </select>
        </div>
        <hr>
        <div class="row mt-5 mb-4 ms-4 gap-0 row-gap-3">
          <p>Description :</p>
          <p><?= $model['productDescription'] ?? '' ?></p>
        </div>

      </div>
      <!-- price product and total -->
      <div class="container-fluid col-3 m-2" style="border: 1px solid  #dee2e6; height:100vh">
        <div class="row mt-5 mb-4 gap-0 row-gap-3" style="justify-content:center; align-items:center; display:flex;">
          <p class="text-center">Price :</p>
          <h2 class="text-center"><?= $model['productPrice'] ?? '' ?> IDR</h2>
          <input type="text" name="price" value="<?= $model['productPrice'] ?? '' ?>" hidden>
          <label for="exampleFormControlInput1" class="form-label text-center mt-4">Quantity :</label>
          <input type="text" name="quantity" class="form-control mb-4" id="exampleFormControlInput1" style="width: 50%;" value="1">
          <button type="submit" value="true" name="buyNow" class="btn btn-primary m-2" style="width:50%;">Buy Now</button>
          <button type="submit" value="true" name="addToCart" class="btn btn-primary m-2" style="width:50%">Add To Cart</button>
        </div>
      </div>
    </div>
  </form>
</div>