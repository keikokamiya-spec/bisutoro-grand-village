<?php
/*
Template Name: トップページ
*/
get_header();
$gallery_page = get_page_by_path('gallery');
$gallery_post_id = $gallery_page ? $gallery_page->ID : 0;
$gallery_images = bgv_get_gallery_images($gallery_post_id);
$interior_exterior_page = get_page_by_path('interior-exterior');
$interior_exterior_post_id = $interior_exterior_page ? $interior_exterior_page->ID : 0;
$ambience_images = bgv_get_home_ambience_images($interior_exterior_post_id);
?>

<section id="top_cover">
  <div class="hero-shell">
    <div class="flexslider">
      <ul class="slides">
        <li><img src="<?php echo esc_url(bgv_preferred_asset_uri('assets/images/assets/slide1.jpg')); ?>" alt="ビストロ グランヴィラージュ" /></li>
        <li><img src="<?php echo esc_url(bgv_preferred_asset_uri('assets/images/assets/slide2.jpg')); ?>" alt="料理写真" /></li>
        <li><img src="<?php echo esc_url(bgv_preferred_asset_uri('assets/images/assets/slide4.jpg')); ?>" alt="料理写真" /></li>
        <li><img src="<?php echo esc_url(bgv_preferred_asset_uri('assets/images/assets/slide5.jpg')); ?>" alt="料理写真" /></li>
        <li><img src="<?php echo esc_url(bgv_preferred_asset_uri('assets/images/assets/slide6.jpg')); ?>" alt="料理写真" /></li>
      </ul>
    </div>
    <div class="hero-copy lazy">
      <p class="hero-copy__eyebrow">Yamate Casual French</p>
      <p class="hero-copy__text">横浜山手で、気軽に立ち寄れる温かなフレンチを。<br />料理も空間も、肩肘張らずに楽しめる一軒です。</p>
    </div>
  </div>
</section>

<section id="home_instagram" class="lazy">
  <div class="container">
    <h3 class="common">Instagram<span>@bistrot_grandvillage</span></h3>
    <div class="instagram-feed-shell">
      <behold-widget feed-id="lb2drNmkH9yYiftIAmYC"></behold-widget>
      <div class="instagram-mobile-carousel" aria-label="Instagram モバイルカルーセル">
        <div class="instagram-mobile-carousel__track"></div>
      </div>
      <button type="button" class="instagram-mobile-carousel__arrow instagram-mobile-carousel__arrow--prev" aria-label="前の投稿を見る">
        <span aria-hidden="true">&#8249;</span>
      </button>
      <button type="button" class="instagram-mobile-carousel__arrow instagram-mobile-carousel__arrow--next" aria-label="次の投稿を見る">
        <span aria-hidden="true">&#8250;</span>
      </button>
      <div class="instagram-mobile-carousel__count" aria-live="polite">
        <span>1 / 1</span>
      </div>
    </div>
    <a href="https://www.instagram.com/bistrot_grandvillage/" target="_blank" rel="noopener" class="more">Instagramをフォローする</a>
  </div>
</section>

<section id="home_concept">
  <div class="container">
    <h3 class="common section-heading" data-num="01">コンセプト<span>Concept</span></h3>
    <div class="concept_txt lazy">
      <p>料理の世界に入った時から生まれ育った地元で自分のお店を出す事を夢見ていました。</p>
      <p>堅いイメージのあるフレンチですが当店は幅広い年齢層の方に立ち寄って頂ける様な温かい雰囲気のお店となっております。是非御家族、御友人を誘って御来店下さい。</p>
      <p>コース料理や貸し切りパーティーも受け付けています！お気軽にご相談下さい。</p>
    </div>
    <div class="home_banners lazy">
      <img src="<?php echo bgv_asset_uri('assets/images/assets/bn_hamanavi.jpg'); ?>" alt="ハマナビ 番組内で当店を紹介いただきました。" loading="lazy" />
      <img src="<?php echo bgv_asset_uri('assets/images/assets/bn_turnedk.jpg'); ?>" alt="光触媒による空気清浄機 導入しました！" loading="lazy" />
    </div>
  </div>
</section>

<section id="home_profile">
  <div class="container">
    <h3 class="common section-heading" data-num="02">シェフプロフィール<span>Chef Profile</span></h3>
    <div class="row lazy">
      <div class="span3">
        <img src="<?php echo esc_url(bgv_preferred_asset_uri('assets/images/assets/chef2.jpg')); ?>" class="prof_photo" alt="大村 航介" loading="lazy" />
      </div>
      <div class="span9">
        <h4>大村 航介<span>Kosuke Omura</span></h4>
        <p>高校卒業後 エコール辻 東京フランス・イタリア料理専門カレッジに入学し料理の基礎を学ぶ。</p>
        <p>卒業後 横浜元町霧笛楼、トラットリア オ・プレチェネッラ、うかい亭を経て 関内ボンマルシェ でオープニングより店長兼料理長として携わる。</p>
      </div>
    </div>
  </div>
</section>

<section id="home_interior_exterior">
  <div class="container">
    <h3 class="common section-heading">お店の雰囲気<span>Ambience</span></h3>
    <div class="home-ambience-panel lazy">
      <div class="home-ambience-carousel" aria-label="お店の雰囲気カルーセル">
        <div class="home-ambience-carousel__track">
          <?php foreach ($ambience_images as $index => $image) : ?>
            <div class="home-ambience-carousel__item">
              <img src="<?php echo esc_url($image['src']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" loading="<?php echo $index === 0 ? 'eager' : 'lazy'; ?>" />
            </div>
          <?php endforeach; ?>
        </div>
      </div>
      <?php if (! empty($ambience_images)) : ?>
        <div class="home-ambience-carousel__controls">
          <button type="button" class="home-ambience-carousel__arrow home-ambience-carousel__arrow--prev" aria-label="前の画像を見る">
            <span aria-hidden="true">‹</span>
          </button>
          <div class="home-ambience-carousel__count" aria-live="polite">
            <span>1 / <?php echo esc_html((string) count($ambience_images)); ?></span>
          </div>
          <button type="button" class="home-ambience-carousel__arrow home-ambience-carousel__arrow--next" aria-label="次の画像を見る">
            <span aria-hidden="true">›</span>
          </button>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>

<section id="home_gallery">
  <div class="container">
    <h3 class="common section-heading" data-num="04">ギャラリー<span>Gallery</span></h3>
    <div class="single-page pg-gal home-gallery-panel lazy">
      <?php if (! empty($gallery_images)) : ?>
        <p><i class="fa fa-search-plus" aria-hidden="true"></i> 画像をクリック・タップで拡大します</p>
        <div class="gallery-carousel flexslider" aria-label="ギャラリーカルーセル">
          <ul class="slides">
            <?php foreach ($gallery_images as $image) : ?>
              <li><a href="<?php echo esc_url($image['full_url']); ?>" class="gallery" aria-label="<?php echo esc_attr($image['alt']); ?>を拡大表示"><?php echo $image['thumb_html']; ?></a></li>
            <?php endforeach; ?>
          </ul>
        </div>
        <div class="gallery-slider-status home-gallery-status" aria-live="polite">
          <span>1 / <?php echo esc_html((string) count($gallery_images)); ?></span>
        </div>
      <?php else : ?>
        <p>ギャラリー画像は管理画面のACFから登録できます。</p>
      <?php endif; ?>
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
