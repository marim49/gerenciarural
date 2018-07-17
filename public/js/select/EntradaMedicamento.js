function EntradaMedicamento() {
    fazenda = JSON.parse($("#fazendas").val());

    funcionarios = fazenda.funcionarios;
    medicamentos = fazenda.medicamentos;

    var selectMedicamento = document.getElementById("medicamento");
    var selectFuncionario = document.getElementById("funcionario");

    //Limpar Selects
    for (var i in selectMedicamento.options) {
        selectMedicamento.remove(i);
    }
    for (var i in selectFuncionario.options) {
        selectFuncionario.remove(i);
    }

    //Preencher combustiveis
    if (!$.isEmptyObject(medicamentos)) {
        for (var i in medicamentos) {
            var el = document.createElement("option");
            el.textContent = medicamentos[i].nome + " | Tipo do Medicamento: " + medicamentos[i].tipo_medicamento.nome;
            el.value = medicamentos[i].id;
            selectMedicamento.appendChild(el);
        }
    } else {
        var el = document.createElement("option");
        el.textContent = 'Vazio';
        el.value = '';
        selectMedicamento.appendChild(el);
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