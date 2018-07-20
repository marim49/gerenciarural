function SaidaCombustivel() {
    fazenda = JSON.parse($("#fazendas").val());

    maquinas = fazenda.maquinas;
    funcionarios = fazenda.funcionarios;
    combustiveis = fazenda.combustiveis;

    var selectMaquinas = document.getElementById("maquina");
    var selectCombustivel = document.getElementById("combustivel");
    var selectFuncionario = document.getElementById("funcionario");

    //Limpar Selects
    for (var i in selectMaquinas.options) {
        selectMaquinas.remove(i);
    }
    for (var i in selectCombustivel.options) {
        selectCombustivel.remove(i);
    }
    for (var i in selectFuncionario.options) {
        selectFuncionario.remove(i);
    }

    //Preencher máquinas
    if (!$.isEmptyObject(maquinas)) {
        for (var i in maquinas) {
            var el = document.createElement("option");
            el.textContent = maquinas[i].nome;
            el.value = maquinas[i].id;
            selectMaquinas.appendChild(el);
        }

    } else {
        var el = document.createElement("option");
        el.textContent = 'Vazio';
        el.value = '';
        selectMaquinas.appendChild(el);
    }

    //Preencher combustiveis
    if (!$.isEmptyObject(combustiveis)) {
        for (var i in combustiveis) {
            var el = document.createElement("option");
            el.textContent = "Diesel | Estoque: " + combustiveis[i].quantidade + " litro(s)";
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