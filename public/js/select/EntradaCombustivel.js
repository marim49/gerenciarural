function EntradaCombustivel() {
    fazenda = JSON.parse($("#fazendas").val());

    funcionarios = fazenda.funcionarios;
    combustiveis = fazenda.combustiveis;

    var selectCombustivel = document.getElementById("combustivel");
    var selectFuncionario = document.getElementById("funcionario");

    //Limpar Selects
    for (var i in selectCombustivel.options) {
        selectCombustivel.remove(i);
    }
    for (var i in selectFuncionario.options) {
        selectFuncionario.remove(i);
    }

    //Preencher combustiveis
    if (!$.isEmptyObject(combustiveis)) {
        for (var i in combustiveis) {
            var el = document.createElement("option");
            el.textContent = combustiveis[i].tipo_combustivel.nome;
            el.value = combustiveis[i].id;
            selectCombustivel.appendChild(el);
        }
    } else {
        var el = document.createElement("option");
        el.textContent = 'Vazio';
        el.value = '';
        selectCombustivel.appendChild(el);
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