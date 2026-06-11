<?php
/*
Template Name: トップページ
*/
get_header();

$asset = 'bgv_asset_uri';
?>

<!-- ===================== HERO ===================== -->
<section id="top_cover">
  <div class="hero-bg" style="background-image:url('<?php echo $asset('assets/images/assets/slide1.jpg'); ?>')"></div>
  <div class="hero-overlay"></div>
  <div class="hero-content">
    <span class="hero-en">Bistrot Grand Village — Yokohama</span>
    <h2 class="hero-title">温かく、上質な<br>フレンチビストロ</h2>
    <p class="hero-sub">横浜・山手で、特別な食卓を。<br>地元の皆様に愛されるカジュアルフレンチ。</p>
    <div class="hero-btns">
      <a href="<?php echo esc_url(home_url('/lunch')); ?>" class="btn btn-primary">メニューを見る</a>
      <a href="<?php echo esc_url(home_url('/access')); ?>" class="btn btn-outline">アクセスを見る</a>
    </div>
  </div>
  <div class="hero-scroll">Scroll</div>
</section>

<!-- ===================== INSTAGRAM ===================== -->
<section id="home_instagram" class="lazy">
  <div class="container">
    <div class="section-header">
      <span class="section-label">Instagram</span>
      <h3 class="section-title">最新の投稿</h3>
    </div>
    <behold-widget feed-id="lb2drNmkH9yYiftIAmYC"></behold-widget>
    <a href="https://www.instagram.com/bistrot_grandvillage/" target="_blank" rel="noopener" class="more">Instagramをフォローする</a>
  </div>
</section>

<!-- ===================== CONCEPT ===================== -->
<section id="home_concept">
  <div class="container">
    <div class="concept-inner">
      <div class="concept-img lazy">
        <img src="<?php echo $asset('assets/images/home_concept_bg.jpg'); ?>" alt="ビストロ グランヴィラージュ — 店内" loading="lazy" />
      </div>
      <div class="concept-txt lazy">
        <span class="section-label">Our Concept</span>
        <h3>地元横浜で育んだ、<br>カジュアルフレンチの食卓</h3>
        <span class="accent-line"></span>
        <p>料理の世界に入った時から生まれ育った地元で自分のお店を出す事を夢見ていました。</p>
        <p>堅いイメージのあるフレンチですが当店は幅広い年齢層の方に立ち寄って頂ける様な温かい雰囲気のお店となっております。是非御家族、御友人を誘って御来店下さい。</p>
        <p>コース料理や貸し切りパーティーも受け付けています！お気軽にご相談下さい。</p>
        <div class="home_banners">
          <img src="<?php echo $asset('assets/images/assets/bn_hamanavi.jpg'); ?>" alt="ハマナビ 番組内で当店を紹介いただきました。" loading="lazy" />
          <img src="<?php echo $asset('assets/images/assets/bn_turnedk.jpg'); ?>" alt="光触媒による空気清浄機 導入しました！" loading="lazy" />
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ===================== CHEF PROFILE ===================== -->
<section id="home_profile">
  <div class="container">
    <span class="section-label">Chef Profile</span>
    <h3 class="section-title" style="color:#fff;">シェフプロフィール</h3>
    <div class="profile-inner lazy">
      <div>
        <img src="<?php echo $asset('assets/images/assets/chef2.jpg'); ?>" class="prof_photo" alt="大村 航介" loading="lazy" />
      </div>
      <div class="profile-txt">
        <h4>大村 航介<span>Kosuke Omura</span></h4>
        <p>高校卒業後 エコール辻 東京フランス・イタリア料理専門カレッジに入学し料理の基礎を学ぶ。</p>
        <p>卒業後 横浜元町霧笛楼、トラットリア オ・プレチェネッラ、うかい亭を経て 関内ボンマルシェ でオープニングより店長兼料理長として携わる。</p>
      </div>
    </div>
  </div>
