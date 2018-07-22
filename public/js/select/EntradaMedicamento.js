function EntradaMedicamento() {
    fazenda = $("#fazendas").val();

    var selectFuncionario = document.getElementById("funcionario");

    for (var i in selectFuncionario.options) {
        selectFuncionario.remove(i);
    }
    $('#myTable tbody tr').remove();

    if (fazenda != "") {
        //Liberar campos   
        $("#produtos").show();
        $("#div_funcionario").show();

        fazenda = JSON.parse(fazenda);
        funcionarios = fazenda.funcionarios;

        
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
    else{       
        $("#produtos").hide();
        $("#div_funcionario").hide();
    }
}