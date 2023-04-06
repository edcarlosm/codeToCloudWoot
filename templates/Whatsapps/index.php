<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Whatsapp[]|\Cake\Collection\CollectionInterface $whatsapps
 */
?>
<?php
$this->assign('title', __('Whatsapps'));
$this->Breadcrumbs->add([
    ['title' => 'Home', 'url' => '/'],
    ['title' => 'List Whatsapps'],
]);
?>

<div class="card card-primary card-outline">
    <div class="card-header d-sm-flex">
        <h2 class="card-title">
            <!-- -->
        </h2>
        <div class="card-toolbox">
            <?= $this->Paginator->limitControl([], null, [
                'label' => false,
                'class' => 'form-control-sm',
            ]); ?>
            <?= $this->Html->link(__('New Whatsapp'), ['action' => 'add'], ['class' => 'btn btn-primary btn-sm']) ?>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th><?= 'nome' ?></th>
                    <th><?= 'numero_telefone'?></th>
                    <th><?= 'ID do Telefone' ?></th>
                    <th><?= 'ID da Conta de Negócios' ?></th>
                    <th><?= "API Da ".env("APP_NAME") ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('api_key_server') ?></th>
                    <th><?= $this->Paginator->sort('Instance') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($whatsapps as $whatsapp) : ?>
                    <tr>
                        <td><?= h($whatsapp->nome) ?></td>
                        <td><?= h($whatsapp->numero_telefone) ?></td>
                        <td><?= h($whatsapp->id_telefone) ?></td>
                        <td><?= h($whatsapp->id_contanegocios_api) ?></td>
                        <td><?= base64_encode($whatsapp->numero_telefone) ?></td>
                        <td><?= $whatsapp->has('user') ? $this->Html->link($whatsapp->user->username, ['controller' => 'Users', 'action' => 'view', $whatsapp->user->id]) : '' ?></td>
                        <td><?= h($whatsapp->api_key_server) ?></td>
                        <td><?= h($whatsapp->instancia) ?></td>
                        <td class="actions">
                            <?= $this->Html->link(__('QRCode + Dados'), ['action' => 'view', $whatsapp->id], ['class' => 'btn btn-xs btn-outline-primary', 'escape' => false]) ?>
                            <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $whatsapp->id], ['class' => 'btn btn-xs btn-outline-danger', 'escape' => false, 'confirm' => __('Are you sure you want to delete # {0}?', $whatsapp->id)]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->

    <div class="card-footer d-md-flex paginator">
        <div class="mr-auto" style="font-size:.8rem">
            <?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?>
        </div>
        <ul class="pagination pagination-sm">
            <?= $this->Paginator->first('<i class="fas fa-angle-double-left"></i>', ['escape' => false]) ?>
            <?= $this->Paginator->prev('<i class="fas fa-angle-left"></i>', ['escape' => false]) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next('<i class="fas fa-angle-right"></i>', ['escape' => false]) ?>
            <?= $this->Paginator->last('<i class="fas fa-angle-double-right"></i>', ['escape' => false]) ?>
        </ul>
    </div>
    <!-- /.card-footer -->
</div>
