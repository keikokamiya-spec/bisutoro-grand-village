<?php
get_header();
get_template_part('template-parts/page-title', null, array('title' => 'ランチ'));

$latest_lunch = get_posts(array(
    'category_name' => 'lunch',
    'posts_per_page' => 1,
));
$latest_lunch_url = $latest_lunch ? get_permalink($latest_lunch[0]) : home_url('/archives/category/lunch/');
?>
<section id="main">
  <div class="container">
    <div class="row">
      <div class="span12">
        <p class="balloon">
          ご予算に応じてコース料理でお作りする事や<br class="sp_only">アラカルトメニューもご注文可能です。<br />お気軽にお問い合わせ下さい
          <span>※ランチタイムは現金のみのお会計とさせて頂きます。</span>
        </p>
        <dl class="menu lunch-menu-list">
          <dt class="cate marg-top0">ランチメニュー<span>Lunch Menu</span></dt>
          <dt><a href="<?php echo esc_url($latest_lunch_url); ?>">Aセット</a></dt>
          <dt><a href="<?php echo esc_url($latest_lunch_url); ?>">Bセット</a></dt>
          <dt><a href="<?php echo esc_url($latest_lunch_url); ?>">Cセット</a></dt>
          <dt><a href="<?php echo esc_url($latest_lunch_url); ?>">Dセット</a></dt>
          <dt><a href="<?php echo esc_url($latest_lunch_url); ?>">追加</a></dt>
          <dt><a href="<?php echo esc_url($latest_lunch_url); ?>">ランチ限定</a></dt>
        </dl>
        <p class="lunch-blog-note"><a href="<?php echo esc_url($latest_lunch_url); ?>">各セット内容や最新の詳細はブログをご確認ください。</a></p>
      </div>
    </div>
  </div>
</section>
<?php get_footer(); ?>

