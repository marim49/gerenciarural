function EntradaCombustivel() {
    fazenda = JSON.parse($("#fazendas").val());
    
    console.log(fazenda);
    maquinas = fazenda.Maquinas;
    funcionarios = fazenda.Funcionarios;
    combustiveis = fazenda.Combustiveis;

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
            el.textContent = combustiveis[i].nome;
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