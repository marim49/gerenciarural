function EntradaCombustivel() {
    //fazenda = $("#fazendas").val();attr
    fazenda = JSON.parse($("#fazendas").find(':selected').attr('data-id'));
    console.log(fazenda);
    funcionarios = fazenda.funcionarios;

    var selectFuncionario = document.getElementById("funcionario");

    //Limpar Selects
    for (var i in selectFuncionario.options) {
        selectFuncionario.remove(i);
        selectFuncionario.options[selectFuncionario.sel]
    }

    //Preencher funcionários
    if (!$.isEmptyObject(funcionarios)) {
        for (var i in funcionarios) {
            var el = document.createElement("option");
            el.textContent = funcionarios[i].nome;
            el.value = funcionarios[i].id;
            selectFuncionario.appendChild(el);
        }

    } else {
        var el = document.createElement("option");
        el.textContent = 'Vazio';
        el.value = '';
        selectFuncionario.appendChild(el);
    }
}