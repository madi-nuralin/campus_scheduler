/* table.js 
 */

function tbAddRow(id)
{ 
	var aForm = document.getElementById("form_add");
		aForm.reset();
	var aError = aForm.getElementsByClassName("form-msg-error")[0].innerHTML="\n";

	modalWindow(0); 
}

function tbRmRow(id, rmIdList, rmTitleList)
{
	var table = document.getElementById(id), tr = table.tBodies[0].rows;

	var rmForm = document.getElementById("form_remove"),
		rmUl = rmForm.getElementsByTagName("ul")[0], rmLi;
		rmUl.innerHTML="";
	var rmInChbox, rmInHidden;

	var i, j;

	for (i = 0; i < tr.length; ++i) 
	{
		rmInChbox = tr[i].cells[0].getElementsByTagName('input');

		for (j = 0; j < rmInChbox.length; ++j) 
		{
			if (rmInChbox[j].checked) 
			{
				rmInHidden = document.createElement("input");
				rmInHidden.setAttribute("type", "hidden");
				rmInHidden.setAttribute("name", "rmList[]");
				rmInHidden.setAttribute("value", rmIdList[i]);

				rmLi = document.createElement("li");
				rmLi.appendChild(rmInHidden);
				rmLi.appendChild(document.createTextNode(rmTitleList[i]));

				rmUl.appendChild(rmLi);
			}
		}
	}

	modalWindow(1);
}

function tbMkRow(id, mkBtn, mkAttributes, mkList)
{ 
	var table = document.getElementById(id);

	var mkForm = document.getElementById("form_edit"),
			mkError = mkForm.getElementsByClassName("form-msg-error")[0].innerHTML = "\n",
			mkTr = mkBtn.parentNode.parentNode,
			mkTd = mkTr.getElementsByTagName("td");
	var i, j, cnt=0;

	mkForm.reset();

	for (i = 0; i < mkAttributes.length; ++i) {
		
		if (mkAttributes[i].length < 2)
			return;

		var mkInput = mkForm.querySelector('[name="' + mkAttributes[i][1] + '"]');

		switch (mkAttributes[i][0]) {	
			case "text":
				mkInput.value = mkList[i];
				break;
			case "select":
				mkInput.value = mkAttributes[i][3][mkAttributes[i][3].length-1];

				for(j = 0; j < mkAttributes[i][2].length; ++j) 
				{
					if (mkAttributes[i][3][j]==mkList[i]) 
					{
						mkInput.value = mkAttributes[i][3][j];
						break;
					}
				}
				break;
			case "date":
				mkInput.value = mkList[i];
				break;
			case "hidden":
				mkInput.value = mkList[i];
				break;
			case "number":
				mkInput.value = mkList[i];
				break;
			case "textarea":
				mkInput.value = mkList[i];
				break;
			case "checkbox":
				mkInput.checked = mkList[i];
				break;
			default:
				break;
		} 
	}

	modalWindow(2);
}

function tbStat(id)
{
	document.getElementsByClassName('span table-status')[0].innerHTML = 
	document.getElementById(id).tBodies[0].rows.length + " items";
}

function tbSetRow(id, stCheckbox) 
{	
	var tr = stCheckbox.parentElement.parentElement;
	tr.setAttribute("class", stCheckbox.checked ? "tr checked":"tr unchecked");
}

function tbSetAllRow(id, stCheckboxH) 
{
	var table = document.getElementById(id), tr = table.tBodies[0].rows;
	var stCheckbox;
	var i;

	if (stCheckboxH.checked) 
		for (i = 0; i < tr.length; ++i) 
		{
			stCheckbox = tr[i].cells[0].getElementsByTagName('input')[0];
			stCheckbox.checked = true;
			tbSetRow(id, stCheckbox);
		}
	else
		for (i = 0; i < tr.length; ++i) 
		{
			stCheckbox = tr[i].cells[0].getElementsByTagName('input')[0];
			stCheckbox.checked = false;
			tbSetRow(id, stCheckbox);
		}
}

function tbFindRow(id, fndIn) 
{
	var table = document.getElementById(id), tr = table.tBodies[0].rows, td;
	var fndFilter = fndIn.value.toUpperCase(), fndContent;

	var i, j;

	for (i = 0; i < tr.length; ++i) 
	{
		td = tr[i].getElementsByTagName("td");

		for (j = 0; j < td.length; ++j) 
		{
			if (td[j]) 
			{
				fndContent = td[j].fndContent || td[j].innerText;
				if (fndContent.toUpperCase().indexOf(fndFilter) > -1) {
					tr[i].style.display="";
					break;
				}
				else {
					tr[i].style.display="none";
				}
			}
		}
	}
}
