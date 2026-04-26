<!doctype html>
<html>
  <head>
    <title>Products</title>
  </head>
  <body>
    <h2>Products Dashboard</h2>
    <button onclick="logout()">Logout</button>

    <hr />

    <h2>Add Product</h2>
    <input type="text" id="name" placeholder="Product Name" />
    <button onclick="addProduct()">Add</button>

    <h2>Product List</h2>
    <ul id="productList"></ul>

    <script src="/PHP/public/assets/js/app.js"></script> 
  </body>
</html>
