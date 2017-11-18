<?php

$dsn='データベース名';
$user='ユーザー名';
$password='パスワード';

try{

	$pdo=new PDO($dsn,$user,$password);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		if(isset($_POST["regist"])){

			if($_POST["editnum"]!==""){

				$sql='UPDATE kadai SET name=:name,comment=:comment,date=now(),pass=:pass WHERE id=:id';

				$stmt=$pdo->prepare($sql);

				$stmt->bindParam(":name",$name,PDO::PARAM_STR);
				$stmt->bindParam(":comment",$comment,PDO::PARAM_STR);
				$stmt->bindParam(":pass",$pass,PDO::PARAM_STR);
				$stmt->bindParam(":id",$id,PDO::PARAM_INT);
				
				$name=$_POST["name"];
				$comment=$_POST["comment"];
				$pass=$_POST["password"];
				$id=$_POST["editnum"];
				//ここに指定した番号の中身が、指定したテキストに置き換わる

				$stmt->execute();

				$editnumber="";

			}else{

				$sql='INSERT INTO kadai(name,comment,date,pass) VALUES(:name,:comment,now(),:pass)';

				$stmt=$pdo->prepare($sql);

				$stmt->bindParam(":name",$name,PDO::PARAM_STR);
				$stmt->bindParam(":comment",$comment,PDO::PARAM_STR);
				$stmt->bindParam(":pass",$pass,PDO::PARAM_STR);

				$name=$_POST["name"];
				$comment=$_POST["comment"];
				$pass=$_POST["password"];

				$stmt->execute();
			
			}//投稿ボタン終わり

		}else if(isset($_POST["delete"])){

			$sql='SELECT*FROM kadai';

			$result=$pdo->query($sql);

			foreach($result as $row){

				if($row["id"]==$_POST["deletenumber"]){

					if($row["pass"]=$_POST["deletepass"]){
						
						$sql="DELETE FROM kadai WHERE id=:id";

						$stmt=$pdo->prepare($sql);

						$stmt->bindParam(":id",$id,PDO::PARAM_INT);

						$id=$_POST["deletenumber"];
						//ここに指定した番号が削除される

						$stmt->execute();

					}else{
			
						echo "パスワードが間違っています。\n";
						echo "<hr>";

					}

				}else{
				//何もしない
				}

			}//削除ボタン終わり

		}else if(isset($_POST["edit"])){

			$sql='SELECT*FROM kadai';

			$result=$pdo->query($sql);

			foreach($result as $row){

				if($row["id"]==$_POST["editnumber"]){

					if($row["pass"]=$_POST["editpass"]){

						$editnumber=$row["id"];
						$editname=$row["name"];
						$edittext=$row["comment"];
						$editpass=$row["pass"];

					}else{

						echo "パスワードが間違っています。\n";
						echo "<hr>";

					}

				}else{
				//何もしない
				}

			}//編集ボタン終わり

		}else{
		//何もしない
		}

	$sql='SELECT*FROM kadai order by id';

	$result=$pdo->query($sql);

}catch (PDOException $e){

	print('接続失敗:'.$e->getMessage());

	die();

}

?>

<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">

<title>プログラミング初心者がなんか作ってみた</title>
</head>
<body>
<h1>プログラミング初心者がなんか作ってみた</h1>

ご自由に書き込みどうぞ！<br>

<form method="post" action="mission_2-15.php">

<hr style="border:2px groove #000000;">

【投稿フォーム】<br/>
名前:<input type="text" name="name" value="<?php echo $editname; ?>"><br>
コメント:<input type="text" name="comment" value="<?php echo $edittext; ?>"><br>
パスワード(半角英数字で4文字以上8文字以内):<input type="password" name="password" size="8" minlength="4" maxlength="8" value="<?php echo $editpass; ?>"><br>
<input type="hidden" name="editnum" value="<?php echo $editnumber; ?>">
<input type="submit" name="regist" value="投稿">

<hr style="border:2px groove #000000;">

</form>

投稿内容一覧↓<br>

<hr>

<?php

foreach($result as $re){

	echo $re["id"];
	echo "<br>";
	echo $re["name"];
	echo "<br>";
	echo $re["comment"];
	echo "<br>";
	echo $re["date"];
	echo "<br>";
	echo "<hr>";

}

?>

※削除された番号は詰められて表示されます。<br>

<hr style="border:2px groove #000000;">

<form method="post" action="mission_2-15.php">

【削除フォーム】<br/>

削除対象番号:<input type="number" name="deletenumber"><br>
パスワード(投稿時に設定したパスワードを入力してください):<input type="password" name="deletepass" size="8" minlength="4" maxlength="8"><br>
<input type="submit" name="delete" value="削除">

<br><br>

【編集フォーム】<br>

編集対象番号:<input type="number" name="editnumber"><br>
パスワード(投稿時に設定したパスワードを入力してください):<input type="password" name="editpass" size="8" minlength="4" maxlength="8" ><br>
<input type="submit" name="edit" value="編集">
<br><br>
</form>
</body>
</html>
