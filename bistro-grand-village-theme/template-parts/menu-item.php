<?php
$item = $args['item'] ?? array();
$name = $item['name'] ?? '';
$price = $item['price'] ?? '';
$image = $item['image'] ?? '';
$url = $item['url'] ?? '';
?>
<?php if ($name !== '') : ?>
  <dt><?php echo bgv_linked_name($name, $image, $url); ?></dt>
<?php endif; ?>
<?php if ($price !== '') : ?>
  <dd><?php echo wp_kses_post($price); ?></dd>
<?php endif; ?>

