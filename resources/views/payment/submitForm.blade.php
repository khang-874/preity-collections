<html> 
<head> 
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"> 
    <title>Hosted Payment Page Demo</title> 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> 
    <script> 
        window.onload = function(){
            document.getElementById('submitForm').submit();
        } 
    </script> 
</head> 

<body> 
    <form action="https://api.demo.convergepay.com/hosted-payments/" method="POST" enctype="application/x-www-form-urlencoded" id="submitForm"> 
        @csrf
        <input id="ssl_txn_auth_token" type="hidden" name="ssl_txn_auth_token" value="{{$token}}"size="25"></font></td> 
    </form> 
</body> 
</html>