<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;
use Cake\ORM\Locator\LocatorAwareTrait;

/**
 * Whatsapps Controller
 *
 * @property \App\Model\Table\WhatsappsTable $Whatsapps
 * @method \App\Model\Entity\Whatsapp[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class WhatsappsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('codechatServer');
        $this->loadComponent('geradorDeNumeros');


    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users'],
        ];
        if ($this->request->getAttribute('identity')->is_superuser){
            $whatsapps = $this->paginate($this->Whatsapps);
        }else{
            $whatsapps = $this->paginate(
                $this->Whatsapps->find('all',
                )->where(['user_id' => $this->request->getAttribute('identity')->id])
            );
        }

        $this->set(compact('whatsapps'));
    }

    /**
     * View method
     *
     * @param string|null $id Whatsapp id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $whatsapp = $this->Whatsapps->get($id, [
            'contain' => ['Users'],
        ]);

        if ($this->request->getAttribute('identity')->id !== $whatsapp->user_id && !$this->request->getAttribute('identity')->is_superuser){
            $this->Flash->error(__('ACESSO NEGADO E REGISTRADO NOS LOGS.'));
            return $this->redirect(['action' => 'index']);
        }

        $instance = $whatsapp->instancia;

        $check = $this->codechatServer->checkInstance($instance);
        if (array_key_exists('error',$check)){
            if ($check['error'] == 'Not Found'){
                $newServer = $this->codechatServer->newZAP($instance);
                $zapTable = $this->getTableLocator()->get('Whatsapps');
                $zap = $zapTable->get($id);
                $zap->api_key_server = $newServer['hash']['apikey'];
                $zapTable->save($zap);
                sleep(1);
            }
        }

        $whatsappConnect = $this->codechatServer->connection($instance);


        $this->set(compact('whatsapp', 'whatsappConnect'));
        header("refresh:15"); // atualiza a cada 15 segundos
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $templateTable = $this->getTableLocator()->get('Templates');
        $template = $templateTable->newEmptyEntity();
        $whatsapp = $this->Whatsapps->newEmptyEntity();
        if ($this->request->is('post')) {
            $whatsapp = $this->Whatsapps->patchEntity($whatsapp, $this->request->getData());

            $registro = $this->request->getData();


            $numero1 = $this->geradorDeNumeros->gerarUniquidNumber();
            $numero2 = $this->geradorDeNumeros->gerarIDTel();



            //salvar
            $mesagemTemplate = $registro['mensagem_template_inicial'];

            $template->api_whatsapp_id_telefone = $numero1;
            $template->api_whatsapp_contanegocio_id = $numero2;
            $templateJson = array(
                "data" => array(
                    array(
                        "name" => "hello",
                        "status" => "APPROVED",
                        "category" => "UTILITY",
                        "language" => "pt_BR",
                        "components" => array(
                            array(
                                "text" => $mesagemTemplate,
                                "type" => "BODY"
                            )
                        )
                    )
                )
            );
            $template->json = json_encode($templateJson);
            $template->name = 'hello';

            if (preg_match('/^\+\d+$/', $registro['numero_telefone'])) {
                $instancia = base64_encode($registro['numero_telefone']);
                $newServer = $this->codechatServer->newZAP($instancia);
                if ($newServer !== 'Error'){
                    $newServerAPI = $newServer['hash']['apikey'];
                    $instanceNameServer = $newServer['instance']['instanceName'];
                }else{
                    $this->Flash->error(__('O Servidor Não Parece Bem... Tente novamente mais tarde!.'));
                    return $this->redirect(['action' => 'index']);
                }
            } else {
                $this->Flash->error(__('O Numero digitado não está no padrão internacional Exemplo: +558499999999.'));
                return $this->redirect(['action' => 'add']);
            }


            $whatsapp->instancia = $instanceNameServer;
            $whatsapp->api_key_server = $newServerAPI;
            $whatsapp->user_id = $this->request->getAttribute('identity')->id;


            $whatsapp->id_telefone = $numero1;
            $whatsapp->id_contanegocios_api = $numero2;

            if ($this->Whatsapps->save($whatsapp) && $templateTable->save($template)) {

                    $this->Flash->success(__('Saved.'));
                    return $this->redirect(['action' => 'index']);

            }
            $this->Flash->error(__('ERROR GERAL.'));
        }
        $users = TableRegistry::getTableLocator()->get('CakeDC/Users.Users')->find('list');
        $this->set(compact('whatsapp', 'users', 'template'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Whatsapp id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function inbox($id = null){

        $this->Flash->error(__('Contate o administrador do sistema para atualizar o sistema e receber esta função'));
        return $this->redirect(['action' => 'index']);

    }
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $whatsapp = $this->Whatsapps->get($id);
        $whatsappInst = $whatsapp->instancia;

        if ($this->request->getAttribute('identity')->id !== $whatsapp->user_id && !$this->request->getAttribute('identity')->is_superuser){
            $this->Flash->error(__('ACESSO NEGADO E REGISTRADO NOS LOGS.'));
            return $this->redirect(['action' => 'index']);
        }

        if ($this->Whatsapps->delete($whatsapp)) {
            $this->codechatServer->logout($whatsappInst);
            $this->codechatServer->delete($whatsappInst);

            $this->Flash->success(__('The whatsapp has been deleted.'));
        } else {
            $this->Flash->error(__('The whatsapp could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
