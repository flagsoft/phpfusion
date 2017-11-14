//
//
//


function PF_show_div(element)
{
    var status = document.getElementById(element).style.display;
    if(status == "none") {
        document.getElementById(element).style.display = "block";
    } else {
        document.getElementById(element).style.display = "none";
    }
}


// status: works
function check_all_in_document(doc)
{
  var c = new Array();
  c = doc.getElementsByTagName('input');
  for (var i = 0; i < c.length; i++)
  {
    if (c[i].type == 'checkbox')
    {
      c[i].checked = true;
    }
  }
}

// status: works
function uncheck_all_in_document(doc)
{
  var c = new Array();
  c = doc.getElementsByTagName('input');
  for (var i = 0; i < c.length; i++)
  {
    if (c[i].type == 'checkbox')
    {
      c[i].checked = false;
    }
  }
}

function checkem()
{
  check_all_in_document(window.document);
  for (var j = 0; j < window.frames.length; j++)
  {
    check_all_in_document(window.frames[j].document);
  }
}



function checkAll(field)
{
    for (i = 0; i < field.length; i++)
	field[i].checked = true ;
}

function uncheckAll(field)
{
    for (i = 0; i < field.length; i++)
	field[i].checked = false ;
}


function PF_util_check() {    
    //alert("PF_util_check");

count = 0;
str = '';
    for(x=0; x<document.form1.elements["checkbox[]"].length; x++){
        if(document.form1.elements["checkbox[]"][x].checked==TRUE){
            str += document.form1.elements["checkbox[]"][x].value + ',';
            count++;
        }
    }
 
    if(count==0){
        alert("You must choose at least 1");
        return false;
    }
    else if(count>3){
        alert("You can choose a maximum of 3");
        return false;
    }
    else {
    alert("You chose " + count + ": " + str.substring(0,str.length-1));
    document.form1.submit();
    }

    return false;
}

// EOF.
