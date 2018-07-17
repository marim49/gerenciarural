function EntradaInsumo() {
    fazenda = JSON.parse($("#fazendas").val());

    funcionarios = fazenda.funcionarios;
    insumos = fazenda.celeiro.insumos;

    var selectInsumo = document.getElementById("insumo");
    var selectFuncionario = document.getElementById("funcionario");

    //Limpar Selects
    for (var i in selectFuncionario.options) {
        selectFuncionario.remove(i);
    }
    for (var i in selectInsumo.options) {
        selectInsumo.remove(i);
    }

    //Preencher insumos
    if (!$.isEmptyObject(insumos)) {
        for (var i in insumos) {
            var el = document.createElement("option");
            el.textContent = insumos[i].tipo_insumo.nome;
            el.value = insumos[i].id;
            selectInsumo.appendChild(el);
        }
    } else {
        var el = document.createElement("option");
        el.textContent = 'Vazio';
        el.value = '';
        selectInsumo.appendChild(el);
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