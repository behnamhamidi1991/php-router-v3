<?php loadPartial('head') ?>
<?php loadPartial('navbar') ?>
<?php loadPartial('top-banner') ?>


<section class="register-page">
      <h1 style="margin-bottom: 20px">Create an account</h1>
      <?= loadPartial('errors', [
      'errors' => $errors ?? []
      ]) ?>
      <form method="POST" action="/auth/register" class="register-form">
        <input type="text" name="name" placeholder="Name" />
        <input type="email" name="email" placeholder="Email" />
        <input type="password" name="password" placeholder="Password" />
        <input type="password" name="password_confirmation" placeholder="Confirm Password" />
        <button>Register</button>
      </form>
    </section>

<?php loadPartial('footer') ?>
