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
	var tr=document.getElementById('tasca'+id);

	var sched = tr.getAttribute('sched')
	var deadl = tr.getAttribute('deadl')

	//si ja té deadline i schedule, para
	if(sched && deadl) return 

	//fes apareixer un menu per seleccionar un dia o posar deadline
	var popup=document.createElement('div');
	document.body.appendChild(popup);
	popup.className="popup";
	popup.style.left=ev.pageX+"px";
	popup.style.top=ev.pageY+"px";

	//PLA SETMANAL
	if(!sched)
	{
		var div=document.createElement('div');
		popup.appendChild(div);
		if(!deadl) div.style.borderRight="1px solid #ddd"
		div.style.paddingRight="10px"
		div.className="inline";
		div.innerHTML="<span style=color:black>Ho faré:</span>";
		var opcions = {
			Dilluns:0,
			Dimarts:1,
			Dimecres:2,
			Dijous:3,
			Divendres:4,
			Dissabte:5,
			Diumenge:6,
		}
		var avui = (new Date()).getDay()-1;
		for(var dia in opcions)
		{
			var op = document.createElement('div'); 
			div.appendChild(op);
			op.className="dia"
			if(opcions[dia]==avui)
				op.innerHTML="<b>- "+dia+"</b>";
			else
				op.innerHTML="- "+dia;
			op.setAttribute('onclick','enviaTascaAPlaSetmanal('+id+','+opcions[dia]+')');
		}
	}

	//DEADLINE
	if(!deadl)
	{
		var divDL=document.createElement('div');
		popup.appendChild(divDL);
		divDL.className='inline';
		divDL.innerHTML="<span style=color:black>Data límit:</span>"
		var input = document.createElement('input');
		divDL.appendChild(input);
		input.style.display='block'
		input.type='date'
		input.onchange=function()
		{
			var sol = new XMLHttpRequest();
			sol.open('GET','novaDeadline.php?id_tasca='+id+'&deadline='+input.value,false)
			sol.send()
			window.location.reload();
		}
	}

	//BOTO CANCELAR
		var cancelarContainer = document.createElement('div')
		popup.appendChild(cancelarContainer);
		cancelarContainer.style.marginTop="0.5em";
		cancelarContainer.style.textAlign="center";
		var cancelar = document.createElement('button')
		cancelarContainer.appendChild(cancelar);
		cancelar.innerHTML="Cancelar";
		cancelar.onclick=function(){popup.style.display='none'}
}

function enviaTascaAPlaSetmanal(id,dia)
{
	var sol=new XMLHttpRequest();
	sol.open('GET','novaTascaPlaSetmanal.php?id_tasca='+id+'&dia='+dia,false);
	sol.send();
	window.location.reload();
}

function tascaProgramada(id,dia)
//pinta de taronja la tasca id per marcar que està al pla setmanal
{
	if(!document.getElementById('tasca'+id))return

	//element
	var tr=document.getElementById('tasca'+id);
	tr.setAttribute('sched',true)

	//"dia" es un numero de 0 a 6
	dies=["Dll","Dm","Dx","Dj","Dv","Ds","Dg"];

	//posa indicador
	var td = tr.childNodes[0];
	td.innerHTML+=" <b title='Desprogramar' onclick=\"event.stopPropagation();if(confirm('Desprogramar?')){window.location='esborraDelPlaSetmanal.php?id="+id+"'}\" style='cursor:pointer;padding:1px;border:1px solid #666;border-radius:0.3em;background:orange'> "+dies[dia]+"</b>";
}

function tascaDeadline(id,deadline,id_dl)
//posa un quadrat vermell a la tasca per marcar que té deadline
{
	if(!document.getElementById('tasca'+id)) return

	//element
	var tr=document.getElementById('tasca'+id)
	tr.setAttribute('deadl',true)

	//calcula els dies
	var dies = Math.ceil(parseInt(new Date(deadline) - new Date())/1000/60/60/24)
	var tamany = Math.max((40/Math.max(dies,1)),12)+"px";

	//posa indicador
	var td=tr.childNodes[0]
	td.innerHTML+=" <b title='Esborrar data límit ("+deadline+")' onclick=\"event.stopPropagation();if(confirm('Esborrar data límit?')){window.location='esborraDeadline.php?id="+id_dl+"'}\" style='font-size:"+tamany+";cursor:pointer;padding:1px;border:1px solid #666;border-radius:0.3em;background:#f78181'> "+dies+"d</b>";
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
