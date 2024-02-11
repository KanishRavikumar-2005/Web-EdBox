<?php 
session_start();
require_once("data.php");
if (!isset($cipher)){
  echo "<script>window.location.assign('https://www.hypr.com/security-encyclopedia/cipher')</script>";
}
$jp = new Jasper();
$per = filesize("dbase.jdb");
if( $per == 0){
  echo "<script>window.location.assign('/editor/master')</script>";
}
?>
<html>
  <head>
    <link rel="stylesheet" href='/editor/style.css'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editor - Login</title>
    <link rel='icon' href='/editor/images/edicon.png'>
  </head>
  <style>
    @font-face {
      font-family: 'Open Sans';
      font-style: normal;
      font-weight: 300;
      font-stretch: normal;
      src: url(https://fonts.gstatic.com/s/opensans/v40/memSYaGs126MiZpBA-UvWbX2vVnXBbObj2OVZyOOSr4dVJWUgsiH0B4gaVc.ttf) format('truetype');
    }
    @font-face {
      font-family: 'Open Sans';
      font-style: normal;
      font-weight: 400;
      font-stretch: normal;
      src: url(https://fonts.gstatic.com/s/opensans/v40/memSYaGs126MiZpBA-UvWbX2vVnXBbObj2OVZyOOSr4dVJWUgsjZ0B4gaVc.ttf) format('truetype');
    }
    @font-face {
      font-family: 'Open Sans';
      font-style: normal;
      font-weight: 600;
      font-stretch: normal;
      src: url(https://fonts.gstatic.com/s/opensans/v40/memSYaGs126MiZpBA-UvWbX2vVnXBbObj2OVZyOOSr4dVJWUgsgH1x4gaVc.ttf) format('truetype');
    }
    @font-face {
      font-family: 'Open Sans Condensed';
      font-style: normal;
      font-weight: 300;
      src: url(https://fonts.gstatic.com/s/opensanscondensed/v23/z7NFdQDnbTkabZAIOl9il_O6KJj73e7Ff1GhDuXMQg.ttf) format('truetype');
    }
    @font-face {
      font-family: 'Open Sans Condensed';
      font-style: normal;
      font-weight: 700;
      src: url(https://fonts.gstatic.com/s/opensanscondensed/v23/z7NFdQDnbTkabZAIOl9il_O6KJj73e7Ff0GmDuXMQg.ttf) format('truetype');
    }
    * {
      box-sizing: border-box;
    }
    body {
      font-family: 'open sans', helvetica, arial, sans;
      background: url(http://farm8.staticflickr.com/7064/6858179818_5d652f531c_h.jpg) no-repeat center center fixed;
      -webkit-background-size: cover;
      -moz-background-size: cover;
      -o-background-size: cover;
      background-size: cover;
    }
    .log-form {
      width: 40%;
      min-width: 320px;
      max-width: 475px;
      background: #fff;
      position: absolute;
      top: 50%;
      left: 50%;
      -webkit-transform: translate(-50%, -50%);
      -moz-transform: translate(-50%, -50%);
      -o-transform: translate(-50%, -50%);
      -ms-transform: translate(-50%, -50%);
      transform: translate(-50%, -50%);
      box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.25);
    }
    @media (max-width: 40em) {
      .log-form {
        width: 95%;
        position: relative;
        margin: 2.5% auto 0 auto;
        left: 0%;
        -webkit-transform: translate(0%, 0%);
        -moz-transform: translate(0%, 0%);
        -o-transform: translate(0%, 0%);
        -ms-transform: translate(0%, 0%);
        transform: translate(0%, 0%);
      }
    }
    .log-form form {
      display: block;
      width: 100%;
      padding: 2em;
    }
    .log-form h2 {
      color: #5d5d5d;
      font-family: 'open sans condensed';
      font-size: 1.35em;
      display: block;
      background: #2a2a2a;
      width: 100%;
      text-transform: uppercase;
      padding: 0.75em 1em 0.75em 1.5em;
      box-shadow: inset 0px 1px 1px rgba(255, 255, 255, 0.05);
      border: 1px solid #1d1d1d;
      margin: 0;
      font-weight: 200;
    }
    .log-form input {
      display: block;
      margin: auto auto;
      width: 100%;
      margin-bottom: 2em;
      padding: 0.5em 0;
      border: none;
      border-bottom: 1px solid #eaeaea;
      padding-bottom: 1.25em;
      color: #757575;
    }
    .log-form input:focus {
      outline: none;
    }
    .log-form .btn {
      display: inline-block;
      background: #1fb5bf;
      border: 1px solid #1ba0a9;
      border-radius: 5px;
      padding: 0.5em 2em;
      color: white;
      margin-right: 0.5em;
      box-shadow: inset 0px 1px 0px rgba(255, 255, 255, 0.2);
      cursor: pointer;
    }
    .log-form .btn:hover {
      background: #23cad5;
    }
    .log-form .btn:active {
      background: #1fb5bf;
      box-shadow: inset 0px 1px 1px rgba(0, 0, 0, 0.1);
    }
    .log-form .btn:focus {
      outline: none;
    }
    .log-form .forgot {
      color: #33d3de;
      line-height: 0.5em;
      position: relative;
      top: 2.5em;
      text-decoration: none;
      font-size: 0.75em;
      margin: 0;
      padding: 0;
      float: right;
    }
    .log-form .forgot:hover {
      color: #1ba0a9;
    }
    .imgr{
      text-align: center;
      padding-top: 30px;
    }
    .warnn{
      color: red;
      text-decoration: none;
    }
  </style>
  <body>
    <div class="log-form">
      <div class='imgr'>
      <img src='/editor/images/edlogo.png' style='height:80px;text-align:center;'>
      </div>
      <form method='post'>
        <input type="text" name='usn' title="username" placeholder="username" />
        <input type="password" name='psw' title="username" placeholder="password" />
        <button type="submit" class="btn" name='subt'>Login</button>
      </form>
      <?php 
if(isset($_POST['subt'])){
  $name = $_POST['usn'];
  $pass = hash('sha256', $_POST['psw']);
  $data = $jp->get_row("dbase", ["username" => $name, "password" => $pass]);
  if(count($data) > 0){
    $_SESSION['username'] = $name;
    $_SESSION['role'] = $data[0]['role'];
    echo "<script>window.location.assign('/editor')</script>";
  }else{
    echo "<p style='color:red;text-align:center;'>Invalid Username or Password</p>";
  }
}    
      ?>
    </div>
  </body>
</html>
