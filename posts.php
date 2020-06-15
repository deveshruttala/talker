<div class="row">
  <div class="col-lg-10">
    <h5><?php echo phpGetGroupName($_GET["gid"]); ?></h5>
  </div>
  <div class="col-lg-1">
    <?php if (phpGetGroupOwnerID($_GET["gid"]) == $_SESSION["uid"]) { ?>
    <a href="gate.php?module=group&gid=<?php echo $_GET["gid"]; ?>" class="btn btn-primary btn-sm float-right mt-3" role="button">Settings</a>
    <?php } ?>
  </div>


<?php
//check if the group is already bookmarked by the signed-in user
//if so, don't show the Bookmark button

$db_data = array($_SESSION["uid"], $_GET["gid"]);
$dbBookmarksList = phpFetchAllDB('SELECT * FROM bookmarks WHERE user_id = ? AND group_id = ?', $db_data);
$db_data = "";  

if (empty($dbBookmarksList)) {

?>

  
  <div class="col-lg-1">
  <form action="bookmarks.ctrl.php" method="post" novalidate>  
    <input type="hidden" id="formPostsGroupID" name="formPostsGroupID" value="<?php echo $_GET['gid']; ?>">
    <button type="submit" id="formPostsBookmark" name="formPostsBookmark" class="btn btn-primary btn-sm float-right mt-3">Bookmark</button>
  </form>
  </div>
  

<?php } ?> 



</div>
<hr>


<div class="row">
	<div class="col-lg-12">
		<form name="formPosts" action="posts.ctrl.php" method="post" novalidate>

			<div class="form-group">
				<label for="formPostsContent">Create new post</label>
				<textarea class="form-control <?php if ($_SESSION['msgid']!='501' && $_SESSION['msgid']!='') { echo 'is-valid'; }else{ echo (phpShowInputFeedback($_SESSION['msgid'])[0]); } ?>" id="formPostsContent" name="formPostsContent" placeholder="Write the post here. Tags are not allowed." onkeyup="jsPostsValidateTextArea('formPostsContent')"><?php echo $_SESSION["posts_content"]; ?></textarea>

                <?php if ($_SESSION["msgid"]=="501") { ?>
                <div class="invalid-feedback">
                <?php echo (phpShowInputFeedback($_SESSION["msgid"])[1]); ?>
                </div>
                <?php } ?>
            </div>

            <input type="hidden" id="formPostsGroupID" name="formPostsGroupID" value="<?php echo $_GET['gid']; ?>">

			<button type="submit" id="formPostsSubmit" name="formPostsSubmit" class="btn btn-primary btn-success mb-5">Send</button>
		</form>
	</div>
</div>

<?php

$db_data = array($_GET["gid"]);
$dbPostsList = phpFetchAllDB('SELECT * FROM posts WHERE post_group_id = ? ORDER BY post_date DESC', $db_data);
$db_data = "";

?>

<p><strong>Latest posts</strong></p>

<div class="row">
<div class="col-lg-12">

  <?php foreach ($dbPostsList as $dbPostRow) { ?>


    <div class="message_header">
        FROM: <?php echo phpGetUserEmail($dbPostRow["post_author_id"]); ?>
        | DATE: <?php echo $dbPostRow["post_date"]; ?>
    </div>
    

    <div id="databasePostsContent<?php echo $dbPostRow['post_id']; ?>" class="message_content"><?php echo $dbPostRow["post_content"]; ?></div>

    <form action="posts.edit.ctrl.php" method="post" novalidate>

        <div class="form-group form_posts_content">
            <textarea class="form-control" id="formPostsContentEdited<?php echo $dbPostRow['post_id']; ?>" name="formPostsContentEdited<?php echo $dbPostRow['post_id']; ?>" onkeyup="jsPostsValidateTextArea('<?php echo $dbPostRow['post_id']; ?>')" hidden><?php echo $dbPostRow["post_content"]; ?></textarea>
        </div>

        <input type="hidden" id="formPostsGroupID" name="formPostsGroupID" value="<?php echo $_GET['gid']; ?>">
        <input type="hidden" id="formPostsPostID" name="formPostsPostID" value="<?php echo $dbPostRow["post_id"]; ?>">

        <?php if ($dbPostRow["post_author_id"] == $_SESSION["uid"]) { ?>
            <a href="#formPostsContentEdited<?php echo $dbPostRow['post_id']; ?>" id="formPostsEditButton<?php echo $dbPostRow['post_id']; ?>" class="btn btn-primary btn-sm" role="button" onclick="showTextAreaByPostId('<?php echo $dbPostRow["post_id"]; ?>')">Edit</a>
        <?php } ?>

        <!-- Display modal only if the current user is the author of the post or the owner of the group -->
        <?php if ($_SESSION["uid"] == $dbPostRow["post_author_id"] || $_SESSION["uid"] == phpGetGroupOwnerID($_GET["gid"])) { ?>


            <!-- Button trigger modal -->
            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deletePostModal<?php echo $dbPostRow['post_id']; ?>">Delete</button>

            <!-- Modal -->
            <div class="modal fade" id="deletePostModal<?php echo $dbPostRow['post_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="deletePostModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deletePostModalLabel">Delete the post</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to delete this post? This action is irreversible!
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" id="formPostsDeleteButton" name="formPostsDeleteButton" value="delete" class="btn btn-primary">Yes, delete it!</button>
                        </div>
                    </div>
                </div>
            </div>
        
        <?php } ?>


    </form>

  <?php } ?>

</div>
</div>


<script src="posts.js"></script>

<?php $_SESSION["posts_content"] = ""; ?>
