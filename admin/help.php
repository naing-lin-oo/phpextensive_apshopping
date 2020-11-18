<?php

session_start();
require '../config/config.php';
require '../config/common.php';


if (empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
  header('Location: login.php');
}

if($_SESSION['role'] != 1) {
  header('Location: login.php');
}

if ($_POST) {
  if(empty($_POST['title']) || empty($_POST['content']) || empty($_FILES['image'])) {
    if(empty($_POST['title'])) {
      $titleError = 'Title cannot be null';
    }
    if(empty($_POST['content'])) {
      $contentError = 'Content cannot be null';
    }
    if(empty($_FILES['image'])) {
      $imageError = 'Image cannot be null';
    }
  } else {
    $file = 'images/'.($_FILES['image']['name']);
    $imageType = pathinfo($file,PATHINFO_EXTENSION);
    if ($imageType!='png' && $imageType!='jpg' && $imageType!='jpeg') {
      echo "<script>alert('Image must be image type')</script>";
    }else {
      $title = $_POST['title'];
      $content = $_POST['content'];
      $image = $_FILES['image']['name'];
      move_uploaded_file($_FILES['image']['tmp_name'],$file);
      $pdostmt = $pdo-> prepare("INSERT INTO posts(title,content,author_id,image) VALUES (:title,:content,:author_id,:image)");
      $result = $pdostmt->execute(
        array(
          ':title'=>$title,':content'=>$content,':author_id'=>$_SESSION['user_id'],':image'=>$image
        )
      );
      if ($result) {
        echo "<script>alert('New Record is added');window.location.href='index.php';</script>";
      }
    }
  }
}

?>

<?php
include('header.php');
?>

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <form class="" action="" method="post" enctype="multipart/form-data">
                  <input name="_token" type="hidden" value="<?php echo $_SESSION['_token']; ?>">
                  <div class="form-group">
                    <label for="">Title</label><p style="color: red;"><?php echo empty($titleError)? '': '*'.$titleError ; ?></p>
                    <input type="text" class="form-control" name="title" value="" >
                  </div>
                  <div class="form-group">
                    <label for="">Content</label><p style="color: red;"><?php echo empty($contentError)? '': '*'.$contentError ; ?></p>
                    <textarea class="form-control" name="content" rows="8" cols="80"></textarea>
                  </div>
                  <div class="form-group">
                    <label for="">Image</label><br><p style="color: red;"><?php echo empty($imageError)? '': '*'.$imageError ; ?></p>
                    <input type="file" name="image" value="" >
                  </div>
                  <div class="form-group">
                    <input type="submit" class="btn btn-outline-success" name="" value="Create">
                    <a type="button" class="btn btn-outline-warning" href="index.php">Back</a>
                  </div>
                </form>
              </div>
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col-md -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  
-------

<?php

require '../config/config.php';
require '../config/common.php';

session_start();

if (empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
  header('Location: login.php');
}    

if ($_POST) {
    if(empty($_POST['name']) || empty($_POST['description'])) {
      if(empty($_POST['name'])) {
        $nameError = 'Category name cannot be null';
      }
      if(empty($_POST['description'])) {
        $descriptionError = 'Description cannot be null';
      }
    } else {
        $name           = $_POST['name'];
        $description    = $_POST['description'];

        $stmt = $pdo->prepare("INSERT INTO categories(name, description) VALUES(:name, :description)");
        $result = $stmt->execute(
            array(':name'=>$name, ':description'=>$description)
        );
        if($result){
            echo "<script>alert('Successfully Category Added');window.location.href='category.php';</script>";
        }
    }
}
?>
<?php include('header.php'); ?>
  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-body">
              <form class="" action="" method="post">
              <input name="_token" type="hidden" value="<?php echo $_SESSION['_token']; ?>">
                <div class="form-group">
                  <label for="">Name</label><p style="color: red;"><?php echo empty($nameError)? '': '*'.$nameError ; ?></p>
                  <input type="text" class="form-control" name="name" value="">
                </div>
                <div class="form-group">
                  <label for="">Description</label><p style="color: red;"><?php echo empty($descriptionError)? '': '*'.$descriptionError ; ?></p>
                  <input type="text" class="form-control" name="description" value="" >
                </div>
                <div class="form-group">
                  <input type="submit" class="btn btn-outline-success" name="" value="Create">
                  <a type="button" class="btn btn-outline-warning" href="category.php">Back</a>
                </div>
              </form>
            </div>
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col-md -->
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content -->