<?php
error_reporting(0);
session_start();
$login = false;
if (!empty($_GET['logout'])) {
  unset($_SESSION['login']);
}
if (isset($_POST['user']) && isset($_POST['password'])) {
  if ($_POST['user'] == 'admin' && $_POST['password'] == 'admin123') {
    setcookie('user', $_POST['user'], 0);
    $_SESSION['login'] = true;
  }
}
if (!empty($_SESSION['login'])) {
  $login = true;
}
$dir = "uploads/";
$list = array();

if (isset($_FILES['file'])) {
  $file = $dir . basename($_FILES["file"]["name"]);
  $uploadOk    = 1;
  if (file_exists($file)) {
    echo '<script type="text/javascript">
    alert("Sorry, file already exists.");
    </script>';
    $uploadOk = 0;
  }
  if ($uploadOk == 0) {
    echo '<script type="text/javascript">
    alert("Sorry, your file was not uploaded.");
    </script>';
  } else {
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $file)) {
      echo '<script type="text/javascript">
      alert("' . basename($_FILES["file"]["name"]) . ' has been uploaded.");
      </script>';
    } else {
      echo '<script type="text/javascript">
    alert("Sorry, there was an error uploading your file.");
    </script>';
    }
  }
} else if (!empty($_POST['mkdir'])) {
  $newdir = $dir . $_POST['mkdir'];
  echo '<script type="text/javascript">
  alert("Directory '.$_POST['mkdir'].',success created.");
  </script>';
  if (!file_exists($newdir)) {
    mkdir($newdir, 0777);
  }
} else if (isset($_GET['delete'])) {
  $file = $_GET['delete'];
  if (is_dir($dir . $file)) {
    rmdir($dir . $file);
    echo '<script type="text/javascript">
    alert("Directory '.$file.',already deleted.");
    </script>';
  } else {
    unlink($dir . $file);
    echo '<script type="text/javascript">
    alert("File '.$file.',already deleted.");
    </script>';
  }
}

function human_filesize($bytes, $decimals = 2)
{
  $sz = 'BKMGTP';
  $factor = floor((strlen($bytes) - 1) / 3);
  return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
}
function get_size($f, $d_type)
{
  if ($d_type == 'folder') return;

  return human_filesize(filesize($dir . $f));
}

$list = scandir($dir);
$list = array_diff($list, array(
  '.',
  '..'
));
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Manajemen File</title>

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/scrolling-nav.css" rel="stylesheet">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>

<body id="page-top">

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <div class="container">
      <a class="navbar-brand js-scroll-trigger" href="index.php">File Manager</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
    </div>
  </nav>

  <section id="main">
    <div class="container">
      <?php if ($login) {?>
      <div class="row">
        <div class="col-lg-12 mx-auto">
          <form id="file-uploads" action="" method="POST" style="display: inline-block;" enctype="multipart/form-data">
            <button type="button" class="btn btn-primary" id="btn-uploads" style="position: relative; overflow: hidden;">
              <i class="fa fa-cloud-upload"></i> Uploads
              <input style="position: absolute; opacity: 0; right: 0; top: 0; font-size: 50px;" type="file" name="file">
            </button>
          </form>
          <button type="button" class="btn btn-primary" id="btn-create-directory" style="position: relative; overflow: hidden;">
            <i class="fa fa-folder"></i> Create Directory
          </button>          
          <button type="button" class="btn btn-danger" id="btn-cancel-directory" style="display: none;">Cancel</button>
          <a href="index.php?logout=ya" style="float:right;"class="btn btn-danger">Exit</a><br>
          <form style="height:auto; width:80%; display:none; font-size : 12pt;" id="form-directory" action="" method="POST" style="">
            <br>
            <div class="form-row">
              <div class="col">
                <input type="text" name="mkdir" class="form-control" placeholder="Directory Name">
              </div>
              <button type="submit" class="btn btn-primary"> Create</button>
            </div>
          </form>
          <br>
          <br>
          <table class="table">
            <thead class="thead-dark">
              <tr>
                <th scope="col">Name</th>
                <th scope="col">Size</th>
                <th scope="col">Modified</th>
                <th scope="col">Type</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $counter = 0;
              foreach ($list as $files) {
                ?>
                <tr>
                  <th scope="row"><?php
                                  echo $files;
                                  ?></th>
                  <td><?php
                      echo get_size($dir . $files, is_dir($dir . $files) ? 'folder' : 'file');
                      ?></td>
                  <td><?php
                      echo date("F d, Y H:i:s", filemtime($dir . $files));
                      ?>
                  </td>
                  <td><?php
                      echo is_dir($dir . $files) ? 'folder' : 'file';
                      ?></td>
                  <td><a href="?delete=<?php
                                        echo $files;
                                        ?>">Delete</a></td>
                </tr>
              <?php

            }
            ?>


            </tbody>
          </table>
          <?php

        
          ?>
        </div>
      </div>
    </div>
    <?php } else { ?>
        <h3>Masuk</h3>
        <form action="" method="post">
          <label for="user">Username</label>
          <input type="text" class="form-control" name="user" id="user" value="<?php if (!empty($_COOKIE['user'])) {
                                                echo $_COOKIE['user'];
                                              } ?>"> <br />
          <label for="password">Password</label>
          <input type="password" class="form-control" name="password" id="password"> <br />
          <input type="submit" class="btn btn-primary" value="Kirim">
        </form>
      <?php } ?>
    </div>
  </section>

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Plugin JavaScript -->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom JavaScript for this theme -->
  <script src="js/scrolling-nav.js"></script>
  <script>
    $(document).ready(function() {
      $('input[name="file"]').on('change', function() {
        $('#file-uploads').submit();
      })
      $("#btn-create-directory").click(function() {
        $("#form-directory").slideDown();

        $("#btn-create-directory").attr('disabled', true);
        $("#btn-uploads").attr('disabled', true);
        $("#btn-cancel-directory").show();
      });

      $("#btn-cancel-directory").click(function() {
        $("#form-directory").slideUp();

        $("#btn-create-directory").attr('disabled', false);
        $("#btn-uploads").attr('disabled', false);
        $("#btn-cancel-directory").hide();
      });
    });
  </script>
</body>

</html>