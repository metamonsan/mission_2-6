<?php

$filename="mission_2-6.txt";

date_default_timezone_set('Asia/Tokyo');

touch($filename);

if(isset($_POST["regist"])){

	$filearrays=file($filename);

	if($_POST["editnum"]!==""){

		foreach($filearrays as $filearray){

			$filedata=explode("<>",$filearray);
			$i=$filedata[0];
			$j=$_POST["editnum"];

			if($i==$j){

				$i=$i-1;
				$filearrays[$i]=$j."<>".$_POST["name"]."<>".$_POST["comment"]."<>".date("Y/m/d H:i:s")."(更新済)"."<>".$_POST["password"]."<>"."編集済\n";
				file_put_contents($filename,$filearrays);
				$editnum="";

			}else{

			}

		}

	}else{

		$postnumber=count($filearrays);
		$postnumber=$postnumber+1;
		$fp=fopen($filename,"a");
		fwrite($fp,$postnumber."<>".$_POST["name"]."<>".$_POST["comment"]."<>".date("Y/m/d H:i:s")."<>".$_POST["password"]."<>"."初回データ\n");
		fclose($fp);
	}

}else if(isset($_POST["delete"])){

	$comments=file($filename);

	foreach($comments as $comment){

		$linearray=explode("<>",$comment);
		$i=$linearray[0];
		$j=$_POST["number"];
		$check=$linearray[4];

		if($i==$j){

			if($_POST["deletepass"]==$check){

				$i=$i-1;
				$comments[$i]="0<>削除済み\n";
				file_put_contents($filename,$comments);
			}else{
			
				echo "パスワードが間違っています。\n";
				echo "<hr>";

			}

		}else{
		
		}

	}

}else if(isset($_POST["edit"])){
//編集ボタンが押されたら

	$lines=file($filename);
	//テキストファイルを配列に格納

	foreach($lines as $line){
	//ループスタート

		$linearray=explode("<>",$line);
		//番号の取得

		$i=$linearray[0];
		//配列番号

		$j=$_POST["editnumber"];
		//編集したい番号

		$check=$linearray[4];

		if($i==$j){

			if($_POST["editpass"]==$check){

				$data=$line;
				//配列の中身をコピーしておく

				//echo $data;

				$editdata=explode("<>",$data);

				/*echo $editdata[0];
				echo $editdata[1];
				echo $editdata[2];*/

				$editnumber=$editdata[0];
				$editname=$editdata[1];
				$edittext=$editdata[2];
				$editpass=$editdata[4];

			}else{

				echo "パスワードが間違っています。\n";
				echo "<hr>";

			}

		}else{

		}

	}

}else{

}

?>

<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8"/>

<title>プログラミング初心者がなんか作ってみた</title>
</head>
<body>
<h1>プログラミング初心者がなんか作ってみた</h1>

ご自由に書き込みどうぞ！<br>

<form method="post" action="mission_2-6.php">

<hr style="border:2px groove #000000;">

【投稿フォーム】<br/>
名前:<input type="text" name="name" value="<?php echo $editname; ?>"><br/>
コメント:<input type="text" name="comment" value="<?php echo $edittext; ?>"><br/>
パスワード(半角英数字で4文字以上8文字以内):<input type="password" name="password" size="8" minlength="4" maxlength="8" value="<?php echo $editpass; ?>"><br/>
<input type="hidden" name="editnum" value="<?php echo $editnumber; ?>">
<input type="submit" name="regist" value="投稿">

<hr style="border:2px groove #000000;">

</form>

投稿内容一覧↓<br/>

<hr>

<?php
$filename="mission_2-6.txt";

$comments=file($filename);

foreach($comments as $comment){

	$linearray=explode("<>",$comment);

	if($linearray[0]=="0"){

		echo "この記事は削除されました。";

		echo "<hr>";

	}else{

		echo $linearray[0];
		echo "<br>";
		echo $linearray[1];
		echo "<br>";
		echo $linearray[2];
		echo "<br>";
		echo $linearray[3];
		echo "<br>";
		echo "<hr>";

	}

}

?>

<br/>

<hr style="border:2px groove #000000;">

<form method="post" action="mission_2-6.php">

【削除フォーム】<br/>

削除対象番号:<input type="number" name="number"><br/>
パスワード(投稿時に設定したパスワードを入力してください):<input type="password" name="deletepass" size="8" minlength="4" maxlength="8"><br/>
<input type="submit" name="delete" value="削除">

<br/><br/>

【編集フォーム】<br/>

編集対象番号:<input type="number" name="editnumber"><br/>
パスワード(投稿時に設定したパスワードを入力してください):<input type="password" name="editpass" size="8" minlength="4" maxlength="8" ><br/>
<input type="submit" name="edit" value="編集">

</form>
</body>
</html>
