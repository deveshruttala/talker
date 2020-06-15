<?php 
$db_data = array($_SESSION["uid"]);
$dbBookmarksList = phpFetchAllDB('SELECT * FROM bookmarks WHERE user_id = ?', $db_data);
$db_data = "";       
?>


<div class="row">
  <div class="col-lg-12">
    <h5>Bookmarks</h5>
  </div>
</div>
<hr>


<div class="row">
	

			<?php foreach ($dbBookmarksList as $dbGroupRow) { ?>
				<div class="group_content col-lg-6">
                        <a href="gate.php?module=posts&gid=<?php echo $dbGroupRow['group_id']; ?>">
						<?php echo (phpGetGroupName($dbGroupRow['group_id'])); ?>
                        </a>
                </div>

                <div class="group_content col-lg-6">
                

                        <!-- Create a form for unbookmarking the group-->
                        <form action="bookmarks.delete.ctrl.php" method="post" novalidate>
                        <input type="hidden" id="formGroupsGroupID" name="formGroupsGroupID" value="<?php echo $dbGroupRow["group_id"]; ?>">

                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-danger btn-sm float-right" data-toggle="modal" data-target="#unbookmarkGroupModal<?php echo $dbGroupRow['group_id']; ?>">Unbookmark</button>

                        <!-- Modal -->
                        <div class="modal fade" id="unbookmarkGroupModal<?php echo $dbGroupRow['group_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="unbookmarkGroupModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="unbookmarkModalLabel">Unbookmark the group</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <div class="modal-body">
                                Are you sure you want to unbookmark this group? You can bookmark it again later.
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" id="formGroupsUnbookmarkButton" name="formGroupsUnbookmarkButton" value="unbookmark" class="btn btn-primary">Yes, unbookmark it!</button>
                                </div>
                            </div>
                            </div>
                        </div>

                        </form>

                    
                </div>

			<?php } ?>

</div>