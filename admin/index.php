<? include "../header.html"; ?>		<? switch ($_POST['action']) {	case delete:		$dbdelete = mysql_query("DELETE FROM Inventory WHERE partID=" . $_REQUEST['record-to-delete']);		break;	case update:		$part_make = mysql_real_escape_string($_POST['make']) ;		$part_number = mysql_real_escape_string($_POST['number']) ;		$part_name = str_replace("&","&amp;",mysql_real_escape_string($_POST['name'])) ;		$part_description = str_replace("&","&amp;",mysql_real_escape_string($_POST['description'])) ;		$part_price = mysql_real_escape_string($_POST['price']) ;		$part_age = mysql_real_escape_string($_POST['age']) ;		$part_condition = mysql_real_escape_string($_POST['condition']) ;		$part_weight = mysql_real_escape_string($_POST['weight']) ;		$part_category = mysql_real_escape_string($_POST['category']) ;		$dbupdate =			mysql_query("				UPDATE  `anacapaequipment`.`Inventory`				SET					`Make` = '$part_make' ,					`Number` = '$part_number' ,					`Name` = '$part_name' ,					`Description` = '$part_description' ,					`Price` = '$part_price' ,					`Age` = '$part_age' ,					`Condition` = '$part_condition' ,					`Weight` = '$part_weight' ,					`Category` = '$part_category'				WHERE					`partID` = '$_POST[partID]'				LIMIT 1		",$dbcon);		$part_id = mysql_real_escape_string($_POST['partID']) ;		if(($_FILES["image1"]['type'] == 'image/jpg') || ($_FILES["image1"]['type'] == 'image/jpeg') || ($_FILES["image1"]['type'] == 'image/pjpeg'))			move_uploaded_file($_FILES["image1"]["tmp_name"], "../pictures/" . $part_id. ".jpg");		if(($_FILES["image2"]['type'] == 'image/jpg') || ($_FILES["image2"]['type'] == 'image/jpeg') || ($_FILES["image2"]['type'] == 'image/pjpeg'))			move_uploaded_file($_FILES["image2"]["tmp_name"], "../pictures/" . $part_id. "-2.jpg");		if(($_FILES["image3"]['type'] == 'image/jpg') || ($_FILES["image3"]['type'] == 'image/jpeg') || ($_FILES["image3"]['type'] == 'image/pjpeg'))			move_uploaded_file($_FILES["image3"]["tmp_name"], "../pictures/" . $part_id. "-3.jpg");		if(($_FILES["image4"]['type'] == 'image/jpg') || ($_FILES["image4"]['type'] == 'image/jpeg') || ($_FILES["image4"]['type'] == 'image/pjpeg'))			move_uploaded_file($_FILES["image4"]["tmp_name"], "../pictures/" . $part_id. "-4.jpg");		break;	case input:		$part_make = mysql_real_escape_string($_POST['make']) ;		$part_number = mysql_real_escape_string($_POST['number']) ;		$part_name = str_replace("&","&amp;",mysql_real_escape_string($_POST['name'])) ;		$part_description = str_replace("&","&amp;",mysql_real_escape_string($_POST['description'])) ;		$part_price = str_replace(",","",mysql_real_escape_string($_POST['price'])) ;		$part_age = mysql_real_escape_string($_POST['age']) ;		$part_condition = mysql_real_escape_string($_POST['condition']) ;		$part_weight = mysql_real_escape_string($_POST['weight']) ;		$part_category = mysql_real_escape_string($_POST['category']) ;		$dbinput =			mysql_query("				INSERT INTO `anacapaequipment`.`Inventory` (					`Make` ,					`Number` ,					`Name` ,					`Description` ,					`Price` ,					`Age` ,					`Condition` ,					`Weight` ,					`Category`				)				VALUES (					'$part_make',					'$part_number',					'$part_name',					'$part_description',					'$part_price',					'$part_age',					'$part_condition',					'$part_weight',					'$part_category'				)		",$dbcon);		// All this just to get the damn ID of the part we just input, so we can name the images accordingly...			$result = mysql_query("				SELECT partID FROM Inventory				ORDER BY partID DESC 				LIMIT 1			",$dbcon);			while($row = mysql_fetch_array($result))				$part_id = $row['partID'] ;		// Now we can finally move the image files, if they're JPEGs...		if(($_FILES["image1"]['type'] == 'image/jpg') || ($_FILES["image1"]['type'] == 'image/jpeg') || ($_FILES["image1"]['type'] == 'image/pjpeg'))			move_uploaded_file($_FILES["image1"]["tmp_name"], "../pictures/" . $part_id. ".jpg");		if(($_FILES["image2"]['type'] == 'image/jpg') || ($_FILES["image2"]['type'] == 'image/jpeg') || ($_FILES["image2"]['type'] == 'image/pjpeg'))			move_uploaded_file($_FILES["image2"]["tmp_name"], "../pictures/" . $part_id. ".jpg");		if(($_FILES["image3"]['type'] == 'image/jpg') || ($_FILES["image3"]['type'] == 'image/jpeg') || ($_FILES["image3"]['type'] == 'image/pjpeg'))			move_uploaded_file($_FILES["image3"]["tmp_name"], "../pictures/" . $part_id. ".jpg");		if(($_FILES["image4"]['type'] == 'image/jpg') || ($_FILES["image4"]['type'] == 'image/jpeg') || ($_FILES["image4"]['type'] == 'image/pjpeg'))			move_uploaded_file($_FILES["image4"]["tmp_name"], "../pictures/" . $part_id. ".jpg");		break;}?><? include "nav.html"; ?>				<div id="main"><?$feedback = "<strong>Anacapa Equipment Brokers Inventory Database Manager</strong>";switch (1) {	case $dbdelete:		$feedback =			"Item deleted: " .			$_REQUEST[make] . " " .			$_REQUEST[number] .  " " .			$_REQUEST[name] . "." ;		break;	case $dbinput:		$feedback =			"Item added: " . 			$_REQUEST[make] . " " .			$_REQUEST[number] .  " " .			$_REQUEST[name] . "." ;		break;	case $dbupdate:		$feedback =			"Saved changes to: " . 			$_REQUEST[make] . " " .			$_REQUEST[number] .  " " .			$_REQUEST[name] . "." ;		break;		}	if ($_GET[mode] == "")		$mode = "gallery" ;	else		$mode = $_GET[mode] ;		switch ($mode)	{	case gallery:		$q = mysql_real_escape_string($_GET['q']) ;		$cat = mysql_real_escape_string($_GET['cat']) ;		if ($cat == "")			$msgcat = "all categories" ;		else			$msgcat = "category <q>".$cat."</q>" ;			if ($q == "")			$msgq = "everything" ;		else			$msgq = "<q>".$q."</q>" ;			if($q.$cat == "")			$msg = "Today's featured items:" ;		else			$msg = "Displaying search results for ".$msgq." in ".$msgcat."." ;					echo "			<p class='msg'>".$feedback."</p>			<form class='ed' action='index.php' method='get'>				<p class='msg'>					<input type='hidden' name='mode' value='add' />					<input type='submit' value='Add an Item'/>				</p>			</form>			<p class='msg'>".$msg."</p>		";		echo "				<div class='gallery'>											<ul>		";			if ($_GET[q] == "" and $_GET[cat] == "")				$result = mysql_query("					SELECT * FROM Inventory					ORDER BY Price DESC					LIMIT 0,12				",$dbcon);		else				$result = mysql_query("				SELECT * FROM Inventory				WHERE					(					Make like '%".$q."%'					OR					Name like '%".$q."%'					OR					Number like '%".$q."%'					OR					Description like '%".$q."%'					)					AND					Category like '%".$cat."%'			",$dbcon);			while($row = mysql_fetch_array($result))			echo "						<li>							<form class='del' action='index.php' method='post'>								<p>									<input type='hidden' name='record-to-delete' value='" . $row['partID'] . "' />									<input type='hidden' name='make' value='" . $row['Make'] . "' />									<input type='hidden' name='number' value='" . $row['Number'] . "' />									<input type='hidden' name='name' value='" . $row['Name'] . "' />									<input type='hidden' name='action' value='delete' />									<input type='submit' value='Delete'/>								</p>							</form>							<form class='ed' action='index.php' method='get'>								<p>									<input type='hidden' name='mode' value='edit' />									<input type='hidden' name='part' value='".$row['partID']."' />									<input type='submit' value='Edit'/>								</p>							</form>							<p>" . $row['Make'] . "&nbsp;" . $row['Number']. "</p>							<h2><a href='index.php?mode=edit&amp;part=" . $row['partID'] . "'>" . $row['Name'] . "</a></h2>							<a href='index.php?mode=edit&amp;part=" . $row['partID'] . "'><img class='thumb' src='../pictures/" . $row['partID'] . ".jpg' alt='picture' /></a>							<p>Price: $" . $row['Price'] . "</p>						</li>			";			echo "					</ul>										</div>		";				break;	case edit:			$part = $_GET[part];				$result = mysql_query("			SELECT * FROM Inventory			WHERE partID = ".$part."		",$dbcon);		while($row = mysql_fetch_array($result))			echo "				<p class='msg'>".$feedback."</p>				<p class='msg'>Edit item details:</p>					<div class='view'>						<form action='index.php' method='post' enctype='multipart/form-data'>							<p>								<label for='make'>Manufacturer:</label>								<input type='text' size='35' name='make' value='".$row['Make']."' />							</p>							<p>								<label for='number'>Model Number:</label>								<input type='text' size='35' name='number' value='".$row['Number']."' />							</p>							<p>								<label for='name'>Item Name:</label>								<input type='text' size='35' name='name' value='".$row['Name']."' /></p>							<p>								<label for='description'>Description:</label>								<textarea rows='20' cols='35' name='description'>".$row['Description']."</textarea></p>							<p>								<label for='price'>Price:</label>								<input type='text' size='35' name='price' value='".$row['Price']."' />							</p>							<p>								<label for='description'>Description:</label>								<input type='text' size='35' name='age' value='".$row['Age']."' />							</p>							<p>								<label for='condition'>Condition:</label>								<input type='text' size='35' name='condition' value='".$row['Condition']."' />							</p>							<p>								<label for='weight'>Weight:</label>								<input type='text' size='35' name='weight' value='".$row['Weight']."' />							</p>							<p>								<label for='category'>Category:</label>								<input type='text' size='35' name='category' value='".$row['Category']."' />							</p>							<p>								<label for='image'>Upload new images:</label>							</p>							<ol>								<li>									<img src='../pictures/" . $row['partID'] . ".jpg' alt='picture 1' />									<input type='file' name='image1' />								</li>								<li>									<img src='../pictures/" . $row['partID'] . "-2.jpg' alt='picture 2' />									<input type='file' name='image2' />								</li>								<li>									<img src='../pictures/" . $row['partID'] . "-3.jpg' alt='picture 3' />									<input type='file' name='image3' />								</li>								<li>									<img src='../pictures/" . $row['partID'] . "-4.jpg' alt='picture 4' />									<input type='file' name='image4' />								</li>							</ol>							<p>								<input type='hidden' name='partID' value='".$row['partID']."' />								<input type='hidden' name='action' value='update' />								<input type='submit' value='Save Changes' />							</p>						</form>					</div>			";		break;			case add:				echo "			<p class='msg'>".$feedback."</p>			<p class='msg'>Input new item:</p>				<div class='view'>					<form action='index.php' method='post' enctype='multipart/form-data'>						<p>							<label for='make'>Manufacturer:</label>							<input type='text' size='50' name='make' />						</p>						<p>							<label for='number'>Model Number:</label>							<input type='text' size='50' name='number' />						</p>						<p>							<label for='name'>Item Name:</label>							<input type='text' size='50' name='name' />						</p>						<p>							<label for='description'>Description:</label>							<textarea rows='10' cols='50' name='description'> </textarea>						</p>						<p>							<label for='price'>Price:</label>							<input type='text' size='50' name='price' />						</p>						<p>							<label for='age'>Age:</label>							<input type='text' size='50' name='age' />						</p>						<p>							<label for='condition'>Condition:</label>							<input type='text' size='50' name='condition' />						</p>						<p>							<label for='weight'>Weight:</label>							<input type='text' size='50' name='weight' />						</p>						<p>							<label for='category'>Category:</label>							<input type='text' size='50' name='category' />						</p>						<p>							<label for='image'>Upload images:</label>							<input type='file' name='image1' />							<input type='file' name='image2' />							<input type='file' name='image3' />							<input type='file' name='image4' />						</p>						<p>							<input type='hidden' name='partID' value='".$row['partID']."' />							<input type='hidden' name='action' value='input' />							<input type='submit' value='Input' />						</p>					</form>				</div>			";		break;			}?>		</div><? include "../footer.html"; ?>