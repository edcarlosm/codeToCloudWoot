<div class="user-panel mt-3 pb-3 mb-3 d-flex">
  <div class="image">
    <?php
    $email = trim( $this->request->getAttribute('identity')->email ); // "MyEmailAddress@example.com"
    $email = strtolower( $email ); // "myemailaddress@example.com"
    $email = md5($email);
    ?>
    <?= $this->Html->image('https://www.gravatar.com/avatar/'.$email, ['class'=>'img-circle elevation-2', 'alt'=>'User Image']) ?>
  </div>
  <div class="info">
    <a href="#" class="d-block"> <?=$this->request->getAttribute('identity')->first_name ?></a>
  </div>
</div>
