<?php
session_start();
require_once("login/data.php");
if (!isset($cipher)){
  echo "<script>window.location.assign('https://www.hypr.com/security-encyclopedia/cipher')</script>";
}
$jp = new Jasper();
if (isset($_SESSION['username'])) {
  $data = $jp->get_row("login/dbase", ["username" => $_SESSION['username']]);
  if(count($data) < 1) {
    echo "<script>window.location.assign('/editor/login')</script>";
  }
}else{
  echo "<script>window.location.assign('/editor/login')</script>";
}
$retrievedCode = '';
$currentCode = '';
$fileType = '';
$folderPath = '';
$masterPath = "/";
if(isset($_GET['path'])){
  $masterPath = $_GET['path'];
}


function PATH_LINK_VFAC( $currentPath, $basePath = "editor" )
{
    // Split the path into individual segments
    $pathSegments = explode('/', trim($currentPath, '/'));

    // Initialize an empty string to store the anchor tags
    $result = '';
  $result .= "<a href='{$basePath}?path=/'>&#171; <i class='uil uil-estate'></i></a> ";
    // Generate anchor tags for each segment
    $currentPathSoFar = '';
    foreach ($pathSegments as $segment) {
        $currentPathSoFar .= '/' . $segment;
        $result .= "<a href='{$basePath}?path={$currentPathSoFar}'>/ {$segment}</a> ";
    }

    // Remove the trailing slash and extra space
    $result = rtrim($result, ' / ');

    return $result;
}

$extTrans = array(
    'html' => 'html',
    'htm' => 'html',
    'css' => 'css',
    'js' => 'javascript',
    'json' => 'json',
    'xml' => 'xml',
    'php' => 'php',
    'sql' => 'sql',
    'py' => 'python',
    'rb' => 'ruby',
    'java' => 'java',
    'c' => 'c_cpp',
    'cpp' => 'c_cpp',
    'h' => 'c_cpp',
    'hpp' => 'c_cpp',
    'cs' => 'csharp',
    'go' => 'golang',
    'swift' => 'swift',
    'pl' => 'perl',
    'scala' => 'scala',
    'dart' => 'dart',
    'jsx' => 'jsx',
    'tsx' => 'typescript',
    'md' => 'markdown',
);

// Check if 'path' is present in the URL
if (isset($_GET['path'])) {
    // Get the value of 'path' from the URL
    $urlPath = $_GET['path'];

    // Check if the main folder is 'editor'
  if (
      stripos($urlPath, '/editor') !== false
      or stripos($urlPath, '/editor/') !== false
      or stripos($urlPath, 'editor/') !== false
      or stripos($urlPath, '/editLocked') !== false
      or stripos($urlPath, '/editLocked/') !== false
      or stripos($urlPath, 'editLocked/') !== false
      or stripos($urlPath, '.elock.') !== false
    or stripos($urlPath, '/editHide') !== false
    or stripos($urlPath, '/editHide/') !== false
    or stripos($urlPath, 'editHide/') !== false
    or stripos($urlPath, '.ehide.') !== false
  ) {
      // Redirect without 'path' in the URL
      echo "<script>window.location.assign('/editor')</script>";
      exit(); // Terminate script execution after redirection
  }
}else{
  $urlPath = '';
}
    // Construct the full path based on 'path' from the URL
    $fullPath = '../' . $urlPath;

    // Check if 'path' refers to a folder
    if (is_dir($fullPath)) {
        // Get all files and directories in the specified folder
        $allItems = scandir($fullPath);

        // Filter out "." and ".." (current and parent directory)
        $items = array_diff($allItems, array('.', '..'));

        // Separate folders and files
        $folders = [];
        $files = [];

        foreach ($items as $item) {
            // Construct the full path to the item
            $itemPath = $fullPath . '/' . $item;

            
            if (is_dir($itemPath) && strpos($item, '.') !== 0 && strtolower($item) !== 'editor') {
                $folders[] = $item;
            } else {
                
                if (!(strpos($item, '.') === 0 || strtolower($item) === 'editor')) {
                    $files[] = $item;
                }
            }
        }
    } else {
        // If 'path' refers to a file, get file type and contents
      $fllpath = "../".$urlPath;
        $fileType = pathinfo($fllpath, PATHINFO_EXTENSION);
        $retrievedCode = file_get_contents($fllpath);
        
        // Extract the directory from the full path
        $folderPath = dirname($fllpath);
        $allItems = scandir($folderPath);
  
        // Filter out "." and ".." (current and parent directory)
        $items = array_diff($allItems, array('.', '..'));
  
        // Separate folders and files
        $folders = [];
        $files = [];
  
        foreach ($items as $item) {
            // Construct the full path to the item
            $itemPath = $folderPath . '/' . $item;
  
            if (is_dir($itemPath) && strpos($item, '.') !== 0 && strtolower($item) !== 'editor') {
                $folders[] = $item;
            } else {
                
                if (!(strpos($item, '.') === 0 || strtolower($item) === 'editor')) {
                    $files[] = $item;
                }
            }
        }
      
    }


