
<a class="b-close">[X]<a/><br />
<form role="form" action="admin.php">
	
	<select name="status" class="form-control">
	  <option value="nevyksta">Nevyksta</option>
	  <option value="vyksta">Vyksta</option>
	  <option value="talka">Talka</option>
	  <option value="šventė">Šventė</option>
	  <option value="delete">[Šalinti žymą]</option>
	</select><br />
	<input type="text" name="reason" placeholder="Pastaba" class="form-control"/>
	<input type="hidden" name="day" value="<?php echo $_GET['day']; ?>"/>
	<input type="hidden" name="confirmed" value="<?php $_SESSION['user']['name']; ?>"/><br />
	<center><button type="submit" name="action" class="btn btn-primary" value="addDay">Atžymėti</button></center>
</form>