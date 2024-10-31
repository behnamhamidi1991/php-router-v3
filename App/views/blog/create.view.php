<?php loadPartial('head') ?>
<?php loadPartial('navbar') ?>
<?php loadPartial('top-banner') ?>

    <section class="create-form">
      <h1>Create a new post</h1>
      <form method="POST" action="">
        <input type="file" />
        <input type="text" placeholder="Title" />
        <textarea name="" id="" placeholder="Content ..."></textarea>
        <input type="text" placeholder="Category" />
        <button type="submit">Send</button>
      </form>
    </section>

<?php loadPartial('footer') ?>