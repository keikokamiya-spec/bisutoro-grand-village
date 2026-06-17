<?php
/*
Template Name: トップページ
*/
get_header();
$gallery_page = get_page_by_path('gallery');
$gallery_post_id = $gallery_page ? $gallery_page->ID : 0;
?>

<section id="top_cover">
  <div class="hero_frame">
    <div class="flexslider">
      <ul class="slides">
        <li><img src="<?php echo bgv_asset_uri('assets/images/assets/slide1.jpg'); ?>" alt="TOPスライダー1" /></li>
        <li><img src="<?php echo bgv_asset_uri('assets/images/assets/slide2.jpg'); ?>" alt="TOPスライダー2" /></li>
        <li><img src="<?php echo bgv_asset_uri('assets/images/assets/slide4.jpg'); ?>" alt="TOPスライダー4" /></li>
        <li><img src="<?php echo bgv_asset_uri('assets/images/assets/slide5.jpg'); ?>" alt="TOPスライダー5" /></li>
        <li><img src="<?php echo bgv_asset_uri('assets/images/assets/slide6.jpg'); ?>" alt="TOPスライダー6" /></li>
      </ul>
    </div>
    <div class="hero_overlay" aria-hidden="true"></div>
    <div class="hero_panel">
      <p class="hero_panel_lead">Bistrot Grand Village</p>
      <p class="hero_panel_logo"><img src="<?php echo bgv_asset_uri('assets/images/assets/logo.png'); ?>" alt="ビストロ グランヴィラージュ" /></p>
      <span class="hero_panel_scroll">Scroll</span>
    </div>
  </div>
</section>

<section id="home_instagram">
  <div class="container">
    <div class="section_shell instagram_shell">
      <h3 class="common">インスタグラム<span>Instagram Updates</span></h3>
      <behold-widget feed-id="lb2drNmkH9yYiftIAmYC"></behold-widget>
      <a href="https://www.instagram.com/bistrot_grandvillage/" target="_blank" class="more">Instagramを見る</a>
    </div>
  </div>
</section>

<section id="home_concept">
  <div class="container">
    <div class="section_shell concept_shell">
      <div class="concept_txt">
        <h3><img src="<?php echo bgv_asset_uri('assets/images/assets/logo.png'); ?>" alt="コンセプト" /></h3>
        <p>料理の世界に入った時から生まれ育った地元で自分のお店を出す事を夢見ていました。</p>
        <p>堅いイメージのあるフレンチですが当店は幅広い年齢層の方に立ち寄って頂ける様な温かい雰囲気のお店となっております。</p>
        <p>是非御家族、御友人を誘って御来店下さい。</p>
        <p>コース料理や貸し切りパーティーも受け付けています！お気軽にご相談下さい。</p>
      </div>
      <div class="home_banners">
        <figure><img src="<?php echo bgv_asset_uri('assets/images/assets/bn_hamanavi.jpg'); ?>" alt="ハマナビ 番組内で当店を紹介いただきました。" /></figure>
        <figure><img src="<?php echo bgv_asset_uri('assets/images/assets/bn_turnedk.jpg'); ?>" alt="光触媒による空気清浄機 導入しました！" /></figure>
      </div>
    </div>
  </div>
</section>

<section id="home_profile">
  <div class="container">
    <div class="section_shell profile_shell">
      <h3 class="common">シェフプロフィール<span>Chef Profile</span></h3>
      <div class="row profile_row">
        <div class="span3 profile_photo_wrap">
          <img src="<?php echo bgv_asset_uri('assets/images/assets/chef2.jpg'); ?>" class="prof_photo" alt="大村 航介" />
        </div>
        <div class="span9 profile_text">
          <h4>大村 航介<span>Kosuke Omura</span></h4>
          <p>高校卒業後 エコール辻 東京フランス・イタリア料理専門カレッジに入学し料理の基礎を学ぶ。</p>
          <p>卒業後 横浜元町霧笛楼、トラットリア  オ・プレチェネッラ、うかい亭を経て 関内ボンマルシェ でオープニングより店長兼料理長として携わる。</p>
        </div>
      </div>
    </div>
  </div>
</section>

<section id="home_interior_exterior">
  <div class="container">
    <div class="section_shell spaces_shell">
      <h3 class="common">内観＆外観<span>Interior & Exterior</span></h3>
      <?php bgv_render_interior_exterior_sections(); ?>
    </div>
  </div>
</section>

<section id="home_gallery">
  <div class="container">
    <div class="section_shell gallery_section_shell">
      <h3 class="common">ギャラリー<span>Gallery</span></h3>
      <div class="single-page pg-gal home-gallery-panel">
        <p><i class="fa fa-search-plus" aria-hidden="true"></i> 画像をクリック・タップで拡大します</p>
        <?php bgv_render_gallery_stack_list(bgv_get_gallery_images($gallery_post_id)); ?>
      </div>
    </div>
  </div>
</section>

<?php get_template_part('template-parts/access-info'); ?>

<script>
  (() => {
    const d = document, s = d.createElement("script");
    s.type = "module";
    s.src = "https://w.behold.so/widget.js";
    d.head.append(s);
  })();
</script>

<?php get_footer(); ?>
