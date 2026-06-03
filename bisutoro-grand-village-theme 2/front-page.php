<?php get_header(); ?>

<section id="top_cover">
  <div class="container">
    <div class="flexslider">
      <ul class="slides">
        <li><img src="<?php echo bgv_asset_uri('assets/images/assets/slide1.jpg'); ?>" alt="TOPスライダー1" /></li>
        <li><img src="<?php echo bgv_asset_uri('assets/images/assets/slide2.jpg'); ?>" alt="TOPスライダー2" /></li>
        <li><img src="<?php echo bgv_asset_uri('assets/images/assets/slide4.jpg'); ?>" alt="TOPスライダー4" /></li>
        <li><img src="<?php echo bgv_asset_uri('assets/images/assets/slide5.jpg'); ?>" alt="TOPスライダー5" /></li>
        <li><img src="<?php echo bgv_asset_uri('assets/images/assets/slide6.jpg'); ?>" alt="TOPスライダー6" /></li>
      </ul>
    </div>
  </div>
</section>

<section id="home_instagram">
  <div class="container">
    <h3 class="common">インスタグラム<span>Instagram Updates</span></h3>
    <behold-widget feed-id="lb2drNmkH9yYiftIAmYC"></behold-widget>
    <a href="https://www.instagram.com/bistrot_grandvillage/" target="_blank" class="more">Instagramを見る</a>
  </div>
</section>

<section id="home_concept">
  <div class="container">
    <div class="concept_txt">
      <h3><img src="<?php echo bgv_asset_uri('assets/images/assets/logo.png'); ?>" alt="コンセプト" /></h3>
      料理の世界に入った時から生まれ育った地元で自分のお店を出す事を夢見ていました。<br /><br />
      堅いイメージのあるフレンチですが当店は幅広い年齢層の方に立ち寄って頂ける様な温かい雰囲気のお店となっております。<br /><br />
      是非御家族、御友人を誘って御来店下さい。<br /><br />
      コース料理や貸し切りパーティーも受け付けています！お気軽にご相談下さい。
    </div>
    <div class="home_banners">
      <img src="<?php echo bgv_asset_uri('assets/images/assets/bn_hamanavi.jpg'); ?>" alt="ハマナビ 番組内で当店を紹介いただきました。" />
      <img src="<?php echo bgv_asset_uri('assets/images/assets/bn_turnedk.jpg'); ?>" alt="光触媒による空気清浄機 導入しました！" />
    </div>
  </div>
</section>

<section id="home_profile">
  <div class="container">
    <h3 class="common">シェフプロフィール<span>Chef Profile</span></h3>
    <div class="row">
      <div class="span3">
        <center>
          <img src="<?php echo bgv_asset_uri('assets/images/assets/chef2.jpg'); ?>" class="prof_photo" alt="大村 航介" />
        </center>
      </div>
      <div class="span9">
        <h4>大村 航介<span>Kosuke Omura</span></h4>
        高校卒業後 エコール辻 東京フランス・イタリア料理専門カレッジに入学し料理の基礎を学ぶ。<br />
        <br />
        卒業後 横浜元町霧笛楼、トラットリア  オ・プレチェネッラ、うかい亭を経て 関内ボンマルシェ でオープニングより店長兼料理長として携わる。
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

