/*
 *	Utils
 */

function geId(id){ 		return document.getElementById(id) }
function geName(name){ 		return document.getElementsByName(name) }
function geClass(className){ 	return document.getElementsByClassName(className) }

/*
 * Funcions
 */
function programa(id,ev)
{
	//fes apareixer un menu per seleccionar un dia
	var div=document.createElement('div');
	document.body.appendChild(div);
	div.innerHTML="<span style=color:black>Programa per:</span>";
	div.className="popup";
	div.style.left=ev.pageX+"px";
	div.style.top=ev.pageY+"px";

	//Opcions: dl,dm,dx,dj,dv
	var opcions = {
		Dilluns:0,
		Dimarts:1,
		Dimecres:2,
		Dijous:3,
		Divendres:4,
		Dissabte:5,
		Diumenge:6,
	}

	for(var dia in opcions)
	{
		var op = document.createElement('div'); 
		div.appendChild(op);
		op.className="dia"
		op.innerHTML="- "+dia;
		op.setAttribute('onclick','enviaTascaAPlaSetmanal('+id+','+opcions[dia]+')');
	}

	var cancelar = document.createElement('button')
	div.appendChild(cancelar);
	cancelar.innerHTML="Cancelar";
	cancelar.onclick=function(){div.style.display='none'}

}

function enviaTascaAPlaSetmanal(id,dia)
{
	var sol=new XMLHttpRequest();
	sol.open('GET','novaTascaPlaSetmanal.php?id_tasca='+id+'&dia='+dia,false);
	sol.send();
	window.location.reload();
}

function tascaProgramada(id)
//pinta de taronja la tasca id per marcar que està al pla setmanal
{
	if(!document.getElementById('tasca'+id))return
	var tr=document.getElementById('tasca'+id);
	tr.style.backgroundColor='orange';

	//remou comportament per programar al pla setmanal
	var td = tr.childNodes[0];
	td.setAttribute('onclick',"if(confirm('Desprogramar?')){window.location='esborraDelPlaSetmanal.php?id="+id+"'}");
}

function tascaDeadline(id,deadline)
//posa un quadrat vermell a la tasca per marcar que té deadline
{
	if(!document.getElementById('tasca'+id)) return

	//calcula els dies
	var dies = Math.ceil(parseInt(new Date(deadline) - new Date())/1000/60/60/24)
	//pinta els dies de vermell 
	document.getElementById('tasca'+id).childNodes[0].innerHTML+=" (<b style=color:red>"+dies+" dies</b>)"
}

function llegenda()
//mostra o amaga la llegenda
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
		botons[i].classList.remove('actiu')

	//ressalta el boto que activa l'area
	document.getElementById('boto_area'+area).classList.add('actiu')

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
