<!DOCTYPE html>
<head>
  <title>Simple Stock Exchange</title>
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">

  <link rel="stylesheet" href="style.css">
  <script src="benzinga.js"></script>
</head>
<body onload="loadData('start',null,'right')">
  <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
      <header>
        <div class="navbar-header">
          <div class="navbar-title"><h1>Simple Stock Exchange</h1></div>
          <div class="navbar-collapse collapse navbar-form">
            <div class="navbar-form navbar-right">
              <input type="textfield" id="symbol" placeholder="Enter Symbol"></input>
              <button type="submit" class="btn btn-success" onclick="loadData('search',document.getElementById('symbol').value,'left')">Lookup</button>
            </div>
          </div>
        </div>
      </header>
    </div>
  </div>
  <div class="jumbotron">
    <div class="container-header">
    </div>
    <div class="container">
      <div id="container-left">
      </div>
      <div id="container-right">
      </div>
    </div>
  </div>
  <div id="container-view_stock"></div>
</body>
</html>