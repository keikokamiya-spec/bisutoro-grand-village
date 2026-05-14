<?php
/*
Template Name: お子様セット
*/
get_header();
get_template_part('template-parts/page-title', null, array('title' => 'お子様セットメニュー'));
?>
<section id="main">
  <div class="container">
    <div class="row">
      <div class="span12">
        <article>
          <div class="single-page">
            <p align="right">※全て税込み価格になります。</p>
            <dl class="menu">
              <dt class="cate marg-top0">お子様セットメニュー<span>kids set</span></dt>
              <dt class="marg-bottom15">（全てバゲット、ソフトドリンク、バニラアイス付き）</dt>
              <dt>ベーコンとキノコのトマトスパゲッティ</dt>
              <dd><?php echo gv_price('kids_pasta'); ?></dd>
              <dt>みんな大好き カルボナーラ</dt>
              <dd><?php echo gv_price('kids_carbonara'); ?></dd>
              <dt>いろいろキノコのクリームリゾット</dt>
              <dd><?php echo gv_price('kids_risotto'); ?></dd>
              <dt>煮込みハンバーグのデミグラスソース</dt>
              <dd><?php echo gv_price('kids_hamburg'); ?></dd>
            </dl>
          </div>
        </article>
      </div>
    </div>
  </div>
</section>
<?php get_footer(); ?>

