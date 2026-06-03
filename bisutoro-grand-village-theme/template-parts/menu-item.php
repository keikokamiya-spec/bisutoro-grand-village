<?php
$item = isset($args['item']) ? $args['item'] : array();
$name = isset($item['name']) ? $item['name'] : '';
$price = isset($item['price']) ? $item['price'] : '';
$image = isset($item['image']) ? $item['image'] : '';
$url = isset($item['url']) ? $item['url'] : '';
?>
<?php if ($name !== '') : ?>
  <dt><?php echo bgv_linked_name($name, $image, $url); ?></dt>
<?php endif; ?>
<?php if ($price !== '') : ?>
  <dd><?php echo wp_kses_post($price); ?></dd>
<?php endif; ?>
