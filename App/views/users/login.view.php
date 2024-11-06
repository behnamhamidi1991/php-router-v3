<?php loadPartial('head') ?>
<?php loadPartial('navbar') ?>
<?php loadPartial('top-banner') ?>


<section class="register-page">
      <h1 style="margin-bottom: 20px">Sign In</h1>

      <?= loadPartial('errors', [
      'errors' => $errors ?? []
      ]) ?>
      
      <form method="POST" action="/auth/login" class="register-form">
        <input type="email" name="email" placeholder="Email" />
        <input type="password" name="password" placeholder="Password" />
        <button type="submit">Login</button>
      </form>
</section>

<?php loadPartial('footer') ?>
