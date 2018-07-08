
function validar()
{
	var nome= document.registrar.inserirnome.value;
	if(nome.length<=6)
	{
		
		alert('Insira seu nome completo ');
		return false;
	}
	var senha= document.registrar.inserirsenha.value;
	var confirmarsenha=document.registrar.confirmarsenha.value;
	if(senha!=confirmarsenha)
	{
		
		alert('Sua confirmação de senha não confere !');
		return false;
	}
	if(senha.length<=6)
	{
		alert('Sua senha deve ser maior do que seis caracter');
		return false;
	}
	var email=document.registrar.inseriremail.value;
	var confirmaremail=document.registrar.confirmaremail.value;
	if(email!=confirmaremail)
	{
		alert('Sua confirmação de Email não confere !');
		return false;
	}
}
