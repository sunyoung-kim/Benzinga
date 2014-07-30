<script src="benzinga.js"></script>
<?php

$op = $_REQUEST["op"];
$q = $_REQUEST["q"];

switch($op) {
  case "search":
    benzinga_search($q);
    break;
  case "start":
    benzinga_portfolio();
    break;
  case "cookie":
    benzinga_cookie($q);
    break;
  case "view":
    benzinga_view($q);
  default:
    break;
}


function benzinga_search($q) {
  $output = '<h3>The stock \'' . $q . '\' was not found.</h3>';
  
  if($data=file_get_contents("http://data.benzinga.com/stock/".$q)) {
    if($json=json_decode($data,true)) {
      if(!isset($json['status'])) {
        $price = (isset($json['price'])) ? $json['price'] : 0;
        $sector = (isset($json['sector'])) ? $json['sector'] : '';
        
        $output = '<h3>' . $sector . '</h3>';
        $output .= '<table class="table table-striped">';
        $output .= '<thead><tr><th>Bid</th><th>Ask</th></tr></thead>';
        $output .= '<tbody><tr><td>' .((isset($json['bid'])) ? number_format($json['bid'], 2, '.', ',') : ''). '</td>';
        $output .= '<td>' .((isset($json['ask'])) ? number_format($json['ask'], 2, '.', ',') : ''). '</td></tr>';
        $output .= '<tr class="text-right">';
        $output .= '<td colspan="2"><input type="textfield" id="quantity" placeholder="Quantity" />';
        //$output .= '<button type="submit" class="btn btn-info" id="buy" onclick="loadData(\'buy\',document.getElementById(\'quantity\').value,\'right\',\''.$q.'\')">Buy</button>';
        //$output .= '<button type="submit" class="btn btn-info" id="sell" onclick="loadData(\'sell\',document.getElementById(\'quantity\').value,\'right\',\''.$q.'\')">Sell</button></td>';
        $output .= '<button type="submit" class="btn btn-info" id="buy" onclick="update(\'buy\',\''.$sector.'\','.$price.',document.getElementById(\'quantity\').value,\''.$q.'\')">Buy</button>';
        $output .= '<button type="submit" class="btn btn-info" id="sell" onclick="update(\'sell\',\''.$sector.'\','.$price.',document.getElementById(\'quantity\').value,\''.$q.'\')">Sell</button></td>';
        $output .= '</tr>';
        $output .= '</tbody>';
        $output .= '</table>';
      }
    }
  }
  print $output;
}

function benzinga_portfolio($op=null, $q=null, $s=null) {
  
  print '<h3>Current Portfolio</h3>';
  benzinga_cookie();
  
  $output = '<table id="protfolio" class="table table-striped">';
  $output .= '<thead><tr><th>Company</th><th>Qunatity</th><th>Price Paid</th><th></th></tr></thead>';
  $output .= '</table>';
    
  print $output;
}

function benzinga_cookie($price=null) {
  $cookie_name = 'benzinga-cash';
  
  if(!isset($_COOKIE[$cookie_name])) {
    $value = array('value' => 100000.00);
    setcookie($cookie_name, serialize($value));
  } else {
    $value = unserialize($_COOKIE[$cookie_name]);
    if($price) {
      $newValue = $value+$price;
      $value = array('value' => ($newValue));
      setcookie($cookie_name, serialize($value)); 
    }
  }
  print '<p id="container-value" class="text-right">$'.number_format($value['value'], 2, '.', ',').'</p>';
}

function benzinga_add_stock($stock) {
  print $stock;
}

function benzinga_view($q) {
  $output = '<div class="view_stock">';
  $output .= '<button type="submit" class="btn btn-warning float-right" onclick="loadData(\'close\', null,\'view_stock\')">X</button>';
  if($data=file_get_contents("http://data.benzinga.com/stock/".$q)) {
    if($json=json_decode($data,true)) {
      if(!isset($json['status'])) {
        foreach($json as $key=>$value) {
          $output .= '<p>'.$key.': '.$value.'</p>';
        }
      }
    }
  }
  $output .= '</div>';
  print $output;
}

?>