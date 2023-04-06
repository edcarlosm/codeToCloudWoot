<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Whatsapp $whatsapp
 */
?>
<?php
$this->assign('title', __('Add Whatsapp'));
$this->Breadcrumbs->add([
    ['title' => 'Home', 'url' => '/'],
    ['title' => 'List Whatsapps', 'url' => ['action' => 'index']],
    ['title' => 'Add'],
]);
?>

<div class="card card-primary card-outline">
  <?= $this->Form->create($whatsapp) ?>
  <div class="card-body">
    <?php
      echo $this->Form->control('nome');
      echo $this->Form->control('numero_telefone');
      if ($this->request->getAttribute('identity')->is_superuser){
          echo $this->Form->control('user_id', ['options' => $users]);
      }
      echo $this->Form->control('mensagem_template_inicial', ['value' => 'Olá, Tudo Bem!?']);
    ?>
  </div>

  <div class="card-footer d-flex">
    <div class="ml-auto">
      <?= $this->Form->button(__('Save')) ?>
      <?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['class' => 'btn btn-default']) ?>
    </div>
  </div>

  <?= $this->Form->end() ?>
</div>

