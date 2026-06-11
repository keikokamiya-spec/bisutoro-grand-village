<?php get_header(); ?>

<section id="top_cover">
  <div class="container">
    <div class="flexslider">
      <ul class="slides">
        <li><img src="<?php echo bgv_asset('images/assets/slide1.jpg'); ?>" alt="TOPスライダー1" /></li>
        <li><img src="<?php echo bgv_asset('images/assets/slide2.jpg'); ?>" alt="TOPスライダー2" /></li>
        <li><img src="<?php echo bgv_asset('images/assets/slide4.jpg'); ?>" alt="TOPスライダー4" /></li>
        <li><img src="<?php echo bgv_asset('images/assets/slide5.jpg'); ?>" alt="TOPスライダー5" /></li>
        <li><img src="<?php echo bgv_asset('images/assets/slide6.jpg'); ?>" alt="TOPスライダー6" /></li>
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
      <h3><img src="<?php echo bgv_asset('images/assets/logo.png'); ?>" alt="コンセプト" /></h3>
      料理の世界に入った時から生まれ育った地元で自分のお店を出す事を夢見ていました。<br /><br />
      堅いイメージのあるフレンチですが当店は幅広い年齢層の方に立ち寄って頂ける様な温かい雰囲気のお店となっております。<br /><br />
      是非御家族、御友人を誘って御来店下さい。<br /><br />
      コース料理や貸し切りパーティーも受け付けています！お気軽にご相談下さい。
    </div>
    <div class="home_banners">
      <img src="<?php echo bgv_asset('images/assets/bn_hamanavi.jpg'); ?>" alt="ハマナビ 番組内で当店を紹介いただきました。" />
      <img src="<?php echo bgv_asset('images/assets/bn_turnedk.jpg'); ?>" alt="光触媒による空気清浄機 導入しました！" />
    </div>
  </div>
</section>

<section id="home_profile">
  <div class="container">
    <h3 class="common">シェフプロフィール<span>Chef Profile</span></h3>
    <div class="row">
      <div class="span3">
        <center>
          <img src="<?php echo bgv_asset('images/assets/chef2.jpg'); ?>" class="prof_photo" alt="大村 航介" />
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

<section id="home_access">
  <div class="container">
    <h3 class="common">アクセス<span>Access</span></h3>
    <div class="row">
      <div class="span5">
        <div class="google-maps">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3251.075783275786!2d139.6435886757764!3d35.42815267267006!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x60185da7193477df%3A0x107058e1a8b1e5af!2z44OT44K544OI44OtIOOCsOODqeODs-ODtOOCo-ODqeODvOOCuOODpQ!5e0!3m2!1sja!2sjp!4v1777282308434!5m2!1sja!2sjp" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
      </div>
      <div class="span7">
        〒231-0846<br />神奈川県横浜市中区大和町2-50-7<br />ヴィラ山手1F（JR京浜東北根岸線山手駅より１分）<br />
        <br />
        <i class="fa fa-phone-square" aria-hidden="true"></i> 045-305-6619<br />
        <table class="time">
          <tr>
            <th width="37%"></th>
            <th width="9%">月</th>
            <th width="9%">火</th>
            <th width="9%">水</th>
            <th width="9%">木</th>
            <th width="9%">金</th>
            <th width="9%">土</th>
            <th width="9%">日</th>
          </tr>
          <tr>
            <th>11:30-14:30 <br class="sp_only" />(ラストオーダー14:00)</th>
            <td>×</td>
            <td>×</td>
            <td>○</td>
            <td>○</td>
            <td>○</td>
            <td>○</td>
            <td>×</td>
          </tr>
          <tr>
            <th>17:30-22:00 <br class="sp_only" />(ラストオーダー21:00)</th>
            <td>×</td>
            <td>○</td>
            <td>○</td>
            <td>○</td>
            <td>○</td>
            <td>○</td>
            <td>×</td>
          </tr>
        </table>
        <p class="marg-top10" align="right">定休日：日曜日、月曜日<br />火曜日のランチ<br />（祝日の場合は変更あり）</p>
      </div>
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
</script>

<?php get_footer(); ?>
