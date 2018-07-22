function SaidaMedicamento() {
    fazenda = JSON.parse($("#fazendas").val());

    animais = fazenda.animais;
    funcionarios = fazenda.funcionarios;
    medicamentos = fazenda.medicamentos;

    var selectAnimal = document.getElementById("animal");
    var selectMedicamento = document.getElementById("medicamento");
    var selectFuncionario = document.getElementById("funcionario");

    //Limpar Selects
    for (var i in selectAnimal.options) {
        selectAnimal.remove(i);
    }
    for (var i in selectMedicamento.options) {
        selectMedicamento.remove(i);
    }
    for (var i in selectFuncionario.options) {
        selectFuncionario.remove(i);
    }

    //Preencher animais
    if (!$.isEmptyObject(animais)) {
        for (var i in animais) {
            var el = document.createElement("option");
            el.textContent = animais[i].nome + " | Grupo do Animal: " + animais[i].grupo_animal.nome;
            el.value = animais[i].id;
            selectAnimal.appendChild(el);
        }

    } else {
        var el = document.createElement("option");
        el.textContent = 'Vazio';
        el.value = '';
        selectAnimal.appendChild(el);
    }

    //Preencher medicamentos
    if (!$.isEmptyObject(medicamentos)) {
        for (var i in medicamentos) {
            var el = document.createElement("option");
            el.textContent = medicamentos[i].nome + " | Grupo: " + medicamentos[i].tipo_medicamento.nome + " | Estoque: " + medicamentos[i].quantidade + " Ml(s)";
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