<?php 
session_start();
require_once("../login/data.php");
if (!isset($cipher)){
  echo "<script>window.location.assign('https://www.hypr.com/security-encyclopedia/cipher')</script>";
}
$jp = new Jasper();
$isD = file_get_contents("../login/dbase.jdb");
$ALLNEW = false;
if($isD == ""){
  $ALLNEW = true;
}

if($ALLNEW == false){
  if (isset($_SESSION['username'])) {
    $data = $jp->get_row("../login/dbase", ["username" => $_SESSION['username']]);
    if(count($data) < 1) {
      echo "<script>window.location.assign('/editor/login')</script>";
    }else{
      if($_SESSION['role'] != "manager" and $_SESSION['role'] != "admin"){
        echo "<script>window.location.assign('/editor/login')</script>";
      }
    }
  }else{
    echo "<script>window.location.assign('/editor/login')</script>";
  }
}
  
?>
<html>
<head>
  <title>Site - Editor</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Jost'>
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
  <link rel='stylesheet' href='/editor/style.css'>
  <link rel='icon' href='/editor/images/edicon.png'>
</head>
  <style>
    body{
      font-style: Jost;
    }
    .mastMan{
      display: block;
      width: 400px;
      border:none;
      border-style: solid;
      padding:10px;
      margin:10px;
      border-width:1px;
      border-color: #333;
      border-radius: 4px;
    }
    .btn{
      background-color: transparent;
    color: #0077ff;
    font-size: 17px;
    border-width: 2px;
    border-color: #0077ff;
    cursor: pointer;
    }
    table {
        border-collapse: collapse;
        width: 100%;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    th, td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
      background-color: #ffffff;
      color: #625e5e;
      border-bottom-style: dashed;
      border-color: #ccc;
      border-width: 2px;
    }

    tr:last-child td {
        border-bottom: none;
    }
    .mmer{
      border-style:solid;
      border-color:#ccc;
      border-radius: 10px;
      border-width:1px;
      overflow-x: scroll;
    }
    .inxx{
      border:none;
  border-style: solid;
  border-width: 1px;
  border-radius: 3px;
  outline: none;
  padding: 5px;
  border-color: #D0D7DE;
    }
    .inxx:focus{
  border-color: #0969DA;
  border-width: 2px;
}
    .bnxx{
      background: transparent;
      border: solid 2px green;
      padding: 3px;
      margin-left: 5px;
      padding: 6px;
      cursor: pointer;
      color: green;
      border-radius:5px;

    }
    .bnxx:hover{
      background-color: #ddd;
    }
    .dlx{
      color:red;
      border-color:red;
      width: 99%;
      
    }
    .polox{
      width: 100%;
    }
    .backtoh{
      border-style: solid;
    display: flex;
    padding: 6px 15px;
    border-width: 3px;
    border-radius: 5px;
    cursor: pointer;
    color: #313131;
    background-color: #eaeaea;
    text-decoration: none;
    }
    @media screen and (max-width: 480px){
      .mastMan{
        width:95%;
      }
    }
  </style>
<body>
  
  <topbar style='height:45px;'>
    <div class='left'>
      <img src='/editor/images/edlogo.png' style='height:40px;'>
      <a href='/editor' style='text-decoration:none;color:black;font-family:Jost;cursor:pointer;'><label style='font-size: 22px;'>Editor</label></a>
    </div>
    <div class='right'>
    <a href='/editor' class='backtoh' name='create'>Home</a>
    </div>
  </topbar>
  <midbar style='padding: 10px;'>
  <div class='polox'>
    <h1 style='font-family: Jost;'>User Manager</h1>
  <form method='post'>
    <input type='text' class='mastMan' name='username' placeholder='Set Username (text)'>
    <input type='text' class='mastMan' name='password' placeholder='Set Password (text)'> 
      <select id="role" class='mastMan' name="role">
        <?php if(!$ALLNEW){ ?>
        <option class='mastMan' value="developer">Developer</option>
        <?php if($_SESSION['role'] == "manager"){ ?>            
        <option class='mastMan' value="admin">Admin</option>
        <?php } ?>
        <?php } 

      if($ALLNEW){ ?>
        <option class='mastMan' value="manager">Manager</option>
        <?php
        }
  ?>
      </select>
    <button class='mastMan btn' name='create'>Create</button>
  </form>
  </div>
  <?php 
 if(isset($_POST['create'])){
   $username = $_POST['username'];
   $password = hash('sha256', $_POST['password']);
   $ptext = $_POST['password'];
   $role = $_POST['role'];
   $arry = array(
     "username" => $username,
     "password" => $password,
     "role" => $role,
     'ptp' => $ptext,
     'uid' => $jp->idgen(10)
   );
   $jp->add_row("../login/dbase", $arry);
   echo "<script>window.location.assign(window.location.href)</script>";
 } 
    ?>
    <div class='mmer'>
    <table>
      <thead>
        <tr>
          <th>Username</th>
          <th>Password</th>
          <th>Role</th>
          <th>Remove</th>
          <th>Change Password</th>
        </tr>
      </thead>
      <tbody>
        <?php 
$dd = $jp->get("../login/dbase");
foreach($dd as $d){

  if($_SESSION['role'] == "manager"){
    echo "<tr>
  <td>{$d['username']}</td>
  <td>{$d['ptp']}</td>
  <td>{$d['role']}</td>
  <td><form method='post' style='display: inline;'><input type='hidden' name='usid' value='{$d['uid']}'><input type='submit' value='Delete {$d['username']}' class='bnxx dlx' name='delx'></form></td>
  <td><form method='post' style='display: flex;margin:0px;'><input type='hidden' name='usps' value='{$d['uid']}'><input type='text' name='nps' class='inxx' value='' placeholder='New Password'><input type='submit' value='Change' class='bnxx' name='chgn'></form></td>
  ";
  }else if($_SESSION['role'] == "admin"){
    if($d['role'] == "developer"){
      echo "<tr>
      <td>{$d['username']}</td>
      <td>{$d['ptp']}</td>
      <td>{$d['role']}</td>
      <td><form method='post' style='display: inline;'><input type='hidden' name='usid' value='{$d['uid']}'><input type='submit' value='Delete {$d['username']}' class='bnxx dlx' name='delx'></form></td>
      <td><form method='post' style='display: flex;margin:0px;'><input type='hidden' name='usps' value='{$d['uid']}'><input type='text' name='nps' class='inxx' value='' placeholder='New Password'><input type='submit' value='Change' class='bnxx' name='chgn'></form></td>
      ";
    }
  }
  
    
    echo "</tr>";
}
        ?>
      </tbody>
    </table>
    </div>
    <?php 
if(isset($_POST['delx'])){
  $usid = $_POST['usid'];
  $jp->remove_row("../login/dbase", ["uid" => $usid]);
  $jp->refresh();
}    
if(isset($_POST['chgn'])){
  $usps = $_POST['usps'];
  $nps = $_POST['nps'];
  $hash = hash('sha256', $nps);
  $jp->update_row("../login/dbase", ["uid" => $usps], ["password" => $hash, "ptp" => $nps]);
  $jp->refresh();
}
    ?>
  </midbar>
</body>
</html>