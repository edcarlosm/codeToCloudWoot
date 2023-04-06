<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Template $template
 */
?>

<?php
$this->assign('title', __('Template'));
$this->Breadcrumbs->add([
    ['title' => 'Home', 'url' => '/'],
    ['title' => 'List Templates', 'url' => ['action' => 'index']],
    ['title' => 'View'],
]);
?>

<div class="view card card-primary card-outline">
  <div class="card-header d-sm-flex">
    <h2 class="card-title"><?= h($template->name) ?></h2>
  </div>
  <div class="card-body table-responsive p-0">
    <table class="table table-hover text-nowrap">
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= h($template->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Whatsapp') ?></th>
            <td><?= $template->has('whatsapp') ? $this->Html->link($template->whatsapp->id, ['controller' => 'Whatsapps', 'action' => 'view', $template->whatsapp->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($template->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Api Whatsapp Id Telefone') ?></th>
            <td><?= $this->Number->format($template->api_whatsapp_id_telefone) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($template->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($template->modified) ?></td>
        </tr>
    </table>
  </div>
  <div class="card-footer d-flex">
    <div class="">
      <?= $this->Form->postLink(
          __('Delete'),
          ['action' => 'delete', $template->id],
          ['confirm' => __('Are you sure you want to delete # {0}?', $template->id), 'class' => 'btn btn-danger']
      ) ?>
    </div>
    <div class="ml-auto">
      <?= $this->Html->link(__('Edit'), ['action' => 'edit', $template->id], ['class' => 'btn btn-secondary']) ?>
      <?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['class' => 'btn btn-default']) ?>
    </div>
  </div>
</div>

<div class="view text card">
  <div class="card-header">
    <h3 class="card-title"><?= __('Json') ?></h3>
  </div>
  <div class="card-body">
    <?= $this->Text->autoParagraph(h($template->json)); ?>
  </div>
</div>

