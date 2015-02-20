<?php

namespace Contato\Controller;

// Import Zed\MVC
use Zend\Mvc\Controller\AbstractActionController;

// Import Zed\View
use Zend\View\Model\ViewModel;
// imort ModelContatoTable com alias
use Contato\Model\ContatoTable as ModelContato;

class ContatoController extends AbstractActionController
{

    public function indexAction()
    {
        // localizar adapter do banco
        $adapter = $this->getServiceLocator()->get('AdapterDb');

        // model ContatoTable instanciado
        $modelContato = new ModelContato($adapter); // alias para ContatoTable

        // enviar para view o array com key contatos e value com todos os contatos
        return new ViewModel(array('contatos' => $modelContato->fetchAll()));
    }

    public function novoAction()
    {
        return new ViewModel();
    }

    public function adicionarAction()
    {
        // obt�m a requisi��o
        $request = $this->getRequest();

        // verifica se a requisi��o � do tipo post
        if ($request->isPost()) {
            // obter e armazenar valores do post
            $postData = $request->getPost()->toArray();
            $formularioValido = true;

            // verifica se o formul�rio segue a valida��o proposta
            if ($formularioValido) {
                // aqui vai a l�gica para adicionar os dados � tabela no banco
                // 1 - solicitar servi�o para pegar o model respons�vel pela adi��o
                // 2 - inserir dados no banco pelo model
                // adicionar mensagem de sucesso
                $this->flashMessenger()->addSuccessMessage("Contato criado com sucesso");

                // redirecionar para action index no controller contatos
                return $this->redirect()->toRoute('contatos');
            } else {
                // adicionar mensagem de erro
                $this->flashMessenger()->addErrorMessage("Erro ao criar contato");

                // redirecionar para action novo no controllers contatos
                return $this->redirect()->toRoute('contatos', array('action' => 'novo'));
            }
        }
    }

    public function detalhesAction()
    {
        // filtra id passsado pela url
        $id = (int) $this->params()->fromRoute('id', 0);

        // se id = 0 ou n�o informado redirecione para contatos
        if (!$id) {
            // adicionar mensagem
            $this->flashMessenger()->addMessage("Contato n�o encotrado");

            // redirecionar para action index
            return $this->redirect()->toRoute('contatos');
        }

        // localizar adapter do banco
        $adapter = $this->getServiceLocator()->get('AdapterDb');

        // model ContatoTable instanciado
        $modelContato = new ModelContato($adapter); // alias para ContatoTable
        try {
            $form = (array) $modelContato->find($id);
        } catch (Exception $exc) {
            // adicionar mensagem
            $this->flashMessenger()->addErrorMessage($exc->getMessage());

            // redirecionar para action index
            return $this->redirect()->toRoute('contatos');
        }

        // dados eviados para detalhes.phtml
        return array('id' => $id, 'form' => $form);
    }


    // GET /contatos/editar/id
    public function editarAction()
    {
        // filtra id passsado pela url
        $id = (int) $this->params()->fromRoute('id', 0);

        // se id = 0 ou n�o informado redirecione para contatos
        if (!$id) {
            // adicionar mensagem de erro
            $this->flashMessenger()->addMessage("Contato n�o encotrado");

            // redirecionar para action index
            return $this->redirect()->toRoute('contatos');
        }

        // localizar adapter do banco
        $adapter = $this->getServiceLocator()->get('AdapterDb');

        // model ContatoTable instanciado
        $modelContato = new ModelContato($adapter); // alias para ContatoTable
        try {
            $form = (array) $modelContato->find($id);
        } catch (Exception $exc) {
            // adicionar mensagem
            $this->flashMessenger()->addErrorMessage($exc->getMessage());

            // redirecionar para action index
            return $this->redirect()->toRoute('contatos');
        }

        // dados eviados para editar.phtml
        return array('id' => $id, 'form' => $form);
    }

     // PUT /contatos/editar/id
    public function atualizarAction()
    {
        // obt�m a requisi��o
        $request = $this->getRequest();

        // verifica se a requisi��o � do tipo post
        if ($request->isPost()) {
            // obter e armazenar valores do post
            $postData = $request->getPost()->toArray();
            $formularioValido = true;

            // verifica se o formul�rio segue a valida��o proposta
            if ($formularioValido) {
                // aqui vai a l�gica para editar os dados � tabela no banco
                // 1 - solicitar servi�o para pegar o model respons�vel pela atualiza��o
                // 2 - editar dados no banco pelo model

                // adicionar mensagem de sucesso
                $this->flashMessenger()->addSuccessMessage("Contato editado com sucesso");

                // redirecionar para action detalhes
                return $this->redirect()->toRoute('contatos', array("action" => "detalhes", "id" => $postData['id'],));
            } else {
                // adicionar mensagem de erro
                $this->flashMessenger()->addErrorMessage("Erro ao editar contato");

                // redirecionar para action editar
                return $this->redirect()->toRoute('contatos', array('action' => 'editar', "id" => $postData['id'],));
            }
        }
    }

    // DELETE /contatos/deletar/id
    public function deletarAction()
    {
        // filtra id passsado pela url
        $id = (int) $this->params()->fromRoute('id', 0);

        // se id = 0 ou n�o informado redirecione para contatos
        if (!$id) {
            // adicionar mensagem de erro
            $this->flashMessenger()->addMessage("Contato n�o encotrado");

        } else {
            // aqui vai a l�gica para deletar o contato no banco
            // 1 - solicitar servi�o para pegar o model respons�vel pelo delete
            // 2 - deleta contato

            // adicionar mensagem de sucesso
            $this->flashMessenger()->addSuccessMessage("Contato de ID $id deletado com sucesso");

        }

        // redirecionar para action index
        return $this->redirect()->toRoute('contatos');
    }

}

