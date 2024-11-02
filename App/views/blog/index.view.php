<?php loadPartial('head') ?>
<?php loadPartial('navbar') ?>
<?php loadPartial('top-banner') ?>

    <!-- Blog Section -->
    <section id="blog" class="blog">
      <div class="blog-container">

        <?php foreach($posts as $post) : ?>
        <div class="blog-card">
          <img src="<?= $post['image_url'] ?>" alt="" />
          <div class="blog-card-content">
            <h2><?= $post['title'] ?></h2>
            <p>
            <?= substr($post['content'], 0, 200) ?> ...
            </p>
            <a href="/blog/<?= $post['id'] ?>" class="readmore-btn">Read More</a>
          </div>
        </div>
        <?php endforeach ?>
        
      </div>
    </section>

    <?php loadPartial('footer') ?>
