<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>PDF2SVG</title>
    <link rel="stylesheet" href="assets/style.css">
  </head>
  <body>
<?php foreach($deck as $svg): ?>
    <div><img src="<?= $svg ?>"></div>
<?php endforeach; ?>
  </body>
</html>
