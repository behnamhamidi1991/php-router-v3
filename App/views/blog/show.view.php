<?php loadPartial('head') ?>
<?php loadPartial('navbar') ?>
<?php loadPartial('top-banner') ?>
    
    <!-- Blog Section -->
    <section id="blog" class="blog">
      <div class="blog-container">
        <!-- POST 1 -->
        <div class="blog-card">
          <img src="<?= $post['image_url'] ?>" alt="" />
          <div class="blog-card-content">
            <h2><?= $post['title'] ?></h2>
            <p>
              <?= $post['content'] ?>
            </p>
            <a href="/blog" class="readmore-btn">Back to Blog</a>
          </div>
        </div>

    </section>


    <?php loadPartial('footer') ?>