</section>

<!-- ===================== MENU ===================== -->
<section id="home_menu">
  <div class="container">
    <div class="section-header">
      <span class="section-label">Our Menu</span>
      <h3 class="section-title">メニュー</h3>
    </div>
    <div class="menu-grid">

      <div class="menu-card lazy">
        <div class="menu-card-img">
          <img src="<?php echo $asset('assets/images/assets/slide2.jpg'); ?>" alt="ランチメニュー" loading="lazy" />
        </div>
        <div class="menu-card-body">
          <span class="menu-card-en">Lunch</span>
          <h4 class="menu-card-title">ランチメニュー</h4>
          <p class="menu-card-desc">平日・土曜のランチタイムに楽しめるコースメニュー。前菜・メイン・デザートの充実したセットです。</p>
          <a href="<?php echo esc_url(home_url('/lunch')); ?>" class="menu-card-link">詳細を見る</a>
        </div>
      </div>

      <div class="menu-card lazy">
        <div class="menu-card-img">
          <img src="<?php echo $asset('assets/images/assets/slide4.jpg'); ?>" alt="ディナーメニュー" loading="lazy" />
        </div>
        <div class="menu-card-body">
          <span class="menu-card-en">Dinner</span>
          <h4 class="menu-card-title">ディナーメニュー</h4>
          <p class="menu-card-desc">本格フレンチをカジュアルに楽しめるディナー。アラカルトからコースまでご用意しております。</p>
          <a href="<?php echo esc_url(home_url('/dinner')); ?>" class="menu-card-link">詳細を見る</a>
        </div>
      </div>

      <div class="menu-card lazy">
        <div class="menu-card-img">
          <img src="<?php echo $asset('assets/images/assets/slide5.jpg'); ?>" alt="ドリンクメニュー" loading="lazy" />
        </div>
        <div class="menu-card-body">
          <span class="menu-card-en">Drink</span>
          <h4 class="menu-card-title">ドリンクメニュー</h4>
          <p class="menu-card-desc">フランスを中心とした豊富なワインと、カクテル・ビールなど多彩なドリンクをご用意。</p>
          <a href="<?php echo esc_url(home_url('/drink')); ?>" class="menu-card-link">詳細を見る</a>
        </div>
      </div>

      <div class="menu-card lazy">
        <div class="menu-card-img">
          <img src="<?php echo $asset('assets/images/assets/slide6.jpg'); ?>" alt="ワインリスト" loading="lazy" />
        </div>
        <div class="menu-card-body">
          <span class="menu-card-en">Wine List</span>
          <h4 class="menu-card-title">ワインリスト</h4>
          <p class="menu-card-desc">料理に合わせた厳選ワインを豊富にラインナップ。ソムリエにご相談いただけます。</p>
          <a href="<?php echo esc_url(home_url('/wine')); ?>" class="menu-card-link">詳細を見る</a>
        </div>
      </div>

      <div class="menu-card lazy">
        <div class="menu-card-img">
          <img src="<?php echo $asset('assets/images/assets/slide1.jpg'); ?>" alt="お子様メニュー" loading="lazy" />
        </div>
        <div class="menu-card-body">
          <span class="menu-card-en">Kids Menu</span>
          <h4 class="menu-card-title">お子様メニュー</h4>
          <p class="menu-card-desc">お子様も楽しめる特別メニューをご用意。ご家族でのご来店も大歓迎です。</p>
          <a href="<?php echo esc_url(home_url('/kids')); ?>" class="menu-card-link">詳細を見る</a>
        </div>
      </div>

      <div class="menu-card lazy">
        <div class="menu-card-img">
          <img src="<?php echo $asset('assets/images/home_profile_bg.jpg'); ?>" alt="黒板メニュー" loading="lazy" />
        </div>
        <div class="menu-card-body">
          <span class="menu-card-en">Daily Special</span>
          <h4 class="menu-card-title">黒板メニュー</h4>
          <p class="menu-card-desc">その日仕入れた食材を使った、シェフこだわりの本日のおすすめメニューです。</p>
          <a href="<?php echo esc_url(home_url('/kokuban')); ?>" class="menu-card-link">詳細を見る</a>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- ===================== GALLERY ===================== -->
