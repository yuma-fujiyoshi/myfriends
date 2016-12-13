<?php
// 友達の名前を取得し表示
$dsn='mysql:dbname=myfriends;host=localhost';
$user='root';
$password='';
$dbh=new PDO($dsn,$user,$password);
$dbh->query('SET NAMES utf8');

// 名前表示
$sql='SELECT `friend_name`,`area_id`,`friend_id` FROM `friends` WHERE `friend_id`=?';
$data[]=$_GET['friend_id'];
$stmt=$dbh->prepare($sql);
$stmt->execute($data);


$rec=$stmt->fetch(PDO::FETCH_ASSOC);


// 都道府県表示
$sql='SELECT * FROM `areas`';
$stmt=$dbh->prepare($sql);
$stmt->execute();

$areas=array();

while(1){
  $reco=$stmt->fetch(PDO::FETCH_ASSOC);
  if($reco==false){
    break;
  }
  $areas[]=$reco;
}


// 性別表示
$sql='SELECT `gender`,`age` FROM `friends` WHERE `friend_id`=?';
$data2[]=$_GET['friend_id'];
$stmt=$dbh->prepare($sql);
$stmt->execute($data2);

$record=$stmt->fetch(PDO::FETCH_ASSOC);



// // // 更新処理

  

if(isset($_POST) && !empty($_POST)){
  $sql='UPDATE `friends` SET `friend_name`=?,`area_id`=?,`gender`=?,`age`=? WHERE `friend_id`=?';

  var_dump($_POST);

  $data3[]=$_POST['name'];
  $data3[]=$_POST['area_id'];
  $data3[]=$_POST['gender'];
  $data3[]=$_POST['age'];
  $data3[]=$_POST['friend_id'];

  

  $stmt=$dbh->prepare($sql);
  $stmt->execute($data3);

  header('Location: index.php');  

}


  


  // SQL実行
 $dbh=null;
?>





<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>myFriends</title>

    <!-- Bootstrap -->
    <link href="../assets/css/bootstrap.css" rel="stylesheet">
    <link href="../assets/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="../assets/css/form.css" rel="stylesheet">
    <link href="../assets/css/timeline.css" rel="stylesheet">
    <link href="../assets/css/main.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
  <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header page-scroll">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="index.php"><span class="strong-title"><i class="fa fa-facebook-square"></i> My friends</span></a>
          </div>
          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav navbar-right">
              </ul>
          </div>
          <!-- /.navbar-collapse -->
      </div>
      <!-- /.container-fluid -->
   </nav>

  

  <div class="container">
    <div class="row">
      <div class="col-md-4 content-margin-top">
        <legend>友達の編集</legend>
        <form method="POST" action="" class="form-horizontal" role="form">
          <input type="hidden" name='friend_id' value='<?php echo $rec['friend_id']; ?>'>
            <!-- 名前 -->
            <div class="form-group">
              <label class="col-sm-2 control-label">名前</label>
              <div class="col-sm-10">
                <input type="text" name="name" class="form-control" placeholder="山田太郎" value='<?php echo $rec['friend_name']; ?>'>
              </div>
            </div>
            <!-- 出身 -->
            <div class="form-group">
              <label class="col-sm-2 control-label">出身</label>
              <div class="col-sm-10">

                <select class="form-control" name="area_id">
                      <option value="0">出身地を選択</option>
                    <?php foreach($areas as $area): ?>
                      <?php if($area['area_id']==$rec['area_id']){ ?>
                        <option value='<?php echo $area['area_id']; ?>' selected><?php echo $area['area_name']; ?></option>
                      <?php }else{ ?>
                        <option value='<?php echo $area['area_id']; ?>'><?php echo $area['area_name']; ?></option>
                      <?php } ?>
                    <?php endforeach ?>
                </select>
              </div>
            </div>
            <!-- 性別 -->
            <div class="form-group">
              <label class="col-sm-2 control-label">性別</label>
              <div class="col-sm-10">
                <select class="form-control" name="gender">





                    <option value="00">性別を選択</option>
                  <?php if($record['gender']==0){ ?>
                    <option value='<?php echo $record['gender']; ?>' selected>男性</option>
                    <option value='<?php echo $record['gender']; ?>' >女性</option>
                  <?php }else if($record['gender']==1){ ?>
                    <option value='<?php echo $record['gender']; ?>'>男性</option>
                    <option value='<?php echo $record['gender']; ?>' selected >女性</option>
                  <?php }  ?>




                </select>
              </div>
            </div>

            <!-- 年齢 -->
            <div class="form-group">
              <label class="col-sm-2 control-label">年齢</label>
              <div class="col-sm-10">
                <input type="text" name="age" class="form-control" placeholder="例：27" value='<?php echo $record['age']; ?>'>
              </div>
            </div>
          
            <input type="submit" class="btn btn-default" value="更新">

        </form>
      </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