?>

<!DOCTYPE html>
<html>
  <head>
    <title>Site - Editor</title>
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Jost'>
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <link rel='stylesheet' href='/editor/style.css'>
    <link rel='icon' href='/editor/images/edicon.png'>
  </head>
  <body>
    <topbar>
      <div class='left'>
        <img src='/editor/images/edlogo.png' style='height:40px;'>
      </div>
      <div class='right'>
        <form method='post' class='frmx'>
          <?php 
          if(isset($_SESSION['role'])){
            if($_SESSION['role'] == "manager" or $_SESSION['role'] == "admin"){
              echo "<a href='/editor/master' class='othrBtn' >Mange Users</a>";
            }
          }        
                  ?>
        <textarea name='mainCode' id='coderTxt' style='display:none;'></textarea>
        <button class='mainBtn' name='saveCode'>Save To Site</button>
          <button class='mainBtn Lout' name='logout'>Logout</button>
        </form>
            <?php 
        if(isset($_POST['logout'])){
          session_destroy();
          echo "<script>window.location.assign('/editor/login')</script>";
        }
        ?>
      </div>
    </topbar>
    <midbar>
      <leftbar>
        <div class='boxbar'>
          <form method='post' class='frmx'>
            <input name='fname' placeholder='Name for...' class='newInp' required>
          <button class='newBtn' name='crtFile'><i class="uil uil-file-plus"></i></button>         
          <button class='newBtn' name='crtFolder'><i class="uil uil-folder-plus"></i></button>
          </form>
        </div>
        <div class='scrolbax'>
          <?php 
          if(isset($_POST['crtFolder'])){
            if(is_file("..".$urlPath)){
              $crfIlePath = "..".dirname($urlPath)."/".$_POST['fname'];
            }else{
              $crfIlePath = "..".$urlPath."/".$_POST['fname'];
            }
            if (!file_exists($crfIlePath)) {
                if (mkdir($crfIlePath)) {
                    echo "Folder created successfully: $crfIlePath";
                } else {
                    echo "Error creating folder: $crfIlePath";
                }
            } else {
                echo "Folder already exists: $crfIlePath";
            }
            echo "<script>window.location.assign(window.location.href)</script>";
          }
          
          if (isset($_POST['crtFile'])) {
              $fileName = $_POST['fname'];
              $UFX = "";
              if (is_file("..".$urlPath)){
                $UFX = dirname($urlPath);
              }else{
                $UFX = $urlPath;
              }
              $filePath = ".." . $UFX . "/" . $fileName;
              

              if (!file_exists($filePath)) {
                  $fileHandle = fopen($filePath, 'w'); // 'w' mode opens the file for writing
                  if ($fileHandle !== false) {
                      fclose($fileHandle);
                      echo "File created successfully: $filePath";
                  } else {
                      echo "Error creating file: $filePath";
                  }
              } else {
                  echo "File already exists: $filePath";
              }

              echo "<script>window.location.assign(window.location.href)</script>";
          }
          ?>
            
        <?php     
          echo "<a href='/editor?path=".dirname($urlPath)."' class='itemurl'><i class='uil uil-corner-up-left-alt'></i>&nbsp../</a>";
foreach($folders as $folder){

  if(is_dir("../".$urlPath)){
    if($folder == "editLocked"){
      echo "<a href='/editor?path=$urlPath/$folder' class='itemurl disabled-link'><i class='uil uil-folder-lock'></i>&nbsp;$folder</a>";
    }else if($folder == "editHide"){}else{
      echo "<a href='/editor?path=$urlPath/$folder' class='itemurl'><i class='uil uil-folder'></i>&nbsp;$folder</a>";
    }
    
  }
  else if(is_file("../".$urlPath)){
    $urlF = dirname($urlPath);
    if($folder == "editLocked"){
      echo "<a href='/editor?path=$urlF/$folder' class='itemurl disabled-link'><i class='uil uil-folder-lock'></i>&nbsp;$folder</a>";
    }else if($folder == "editHide"){}else{
      echo "<a href='/editor?path=$urlF/$folder' class='itemurl'><i class='uil uil-folder'></i>&nbsp;$folder</a>";
  }
  }
}  

