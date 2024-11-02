<?php loadPartial('head') ?>
<?php loadPartial('navbar') ?>
<?php loadPartial('top-banner') ?>

    <section class="create-form">
      <h1>Create a new post</h1>
      <?php if (isset($errors)) : ?>
        <?php foreach($errors as $error) : ?>
            <div style="color: red">
              <?= $error ?>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      <form method="POST" action="/blog" enctype="multipart/form-data">
        <input type="file" name="image_url" />
        <input type="text" name="title" value="<?= $post['title'] ?? '' ?>" placeholder="Title" />
        <textarea name="content" id=""  placeholder="Content ..."><?= $post['content'] ?? '' ?></textarea>
        <input type="text" name="category" value="<?= $post['category'] ?? '' ?>" placeholder="Category" />
        <button type="submit">Send</button>
      </form>
    </section>

<?php loadPartial('footer') ?>