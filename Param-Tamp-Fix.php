/*
* Parameter tampering vulenrabilty fix
* Created by Shon Berengard
* This is a basic fix without special features like admins can edit every post and regualr users can edit only their post.
* This fix is letting only the post creator the ability to edit the post.
* This fix is more like the skeleton of a big platfrom
*/

/* __THE FIX__ */
/?php
public function EditPost($id, $data)
{
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

?>
