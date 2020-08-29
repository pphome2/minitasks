<script>

// for docs

function cardopenclose(th){
	//var x=document.getElementById(th);
	//var x=th.parentElement.parentElement.childNodes[2];
	if (th.style.display=='none'){
		th.style.display='block'
	} else {
		th.style.display='none'
	}
}

//Tab function for administration

function opentab(evt, tabName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(tabName).style.display = "block";
    //document.getElementById(tabName).className += " active";
    evt.currentTarget.className += " active";
}


// filter table

function tfilter(inname,ind) {
  var input, sfilter, table, tr, td, i;
  input = document.getElementById(inname);
  sfilter = input.value.toUpperCase();
  table = document.getElementById("tasktable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[ind];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(sfilter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}


setTimeout(function () { window.location.href = "<?php echo($MT_ADMINFILE.'?'.$MT_STYLEPARAM_NAME.'='.$styleindex); ?>"; }, <?php echo((($LOGIN_TIMEOUT+1)*1000)); ?>);

</script>
