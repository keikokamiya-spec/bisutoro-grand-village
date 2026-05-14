<?php
$title = $args['title'] ?? get_the_title();
?>
<section id="pagetitle">
  <h1><?php echo esc_html($title); ?></h1>
</section>
<section id="breadcrumb">
  <div class="container">
    <ul>
      <li><a href="<?php echo esc_url(home_url('/')); ?>" class="home"><span>HOME</span></a></li>
      <li><span class="fa fa-caret-right"></span><span><?php echo esc_html($title); ?></span></li>
    </ul>
  </div>
</section>

