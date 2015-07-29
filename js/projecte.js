function esborraTasca(id)
{
	var sol = new XMLHttpRequest()
	sol.open('GET','esborraTasca.php?id='+id,false)
	sol.send()
	document.getElementById('tasca'+id).style.display='none'
}

function modificaTasca(id,acabada,input)
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

function guarda()
//guarda el canvi de nom
{
	var nouNom=document.getElementById('nouNom').value
	window.location='canviaNomProjecte.php?id_projecte='+id+'&nouNom='+nouNom
}

function editable(element)
//converteix un element de text en un input
{
	//modifica el comportament onclick del titol
	element.setAttribute('onclick','')
	//crea nou element <input>
	var input=document.createElement('input')
	//guarda el contingut del titol
	var contingut=element.innerHTML
	//omple el input
	input.value=contingut
	//si apreta enter...
	input.setAttribute('onkeydown','if(event.which==13)guarda()')
	//esborra el titol
	element.innerHTML=''
	//posa l'element input dins el titol
	element.appendChild(input)
	input.select()
	input.focus()
	input.id='nouNom'
	//crea boto guardar
	var boto=document.createElement('button')
	boto.innerHTML='Guardar canvis'
	boto.setAttribute('onclick','guarda()')
	element.appendChild(boto)
}

function esborraProjecte()
{
	if(confirm('El projecte serà esborrat. Continuar?'))
		window.location='esborraProjecte.php?id='+id
}
