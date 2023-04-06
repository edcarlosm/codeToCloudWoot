<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Template $template
 */
?>
<?php
$this->assign('title', __('Add Template'));
$this->Breadcrumbs->add([
    ['title' => 'Home', 'url' => '/'],
    ['title' => 'List Templates', 'url' => ['action' => 'index']],
    ['title' => 'Add'],
]);
?>

<div class="card card-primary card-outline">
  <?= $this->Form->create($template) ?>
  <div class="card-body">
    <?php
      echo $this->Form->control('name');
      echo $this->Form->control('json');
      echo $this->Form->control('api_whatsapp_id_telefone');
      echo $this->Form->control('api_whatsapp_contanegocio_id', ['options' => $whatsapps]);
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

