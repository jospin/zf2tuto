<?php

namespace Contato\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ContatoController extends AbstractActionController
{

    public function indexAction()
    {
        return new ViewModel();
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

    // GET /contatos/detalhes/id
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

        // aqui vai a l�gica para pegar os dados referente ao contato
        // 1 - solicitar servi�o para pegar o model respons�vel pelo find
        // 2 - solicitar form com dados desse contato encontrado
        // formul�rio com dados preenchidos
        $form = array(
            'nome' => 'Igor Rocha',
            "telefone_principal" => "(085) 8585-8585",
            "telefone_secundario" => "(085) 8585-8585",
            "data_criacao" => "02/03/2013",
            "data_atualizacao" => "02/03/2013",
        );

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

        // aqui vai a l�gica para pegar os dados referente ao contato
        // 1 - solicitar servi�o para pegar o model respons�vel pelo find
        // 2 - solicitar form com dados desse contato encontrado

        // formul�rio com dados preenchidos
        $form = array(
            'nome'                  => 'Igor Rocha',
            "telefone_principal"    => "(085) 8585-8585",
            "telefone_secundario"   => "(085) 8585-8585",
        );

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

