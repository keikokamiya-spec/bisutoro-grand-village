<?php
$defaults = bgv_default_kokuban_images();
$image_1 = bgv_get_field('blackboard_image_1', 0, get_the_ID());
$image_2 = bgv_get_field('blackboard_image_2', 0, get_the_ID());
$image_1_alt = bgv_get_field('blackboard_image_1_alt', '黒板メニュー1', get_the_ID());
$image_2_alt = bgv_get_field('blackboard_image_2_alt', '黒板メニュー2', get_the_ID());
?>
<div class="kokuban-menu-images">
  <?php if ($image_1 && is_numeric($image_1)) : ?>
    <?php echo wp_get_attachment_image((int) $image_1, 'full', false, array('alt' => esc_attr($image_1_alt), 'fetchpriority' => 'high')); ?>
  <?php elseif (! empty($defaults[0]['url'])) : ?>
    <img width="945" height="705" src="<?php echo esc_url($defaults[0]['url']); ?>" alt="<?php echo esc_attr($image_1_alt); ?>" decoding="async" fetchpriority="high" />
  <?php endif; ?>
  <?php if ($image_2 && is_numeric($image_2)) : ?>
    <?php echo wp_get_attachment_image((int) $image_2, 'full', false, array('alt' => esc_attr($image_2_alt), 'loading' => 'lazy')); ?>
  <?php elseif (! empty($defaults[1]['url'])) : ?>
    <img width="934" height="698" src="<?php echo esc_url($defaults[1]['url']); ?>" alt="<?php echo esc_attr($image_2_alt); ?>" decoding="async" loading="lazy" />
  <?php endif; ?>
</div>
