<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Ajuda do sistema WebNurse';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-ajuda">
    <h3><?= Html::encode($this->title) ?></h3>

    <section>
		<strong>Este material serve para orientar o usuário na operação do sistema.</br>
            Em caso de dúvidas adicionais, entre em contato pelo endereço no final da página.</strong>
	</section>

	<section id="pageContent">
		<main role="main">
			<article>
				<h3>Painel - Dashboard</h3>
				<h5>Serve para auxiliar o Enfermeiro no controle da execução dos
                    procedimentos cadastrados na tela "Procedimentos", com uma
                    visão geral dos procedimentos do dia atual.
                </h5>
				<h5>Clique no link do quadro desejado (por exemplo, "Situação: Em
                     Cirurgia"), para listar as cirurgias em andamento na tela
                     de Procedimentos.
                 </h5>
			</article>
			<article>
                <h3>Procedimentos</h3>
				<h5>Serve para listar os procedimentos cadastrados. Permite buscar
                    um ou mais procedimentos específicos a partir de termos chave
                    (pode ser apenas parte da palavra) e/ou definindo datas de início
                    e fim.
                </h5>
                <ul>
                    <li><h5>Por padrão, ele exibe os com data de início de hoje (meia-noite).
                    Caso listar os procedimentos com data anterior a hoje, clique
                    no ícone <span class="glyphicon glyphicon-remove"></span>, ao lado
                    da caixa de data.
                </h5>
                    </li>
                    <li>
        				<h5>Se precisar cadastrar um novo procedimento, clique no botão
                            <span class="btn btn-success">Incluir Procedimento</span>,
                            localizado no topo da página, abaixo do título.
                        </h5>
                    </li>
                    <li>
                        <h5>Na coluna "Ações", à direita da tabela, são mostrados os ícones
                             <span class="glyphicon glyphicon-eye-open">"olho"</span>,
                             <span class="glyphicon glyphicon-pencil">"lápis"</span> e
                             <span class="glyphicon glyphicon-trash">"lixeira"</span>,
                            que representam as ações de "exibir", "alterar" e "excluir",
                            respectivamente.
                        </h5>
                    </li>
                    <li>
                        <h5>Nota: por uma questão técnica, apenas alguns detalhes são
                            mostrados tela de exibição. Portanto, para consultar todas as
                            informações cadastradas em um procedimento, é preciso abrir a
                            tela de alteração daquele procedimento pelo ícone do lápis
                            <span class="glyphicon glyphicon-pencil"></span>, ou pelo
                            botão <span class="btn btn-primary">Alterar</span>
                        </h5>
                    </li>
                    <li>
                        <h5>Na tela de alteração, os campos "Equipe de Profissionais" e
                            "Kit de Equipamentos" podem receber um mais nomes de profissionais
                            e equipamentos. Basta digitar para selecionar os desejados,
                            e clicar no "X" para removê-los.
                        </h5>
                    </li>
                    <li>
                        <h5>O campo "Responsável" somente exibe profissionais habilitados
                            como responsáveis por procedimentos cirúrgicos, no respectivo
                            cadastro de "Categoria Profissional".
                        </h5>
                    </li>
                    <li>
                        <h5>Com o passar do tempo, o sistema estimará o fim para os
                            procedimentos, informando uma dica no campo "Fim estimado",
                            com base na duração média dos procedimentos cadastrados
                            anteriormente.
                            Também preencherá os equipamentos mais utilizados para o tipo
                            de procedimento, especialidade e responsável selecionados.
                        </h5>
                    </li>
            </ul>
			</article>
			<article>
                <h3>Cadastro</h3>
				<h5>Serve para gerenciar os mais diversos cadastros necessários
                    para o funcionamento do sistema. O modo de uso é muito
                    semelhante ao cadastro de procedimentos.
                    <ul>
                        <li>Profissionais: mantém os nomes dos profissionais do
                            hospital, e a informação de sua categoria profissional;
                        </li>
                        <li>Equipamentos Cirúrgicos: informações dos Equipamentos
                            disponíveis no centro cirúrgico. Inclui informações
                            para auxiliar no controle de manutenção periódica;
                        </li>
                        <li>Especialidades Médicas: nomeclatura para definir a
                            natureza médica dos procedimentos;
                        </li>
                        <li>Categorias Profissionais: define o enquadramento dos
                            profissionais cadastrados;
                        </li>
                        <li>Tipos de Procedimento: descreve os nomes utilizados
                            para os procedimentos no hospital;
                        </li>
                        <li>Salas Cirúrgicas: informa as salas disponíveis no bloco;
                        </li>
                        <li>Situações (status de cirurgia): orienta a situação do
                            procedimento, conforme sua evolução; é importante manter
                            cadastradas as situações "Finalizado", "Em cirurgia" e
                            "Cancelado", para efeito de controle no Painel.
                        </li>
                    </ul>
                </h5>
			</article>
		</main>
        </br>
		<aside>
			<div>CONTATO:</div>
			<div>Eduardo Pooter Reis</div>
			<div>senac@duduzinho.com</div>
		</aside>
	</section>

</div>
