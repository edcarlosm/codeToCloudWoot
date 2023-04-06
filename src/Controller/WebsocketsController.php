<?php
declare(strict_types=1);

namespace App\Controller;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Wamp\WampServerInterface;
use Ratchet\RFC6455\Messaging\Frame;
use Ratchet\WebSocket\WsServer;
use Ratchet\Http\HttpServer;
use WebSocket\Client;

/**
 * Websockets Controller
 *
 * @method \App\Model\Entity\Websocket[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class WebsocketsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
$aff = '{"command":"subscribe","identifier":"{\"channel\":\"RoomChannel\",\"pubsub_token\":\"RnrxnNomRaS6sSkAZV1ncPEY\",\"account_id\": 1}"}';


        $client = new Client("wss://app.mdbr.site/cable");
        $client->send($aff);

       echo $client->receive();
        $client->close();
        /* $websockets = $this->paginate($this->Websockets);
         $this->set(compact('websockets'));*/
    }

    /**
     * View method
     *
     * @param string|null $id Websocket id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $websocket = $this->Websockets->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('websocket'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $websocket = $this->Websockets->newEmptyEntity();
        if ($this->request->is('post')) {
            $websocket = $this->Websockets->patchEntity($websocket, $this->request->getData());
            if ($this->Websockets->save($websocket)) {
                $this->Flash->success(__('The websocket has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The websocket could not be saved. Please, try again.'));
        }
        $this->set(compact('websocket'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Websocket id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $websocket = $this->Websockets->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $websocket = $this->Websockets->patchEntity($websocket, $this->request->getData());
            if ($this->Websockets->save($websocket)) {
                $this->Flash->success(__('The websocket has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The websocket could not be saved. Please, try again.'));
        }
        $this->set(compact('websocket'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Websocket id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $websocket = $this->Websockets->get($id);
        if ($this->Websockets->delete($websocket)) {
            $this->Flash->success(__('The websocket has been deleted.'));
        } else {
            $this->Flash->error(__('The websocket could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
