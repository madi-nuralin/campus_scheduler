/* modal.js
 */


// When the user clicks the button, open the modal 
function modalWindow(mIndex) 
{
	var modal = document.getElementsByClassName("modal")[0];
	var modalW = document.getElementsByClassName("modalWindow")[mIndex];
	modal.style.display = "block";

	modalW.style.display = "table";

  //modal.offsetHeight/2;
  //modalW.offsetHeight/2;
  modalW.style.marginTop = "" + 
    parseInt(modal.offsetHeight/2 - modalW.offsetHeight/2) + "px";
}

window.onclick = function(event) 
{
  var modal = document.getElementsByClassName("modal")[0];
  var modalW = document.getElementsByClassName("modalWindow");

  var dropdown = document.getElementsByClassName("dropbtn"); 
  var dropdown_content = document.getElementsByClassName("dropdown_content");

  if (event.target == modal) 
  {
  	modal.style.display = "none";
  	for (var i = 0; i < modalW.length; i++) 
  		modalW[i].style.display = "none";

    for (var i = 0; i < dropdown_content.length; ++i)
      dropdown_content[i].style.display = "none";

    return;
  }

  for (var i = 0; i < dropdown.length; ++i) {
    if (event.target == dropdown[i]) {
      return;
    }
  }

  for (var i = 0; i < dropdown_content.length; ++i) {
    if (event.target == dropdown_content[i])
      return;

    var input = dropdown_content[i].getElementsByTagName("input");
    for (var j = 0; j < input.length; j++) {
      if (event.target == input[j])
        return;
    }

    var li = dropdown_content[i].getElementsByTagName("li");
    for (var j = 0; j < li.length; j++) {
      if (event.target == li[j])
        return;
    }

    var span = dropdown_content[i].getElementsByTagName("span");
    for (var j = 0; j < span.length; j++) {
      if (event.target == span[j])
        return;
    }
  }

  for (var i = 0; i < dropdown_content.length; ++i)
    dropdown_content[i].style.display = "none";
}

function drop_down(arg)
{
  var dropdown_content = arg.getElementsByClassName("dropdown_content");

  for (var i = 0; i < dropdown_content.length; ++i)
    dropdown_content[i].style.display = "block";
}

function dropdown_update(input, attribname) {
  var li = input.parentNode;
  var ul = li.parentNode;
  var dropdown = ul.parentNode;
  var dropbtn = dropdown.getElementsByClassName("dropbtn")[0];
  var span, item = li.querySelector('input[name="hidden_id[]"]').value;
  var style = "background-color: #fff; padding: 4px; box-shadow: 0 0 10px rgba(0,0,0,0.1); transform: 0.2s;";

  var c = dropbtn.getElementsByTagName('span')[0].innerHTML == "" ? 0 : 
      parseInt(dropbtn.getElementsByTagName('span')[0].innerHTML);

  var inlist = document.createElement("input");
  inlist.setAttribute("type", "hidden");
  inlist.setAttribute("name", attribname);
  inlist.setAttribute("value", item);

  if (input.checked) {
    li.appendChild(inlist);
    ++c;
  }
  else {
    var rminput = document.getElementsByName(attribname);
    for (var i = 0; i < rminput.length; i++) {
      if (rminput[i].value == item) {
        rminput[i].remove();
        break;
      }
    }
    --c;
  }

  dropbtn.getElementsByTagName('span')[0].innerHTML = c;
}