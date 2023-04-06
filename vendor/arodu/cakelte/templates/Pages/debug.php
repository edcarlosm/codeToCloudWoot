<?php

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.10.0
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 * @var \App\View\AppView $this
 */

use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Datasource\ConnectionManager;
use Cake\Error\Debugger;
use Cake\Http\Exception\NotFoundException;

$checkConnection = function (string $name) {
    $error = null;
    $connected = false;
    try {
        $connection = ConnectionManager::get($name);
        $connected = $connection->connect();
    } catch (Exception $connectionError) {
        $error = $connectionError->getMessage();
        if (method_exists($connectionError, 'getAttributes')) {
            $attributes = $connectionError->getAttributes();
            if (isset($attributes['message'])) {
                $error .= '<br />' . $attributes['message'];
            }
        }
    }

    return compact('connected', 'error');
};

if (!Configure::read('debug')) :
    throw new NotFoundException(
        'Please replace templates/Pages/home.php with your own version or re-enable debug mode.'
    );
endif;

$cakeDescription = 'CakePHP: the rapid development PHP framework';

$this->assign('title', __('Debug'));
$this->Breadcrumbs->add([
    ['title' => 'Home', 'url' => '/'],
    ['title' => 'Debug'],
]);
?>

<header>
    <div class="container text-center">
        <h1>
            Bem vindo ao MDCWoot <?= Configure::version() ?> Versão: Natal 1
        </h1>
    </div>
</header>

<div class="row">
    <div class="col-12">
        <div id="url-rewriting-warning" style="padding: 1rem; background: #fcebea; color: #cc1f1a; border-color: #ef5753; margin-bottom: 1rem;">
            <ul>
                <li class="bullet problem">
                    URL rewriting is not properly configured on your server.<br />
                    1) <a target="_blank" rel="noopener" href="https://book.cakephp.org/4/en/installation.html#url-rewriting">Help me configure it</a><br />
                    2) <a target="_blank" rel="noopener" href="https://book.cakephp.org/4/en/development/configuration.html#general-configuration">I don't / can't use URL rewriting</a>
                </li>
            </ul>
        </div>
        <?php Debugger::checkSecurityKeys(); ?>
    </div>
</div>

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <h4>Environment</h4>
                <ul>
                    <?php if (version_compare(PHP_VERSION, '7.2.0', '>=')) : ?>
                        <li class="bullet success">Your version of PHP is 7.2.0 or higher (detected <?= PHP_VERSION ?>).</li>
                    <?php else : ?>
                        <li class="bullet problem">Your version of PHP is too low. You need PHP 7.2.0 or higher to use CakePHP (detected <?= PHP_VERSION ?>).</li>
                    <?php endif; ?>

                    <?php if (extension_loaded('mbstring')) : ?>
                        <li class="bullet success">Your version of PHP has the mbstring extension loaded.</li>
                    <?php else : ?>
                        <li class="bullet problem">Your version of PHP does NOT have the mbstring extension loaded.</li>
                    <?php endif; ?>

                    <?php if (extension_loaded('openssl')) : ?>
                        <li class="bullet success">Your version of PHP has the openssl extension loaded.</li>
                    <?php elseif (extension_loaded('mcrypt')) : ?>
                        <li class="bullet success">Your version of PHP has the mcrypt extension loaded.</li>
                    <?php else : ?>
                        <li class="bullet problem">Your version of PHP does NOT have the openssl or mcrypt extension loaded.</li>
                    <?php endif; ?>

                    <?php if (extension_loaded('intl')) : ?>
                        <li class="bullet success">Your version of PHP has the intl extension loaded.</li>
                    <?php else : ?>
                        <li class="bullet problem">Your version of PHP does NOT have the intl extension loaded.</li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <div class="card-body">
                <h4>Filesystem</h4>
                <ul>
                    <?php if (is_writable(TMP)) : ?>
                        <li class="bullet success">Your tmp directory is writable.</li>
                    <?php else : ?>
                        <li class="bullet problem">Your tmp directory is NOT writable.</li>
                    <?php endif; ?>

                    <?php if (is_writable(LOGS)) : ?>
                        <li class="bullet success">Your logs directory is writable.</li>
                    <?php else : ?>
                        <li class="bullet problem">Your logs directory is NOT writable.</li>
                    <?php endif; ?>

                    <?php $settings = Cache::getConfig('_cake_core_'); ?>
                    <?php if (!empty($settings)) : ?>
                        <li class="bullet success">The <em><?= $settings['className'] ?>Engine</em> is being used for core caching. To change the config edit config/app.php</li>
                    <?php else : ?>
                        <li class="bullet problem">Your cache is NOT working. Please check the settings in config/app.php</li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <h4>Database</h4>
                <?php
                $result = $checkConnection('default');
                ?>
                <ul>
                    <?php if ($result['connected']) : ?>
                        <li class="bullet success">Conectado a is able to connect to the database.</li>
                    <?php else : ?>
                        <li class="bullet problem">Conectado is NOT able to connect to the database.<br /><?= $result['error'] ?></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <div class="card-body">
                <h4>DebugKit</h4>
                <ul>
                    <?php if (Plugin::isLoaded('DebugKit')) : ?>
                        <li class="bullet success">DebugKit is loaded.</li>
                        <?php
                        $result = $checkConnection('debug_kit');
                        ?>
                        <?php if ($result['connected']) : ?>
                            <li class="bullet success">DebugKit can connect to the database.</li>
                        <?php else : ?>
                            <li class="bullet problem">DebugKit is <strong>not</strong> able to connect to the database.<br /><?= $result['error'] ?></li>
                        <?php endif; ?>
                    <?php else : ?>
                        <li class="bullet problem">DebugKit is <strong>not</strong> loaded.</li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<style media="screen">
    ul {
        list-style-type: none;
    }

    .bullet::before {
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
        font-size: 18px;
        display: inline-block;
        margin-left: -1.3em;
        width: 1.2em;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        vertical-align: -1px;
    }

    .success::before {
        color: #88c671;
        content: "\f058";
    }

    .problem::before {
        color: #d33d44;
        content: "\f057";
    }
</style>
