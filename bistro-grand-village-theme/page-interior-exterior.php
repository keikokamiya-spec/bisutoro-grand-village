<?php
/*
Template Name: 内観＆外観
*/
get_header();
bgv_render_page_title('Interior & Exterior');
?>
<section id="main">
  <div class="container">
    <div class="row">
      <div class="span12">
        <article>
          <div class="single-page">
            <div class="photos interior-exterior-photos">
              <section class="photos-section">
                <h2 class="photos-section-title">外観<span>Exterior</span></h2>
                <div class="photos-slider">
                  <figure><img decoding="async" src="<?php echo bgv_asset_uri('assets/images/uploads/2022/04/gai1.jpg'); ?>" alt="外観1" /></figure>
                  <figure><img decoding="async" src="<?php echo bgv_asset_uri('assets/images/uploads/2022/04/gai2.jpg'); ?>" alt="外観2" /></figure>
                </div>
              </section>
              <section class="photos-section">
                <h2 class="photos-section-title">内観<span>Interior</span></h2>
                <div class="photos-slider">
                  <figure><img decoding="async" src="<?php echo bgv_asset_uri('assets/images/uploads/2022/04/nai1.jpg'); ?>" alt="内観1" /></figure>
                  <figure><img decoding="async" src="<?php echo bgv_asset_uri('assets/images/uploads/2022/04/nai2.jpg'); ?>" alt="内観2" /></figure>
                  <figure><img decoding="async" src="<?php echo bgv_asset_uri('assets/images/uploads/2022/04/nai3.jpg'); ?>" alt="内観3" /></figure>
                  <figure><img decoding="async" src="<?php echo bgv_asset_uri('assets/images/uploads/2022/04/nai4.jpg'); ?>" alt="内観4" /></figure>
                </div>
              </section>
            </div>
          </div>
        </article>
      </div>
    </div>
  </div>
</section>
<?php get_footer(); ?>