<section id="home_gallery">
  <div class="container">
    <div class="section-header">
      <span class="section-label">Gallery</span>
      <h3 class="section-title">フォトギャラリー</h3>
    </div>
    <div class="gallery-bento lazy">
      <div class="bento-item"><img src="<?php echo $asset('assets/images/assets/slide1.jpg'); ?>" alt="料理写真1" loading="lazy" /></div>
      <div class="bento-item"><img src="<?php echo $asset('assets/images/assets/slide2.jpg'); ?>" alt="料理写真2" loading="lazy" /></div>
      <div class="bento-item"><img src="<?php echo $asset('assets/images/assets/slide4.jpg'); ?>" alt="料理写真3" loading="lazy" /></div>
      <div class="bento-item"><img src="<?php echo $asset('assets/images/assets/slide5.jpg'); ?>" alt="店内写真1" loading="lazy" /></div>
      <div class="bento-item"><img src="<?php echo $asset('assets/images/assets/slide6.jpg'); ?>" alt="店内写真2" loading="lazy" /></div>
      <div class="bento-item"><img src="<?php echo $asset('assets/images/home_concept_bg.jpg'); ?>" alt="外観写真" loading="lazy" /></div>
    </div>
    <div class="gallery-more">
      <a href="<?php echo esc_url(home_url('/gallery')); ?>" class="btn btn-ghost">ギャラリーをすべて見る</a>
    </div>
  </div>
</section>

<!-- ===================== ACCESS ===================== -->
<?php get_template_part('template-parts/access-info'); ?>

<!-- ===================== CTA ===================== -->
<section id="home_cta">
  <div class="container">
    <h3 class="cta-title">ご予約・お問い合わせ</h3>
    <p class="cta-sub">お気軽にお電話またはInstagramのDMにてご連絡ください。</p>
    <?php
    $access_page = get_page_by_path('access');
    $access_post_id = $access_page ? $access_page->ID : false;
    $phone_number = bgv_get_field('phone_number', '045-305-6619', $access_post_id);
    $tel_href = preg_replace('/[^0-9+]/', '', $phone_number);
    $map_link = bgv_get_field('google_map_link_url', 'https://maps.google.com', $access_post_id);
    ?>
    <div class="cta-links">
      <a href="tel:<?php echo esc_attr($tel_href); ?>" class="cta-btn">
        <i class="fa fa-phone" aria-hidden="true"></i>
        <span>電話で予約</span>
      </a>
      <a href="https://www.instagram.com/bistrot_grandvillage/" target="_blank" rel="noopener" class="cta-btn">
        <i class="fa fa-instagram" aria-hidden="true"></i>
        <span>Instagram DM</span>
      </a>
      <a href="<?php echo esc_url($map_link ?: 'https://maps.app.goo.gl/example'); ?>" target="_blank" rel="noopener" class="cta-btn">
        <i class="fa fa-map-marker" aria-hidden="true"></i>
        <span>Googleマップ</span>
      </a>
      <a href="<?php echo esc_url(home_url('/access')); ?>" class="cta-btn">
        <i class="fa fa-clock-o" aria-hidden="true"></i>
        <span>営業時間・アクセス</span>
      </a>
    </div>
  </div>
</section>

<script>
  (() => {
    const d = document, s = d.createElement("script");
    s.type = "module";
    s.src = "https://w.behold.so/widget.js";
    d.head.append(s);
  })();
  // Hero loaded class for bg zoom
  document.getElementById('top_cover').classList.add('loaded');
</script>

<?php get_footer(); ?>
