<div class="span4">
  <div class="sub_right_widget">
    <h3>カテゴリー</h3>
    <ul>
      <?php foreach (gv_sidebar_categories() as $slug => $label) : ?>
        <?php
        $category = get_category_by_slug($slug);
        $url = $category ? get_category_link($category) : home_url('/archives/category/' . $slug . '/');
        $is_current = $category && is_category($category->term_id);
        ?>
        <li class="cat-item<?php echo $is_current ? ' current-cat' : ''; ?>">
          <a href="<?php echo esc_url($url); ?>"<?php echo $is_current ? ' aria-current="page"' : ''; ?>><?php echo esc_html($label); ?></a>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
  <div class="widget_text common_right_widget">
    <div class="textwidget custom-html-widget">
      <a href="https://grand-village.yokohama/archives/323"><img src="<?php echo gv_asset('images/assets/bn_turnedk.jpg'); ?>" class="marg-bottom15" alt="空気清浄機" /></a>
    </div>
  </div>
  <div class="common_right_widget">
    <div class="textwidget">
      <p class="comment">コース料理や貸し切りパーティーも受け付けています！お気軽にご相談下さい。</p>
    </div>
  </div>
</div>

