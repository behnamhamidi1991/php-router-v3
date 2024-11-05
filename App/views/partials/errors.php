<?php if (isset($errors)) : ?>
        <?php foreach($errors as $error) : ?>
            <div style="color: red">
              <?= $error ?>
            </div>
          <?php endforeach; ?>
<?php endif; ?>