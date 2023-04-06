<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Whatsapp $whatsapp
 */
?>

<?php
$this->assign('title', __('Whatsapp'));
$this->Breadcrumbs->add([
    ['title' => 'Home', 'url' => '/'],
    ['title' => 'List Whatsapps', 'url' => ['action' => 'index']],
    ['title' => 'View'],
]);
?>

<div class="view card card-primary card-outline">
  <div class="card-header d-sm-flex">
    <h2 class="card-title"><?= h($whatsapp->id) ?>

<?php
        if (array_key_exists('base64',$whatsappConnect)){
            $whatsappConnectBASE = $whatsappConnect['base64'];
            echo "<img style='display:block;' id='base64image'
       src='$whatsappConnectBASE' />";
        }
     else{
            var_dump($whatsappConnect);
        };
        ?>
    </h2>
  </div>
  <div class="card-body table-responsive p-0">
    <table class="table table-hover text-nowrap">
        <tr>
            <th><?= __('Nome') ?></th>
            <td><?= h($whatsapp->nome) ?></td>
        </tr>
        <tr>
            <th><?= __('Numero Telefone') ?></th>
            <td><?= h($whatsapp->numero_telefone) ?></td>
        </tr>
        <tr>
            <th><?= __('Usuário') ?></th>
            <td><?= $whatsapp->has('user') ? $this->Html->link($whatsapp->user->username, ['controller' => 'Users', 'action' => 'view', $whatsapp->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('SUA CHAVE API PARA CONEXÃO EXTERNA') ?></th>
            <td><?= h($whatsapp->api_key_server) ?></td>
        </tr>
        <tr>
            <th><?= __('SUA INSTANCIA') ?></th>
            <td><?= h($whatsapp->instancia) ?></td>
        </tr>
        <tr>
            <th><?= __('ID Telefone para se conectar ao ').env('APP_NAME') ?></th>
            <td><?= h($whatsapp->id_telefone) ?></td>
        </tr>
        <tr>
            <th><?= __('ID Da conta de negócios para se conectar ao ').env('APP_NAME') ?></th>
            <td><?= h($whatsapp->id_contanegocios_api) ?></td>
        </tr>
        <tr>
            <th><?= __('Sua chave API no').env('APP_NAME') ?></th>
            <td><?= h($whatsapp->instancia) ?></td>
        </tr>
    </table>
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
      <?= $this->Html->link(__('Criar Inbox Automáticamente no ').env('APP_NAME'), ['action' => 'inbox', $whatsapp->id], ['class' => 'btn btn-secondary']) ?>
      <?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['class' => 'btn btn-default']) ?>
    </div>
  </div>
</div>