foreach($files as $file){
  if(is_dir("../".$urlPath)){
    if(dirname($urlPath)."/$file" == "$urlPath"){
      if(strpos($file, '.elock.') !== false){
        echo "<a href='/editor?path=$urlPath/$file' class='itemurl activefile disabled-link'><i class='uil uil-file-lock-alt'></i>&nbsp;$file</a>";
      }else if(strpos($file, '.ehide.') !== false){}else{
        echo "<a href='/editor?path=$urlPath/$file' class='itemurl activefile'><i class='uil uil-file'></i>&nbsp;$file</a>";
      }
    }else{
      if(strpos($file, '.elock.') !== false){
        echo "<a href='/editor?path=$urlPath/$file' class='itemurl  disabled-link'><i class='uil uil-file-lock-alt'></i>&nbsp;$file</a>";
      }else if(strpos($file, '.ehide.') !== false){}else{
        echo "<a href='/editor?path=$urlPath/$file' class='itemurl '><i class='uil uil-file'></i>&nbsp;$file</a>";
      }
  }
  }
  else if(is_file("../".$urlPath)){
    if(dirname($urlPath)."/$file" == "$urlPath"){
      $urlF = dirname($urlPath);
      if(strpos($file, '.elock.') !== false){
         echo "<a href='/editor?path=$urlF/$file' class='itemurl activefile disabled-link'><i class='uil uil-file-lock-alt'></i>&nbsp;$file</a>";
      }else if(strpos($file, '.ehide.') !== false){}else{
         echo "<a href='/editor?path=$urlF/$file' class='itemurl activefile'><i class='uil uil-file'></i>&nbsp;$file</a>";
      }
     
    }else{
      $urlF = dirname($urlPath);
      if(strpos($file, '.elock.') !== false){
        echo "<a href='/editor?path=$urlF/$file' class='itemurl disabled-link'><i class='uil uil-file-lock-alt'></i>&nbsp;$file</a>";
      }
      else if(strpos($file, '.ehide.') !== false){}
      else{
        echo "<a href='/editor?path=$urlF/$file' class='itemurl'><i class='uil uil-file'></i>&nbsp;$file</a>";
      }
      
  }
  
  }
}
        
        ?>
        </div>
      </leftbar>
      <rightbar>
        <div class='statusbox'>
          <label class='stts' id='stats'>Un-Edited File</label>
          <label class='ptts' id='stats'><?php echo PATH_LINK_VFAC($masterPath); ?></label>

        </div>
        <div class='mainbx'>
        <?php 
  if($fileType == ""){
    echo "<label style='padding:10px;'>No File is Selected</label>";
  }else{
    ?>
    <div id="editor" class='edsx'><?php echo htmlentities($retrievedCode);?></div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.32.2/ace.js" integrity="sha512-JLIRlxWh96sND3uUgI2RVHZJpgkWHg3+xoUY8XkgTPKpqRaqdk7zD/ck/XHXFSMW84o6GrP67dlqN3b98NB/yA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
      
        var editor = ace.edit("editor"); 
      editor.setTheme('ace/theme/dawn');

      <?php if(isset($extTrans[$fileType])){ ?>
        editor.session.setMode("ace/mode/<?php echo $extTrans[$fileType]; ?>");
      <?php }else{ ?>   
        editor.session.setMode("ace/mode/text");
      <?php }?>   
      editor.getSession().on('change', function () {
          document.getElementById('coderTxt').value = editor.getSession().getValue();
        document.getElementById('stats').innerText = 'Changes Un-Saved';
      });
    </script>
    <?php
  }
        ?>
        </div>
        <?php 
if(isset($_POST['saveCode'])){
  if($_POST['mainCode'] !== ""){
    file_put_contents("../".$urlPath, $_POST['mainCode']);
    $filename = $_SERVER['HTTP_HOST'] . '-' . $urlPath . '-[UTC-' . gmdate('Y-m-d H:i:s') . '].bkup.txt';

    $base64Content = base64_encode($retrievedCode);
    $dataUri = "data:text/plain;base64," . $base64Content;

    echo "<script>
        var link = document.createElement('a');
        link.href = '$dataUri';
        link.download = '$filename';
        link.click();
    </script>";
    echo "<script>window.location.assign(window.location.href)</script>";
  }
}   
        ?>
      </rightbar>
    </midbar>
  </body>
</html>
