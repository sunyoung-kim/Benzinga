
function loadData(op,attr,target) {
  var target='container-'+target;
  if(op=='view') {
    document.getElementById(target).style.display="inherit";
  }
  else if(op=='close') {
    document.getElementById(target).style.display="none";
    return;
  }
  if (op.length==0) {
    document.getElementById(target).innerHTML="";
    return;
  }
  var xmlhttp=new XMLHttpRequest();
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById(target).innerHTML=xmlhttp.responseText;
    }
  }
  xmlhttp.open("GET","benzinga.php?op="+op+"&q="+attr,true);
  xmlhttp.send();
}

function update(op,sector,price,qty,stock) {
  if(qty%1!=0 || parseInt(qty)<=0 || isNaN(qty) || qty==null) {
    alert('Quantity should be positive integer');
    return;
  }
  
  var table = document.getElementById("protfolio");
  var row = table.insertRow(1);
  var cell1 = row.insertCell(0);
  var cell2 = row.insertCell(1);
  var cell3 = row.insertCell(2);
  var cell4 = row.insertCell(3);
  
  var cells = table.getElementsByTagName("td");
  for (var i = 0; i < cells.length; i++) {
    if (cells[i].innerHTML == sector) {
      if(op=='buy')
        var newQty = parseInt(cells[i+1].innerHTML) + parseInt(qty);
      else {
        var newQty = parseInt(cells[i+1].innerHTML) - parseInt(qty);
        if(newQty < 0) {
          alert('Quantity error');
          table.deleteRow(1);
          
          return;
        }
      }
      cells[i+1].innerHTML = newQty;
      cells[i+2].innerHTML = (price*newQty).toFixed(2);
      table.deleteRow(1);
      
      return;
    }
  }
  if(op=='buy') {
    cell1.innerHTML = sector;
    cell2.innerHTML = qty;
    cell3.innerHTML = (price*qty).toFixed(2);
    cell4.innerHTML = '<button type="submit" class="btn btn-info" onclick="loadData(\'view\',\''+stock+'\',\'view_stock\')">View Stock</button>';
  }
  else {
    alert('No Stocks to sell');
  }
}

