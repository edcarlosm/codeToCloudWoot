<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Whatsapp $whatsapp
 */
?>
<?php
$this->assign('title', __('Edit Whatsapp'));
$this->Breadcrumbs->add([
    ['title' => 'Home', 'url' => '/'],
    ['title' => 'List Whatsapps', 'url' => ['action' => 'index']],
    ['title' => 'View', 'url' => ['action' => 'view', $whatsapp->id]],
    ['title' => 'Edit'],
]);
?>

<div class="card card-primary card-outline">
  <?= $this->Form->create($whatsapp) ?>
  <div class="card-body">
    <?php
      echo $this->Form->control('nome');
      echo $this->Form->control('numero_telefone');
      echo $this->Form->control('id_telefone');
      echo $this->Form->control('id_contanegocios_api');
      echo $this->Form->control('user_id', ['options' => $users]);
      echo $this->Form->control('api_key_server');
      echo $this->Form->control('instancia');
    ?>
  </div>

  <div class="card-footer d-flex">
    <div class="">
      <?= $this->Form->postLink(
          __('Delete'),
          ['action' => 'delete', $whatsapp->id],
          ['confirm' => __('Are you sure you want to delete # {0}?', $whatsapp->id), 'class' => 'btn btn-danger']
      ) ?>
    </div>
    <div class="ml-auto">
      <?= $this->Form->button(__('Save')) ?>
      <?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['class' => 'btn btn-default']) ?>
    </div>
  </div>

  <?= $this->Form->end() ?>
</div>

