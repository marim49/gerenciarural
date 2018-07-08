
function imprimir() {
var conteudo = document.getElementById('printjs').innerHTML;
   tela_impressao = window.open('about:blank');
   tela_impressao.document.write(conteudo);
   tela_impressao.window.print();
   tela_impressao.window.close();

    //window.print();
}

