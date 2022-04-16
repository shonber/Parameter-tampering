public function EditPost($id, $data)
{
    /* The first section is the try and catch.
    * The try will save the user id of who created the post that a user is trying to edit
    * After the user id who created the post is saved in a variable called $temp there is a condition to check if the editor is the creator.
    * The catch will show the error if needed.
    * If the editor is not the creator then we will return false.
    *
    * ATTENTION: The next section is the editor is self and not the fix anymore
    * If the editor is the creator the data will get updated in the database.
    */
    
		try
		{
			$cursor = $this->MySQLdb->prepare("SELECT user_id FROM `posts` where post_id=:id");
			$cursor->execute(array(":id"=>$id));
      
			if ($cursor->rowCount()){
				while($row = $cursor->fetch()){
					$temp = $row["user_id"];
				}
			}
		}
    
		catch(PDOException $e)
		{
			$this->CheckErrors($e);
		}
		
		if($_SESSION["userid"]!=$temp){
			return false;
		}
		else{
			try
			{
				$cursor = $this->MySQLdb->prepare("UPDATE posts SET post_data=:post_data WHERE post_id=:id");
				$cursor->execute(array(":id"=>$id, ":post_data"=>$data));
				if ($cursor->rowCount()) return true;
			}
			catch(PDOException $e)
			{
				$this->CheckErrors($e);
			}
			return false;
		}
}
