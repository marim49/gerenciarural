function SaidaInsumo() {
    fazenda = JSON.parse($("#fazendas").val());

    terras = fazenda.terras;
    funcionarios = fazenda.funcionarios;
    insumos = fazenda.insumos;

    var selectTerra = document.getElementById("terra");
    var selectInsumo = document.getElementById("insumo");
    var selectFuncionario = document.getElementById("funcionario");

    //Limpar Selects
    for (var i in selectTerra.options) {
        selectTerra.remove(i);
    }
    for (var i in selectFuncionario.options) {
        selectFuncionario.remove(i);
    }
    for (var i in selectInsumo.options) {
        selectInsumo.remove(i);
    }

    //Preencher terras
    if (!$.isEmptyObject(terras)) {
        for (var i in terras) {
            var el = document.createElement("option");
            el.textContent = terras[i].nome;
            el.value = terras[i].id;
            selectTerra.appendChild(el);
        }
    } else {
        var el = document.createElement("option");
        el.textContent = 'Vazio';
        el.value = '';
        selectTerra.appendChild(el);
    }
    //Preencher insumos
    if (!$.isEmptyObject(insumos)) {
        for (var i in insumos) {
            var el = document.createElement("option");
            el.textContent = insumos[i].tipo_insumo.nome + " | Estoque: " + insumos[i].quantidade;
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