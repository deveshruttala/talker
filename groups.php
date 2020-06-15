<?php
	$db_data = array();
	$dbGroupsList = phpFetchAllDB('SELECT * FROM groups', $db_data);
	$db_data = "";
?>


<div class="row">
  <div class="col-lg-6">
    <h5>Groups</h5>
  </div>
  <div class="col-lg-6">
    <a href="gate.php?module=group" class="btn btn-success float-right mt-2" role="button">Create new group</a>
  </div>
</div>
<hr>


<div class="row">
	

			<?php foreach ($dbGroupsList as $dbGroupRow) { ?>
				<div class="group_content col-lg-6">
                        <a href="gate.php?module=posts&gid=<?php echo $dbGroupRow['group_id']; ?>">
						<?php echo $dbGroupRow["group_name"]; ?>
                        </a>
                </div>

                <div class="group_content col-lg-6">
                <!-- Display modal only if the current user is the owner of the group -->
                    <?php if ($_SESSION["uid"] == $dbGroupRow["group_owner_id"]) { ?>

                        <!-- Create a form -->
                        <form action="group.delete.ctrl.php" method="post" novalidate>
                        <input type="hidden" id="formGroupsGroupID" name="formGroupsGroupID" value="<?php echo $dbGroupRow["group_id"]; ?>">

                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-danger btn-sm float-right" data-toggle="modal" data-target="#deleteGroupModal<?php echo $dbGroupRow['group_id']; ?>">Delete</button>

                        <!-- Modal -->
                        <div class="modal fade" id="deleteGroupModal<?php echo $dbGroupRow['group_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteGroupModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel">Delete the group</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <div class="modal-body">
                                Are you sure you want to delete this group? This action is irreversible!
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" id="formGroupsDeleteButton" name="formGroupsDeleteButton" value="delete" class="btn btn-primary">Yes, delete it!</button>
                                </div>
                            </div>
                            </div>
                        </div>

                        </form>

                    <?php } ?>
                </div>

			<?php } ?>

</div>
