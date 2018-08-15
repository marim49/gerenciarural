function Maquinas() {
    //fazenda = $("#fazendas").val();attr
    fazenda = JSON.parse($("#fazendas").find(':selected').attr('data-id'));
    console.log(fazenda);
    funcionarios = fazenda.funcionarios;
    maquinas = fazenda.maquinas;

    var selectFuncionario = document.getElementById("funcionario");
    var selectMaquinas = document.getElementById("maquina");

    //Limpar Selects
    for (var i in selectFuncionario.options) {
        selectFuncionario.remove(i);
        selectFuncionario.options[selectFuncionario.sel]
    }
    for (var i in selectMaquinas.options) {
        selectMaquinas.remove(i);
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