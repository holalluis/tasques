/*
 *	Utils
 */

function geId(id){ 		return document.getElementById(id) }
function geName(name){ 		return document.getElementsByName(name) }
function geClass(className){ 	return document.getElementsByClassName(className) }

/*
 * Funcions
 */

function llegenda()
{
	var l = geId('llegenda')
	if(l.style.display=='none')
		l.style.display='inline-block'
	else
		l.style.display='none'
}

function mostraArea(area)
//mostra només els projectes de l'area demanada
{
	//Agafa tots els projectes i amaga'ls
	var projectes = document.getElementsByClassName('projecte');
	for(var i=0; i<projectes.length; i++)
	{
		projectes[i].style.display='none';
	}

	//mostra només els projectes amb atribut area=area
	for(var i=0; i<projectes.length; i++)
	{
		var area_projecte = projectes[i].getAttribute('area');
		if(area_projecte == area)
			projectes[i].style.display=''
	}

	//desressalta tots els botons que activen arees
	var botons = document.getElementsByClassName('boto_area')
	for(var i=0; i<botons.length; i++)
		botons[i].style.backgroundColor=''

	//ressalta el boto que activa l'area
	document.getElementById('boto_area'+area).style.backgroundColor='yellow'

	//per acabar, selecciona el valor de l'area triada en el camp "nou projecte"
	document.getElementById('area_select').value=area
}

function modificaTasca(id,acabada,input)
//MySQL: modifica el camp "acabada" d'una tasca
{
	var sol = new XMLHttpRequest()
	sol.open('GET','modificaTasca.php?id='+id+'&acabada='+acabada,false)
	sol.send()
	//canvia el color de la tasca
	if(sol.responseText=="Modificant tasca...ok")
	{
		if(acabada==0)
			document.getElementById('tasca'+id).removeAttribute('acabada')
		else
			document.getElementById('tasca'+id).setAttribute('acabada',1)
	}
	//canvia el comportament del boto input per modificar tasca (toggle)
	input.setAttribute('onclick','modificaTasca('+id+','+(acabada ? 0 : 1)+',this)')
}

function ressalta(id)
//ressalta en groc l'element id 
{
	geId(id).style.backgroundColor='#ffff66'
	geId('focus').focus()
}

function ressalta_off(id)
//treu el ressaltat de l'element id
{
	geId(id).style.backgroundColor=''
}

function esborraTasca(tasca)
//MySQL: esborra una tasca de la base de dades
{
	var sol = new XMLHttpRequest()
	sol.open('GET',"esborraTasca.php?id="+tasca,false)
	sol.send()
	document.getElementById('tasca'+tasca).style.display='none'
}