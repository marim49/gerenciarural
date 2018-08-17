function editarFuncionario() {
	$('#exampleModal').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget); // Button that triggered the modal
		var id = button.data('id');
		var nome = button.data('nome');
		var pis = button.data('pis');
		var rg = button.data('rg');
		var cpf = button.data('cpf');
		var tel = button.data('tel');
		var celular = button.data('celular');
		var estadocivil = button.data('estadocivil');
		var nascimento = button.data('nascimento');
		var numero = button.data('numero');
		var rua = button.data('rua');
		var bairro = button.data('bairro');
		var cidade = button.data('cidade');
		var estado = button.data('estado');
		var pais = button.data('pais');
		var cep = button.data('cep');
		var admissao = button.data('admissao');
		var fazenda = button.data('fazenda');
		var cargo = button.data('cargo');
		var sexo = button.data('sexo');
		// Extract info from data-* attributes
		// If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
		// Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
		var modal = $(this);
		modal.find('.modal-title').text('ID ' + id);
		modal.find('#id').val(id);
		modal.find('#nome').val(nome);
		modal.find('#pis').val(pis);
		modal.find('#rg').val(rg);
		modal.find('#cpf').val(cpf);
		modal.find('#tel_fixo').val(tel);
		modal.find('#celular').val(celular);
		modal.find('#estadocivil').val(estadocivil);
		modal.find('#dnascimento').val(nascimento);
		modal.find('#endereco_rua').val(rua);
		modal.find('#endereco_numero').val(numero);
		modal.find('#endereco_bairro').val(bairro);
		modal.find('#endereco_cidade').val(cidade);
		modal.find('#endereco_estado').val(estado);
		modal.find('#endereco_pais').val(pais);
		modal.find('#cep').val(cep);
		modal.find('#admissao').val(admissao);
		modal.find('#fazenda').val(fazenda);
		modal.find('#cargo').val(cargo);
		modal.find('#sexo').val(sexo);




	})
}

function editarTerra() {
	$('#exampleModal').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget); // Button that triggered the modal
		var id = button.data('id');
		var nome = button.data('nome');
		var fazenda = button.data('fazenda');
		var area = button.data('area');
		// Extract info from data-* attributes
		// If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
		// Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
		var modal = $(this);
		modal.find('.modal-title').text('ID ' + id);
		modal.find('#id').val(id);
		modal.find('#nome').val(nome);
		modal.find('#fazenda').val(fazenda);
		modal.find('#area').val(area);
	})
}

function cancelarOperacao() {
	$('#modal_cancelar').on('show.bs.modal', function (event) {
		//recupera botão que chamou o modal
		var button = $(event.relatedTarget);
		var id = button.data('id');
		var route = button.data('route');
		//seta action do form
		var modal = $(this);		
		modal.find('#cancelar').attr("action", route + "/" + id);
	})
}


function editarFazenda() {
	$('#exampleModal').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget); // Button that triggered the modal
		var id = button.data('id');
		var nome = button.data('nome');
		var localidade = button.data('localidade');
		// Extract info from data-* attributes
		// If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
		// Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
		var modal = $(this);
		modal.find('.modal-title').text('ID ' + id);
		modal.find('#id').val(id);
		modal.find('#nome').val(nome);
		modal.find('#localidade').val(localidade);
	})



}

function editarFornecedor() {
	$('#exampleModal').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget); // Button that triggered the modal
		var id = button.data('id');
		var nome = button.data('nome');
		var telefone = button.data('telefone');
		// Extract info from data-* attributes
		// If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
		// Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
		var modal = $(this);
		modal.find('.modal-title').text('ID ' + id);
		modal.find('#id').val(id);
		modal.find('#nome').val(nome);
		modal.find('#telefone').val(telefone);
	})



}

function editarAnimal() {
	$('#exampleModal').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget); // Button that triggered the modal
		var id = button.data('id');
		var nome = button.data('nome');
		var nomemae = button.data('nomemae');
		var nomepai = button.data('nomepai');
		var nascimento = button.data('nascimento');
		var grupoanimal = button.data('grupoanimal');
		var entrada = button.data('entrada');
		var fazenda = button.data('fazenda')
		// Extract info from data-* attributes
		// If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
		// Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
		var modal = $(this);
		modal.find('.modal-title').text('ID ' + id);
		modal.find('#id').val(id);
		modal.find('#nome').val(nome);
		modal.find('#nomemae').val(nomemae);
		modal.find('#nomepai').val(nomepai);
		modal.find('#nascimento').val(nascimento);
		modal.find('#grupoanimal').val(grupoanimal);
		modal.find('#entrada').val(entrada);
		modal.find('#fazenda').val(fazenda);
	})



}

function editarMaquina() {
	$('#exampleModal').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget); // Button that triggered the modal
		var id = button.data('id');
		var nome = button.data('nome');
		var fazenda = button.data('fazenda');
		var datacompra = button.data('datacompra');
		// Extract info from data-* attributes
		// If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
		// Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
		var modal = $(this);
		modal.find('.modal-title').text('ID ' + id);
		modal.find('#id').val(id);
		modal.find('#nome').val(nome);
		modal.find('#fazenda').val(fazenda);
		modal.find('#datacompra').val(datacompra);
	})



}


