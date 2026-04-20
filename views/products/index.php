<h2>Products</h2>

<?php foreach ($products as $p): ?>
  <p>
    <?= $p['name'] ?> - ₹<?= $p['price'] ?>
  </p>
<?php endforeach; ?>