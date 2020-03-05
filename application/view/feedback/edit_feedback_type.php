<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Edit Feedback Type</h1>
    <?php require_once('alert.php');?>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Feedback Type</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div class="col-lg-8">
                    <form action="<?= URL; ?>feedback/updateFeedbackType" method="post" class="user" id="add_course_form">
                        <div class="form-group">
                            <label>Type:</label>
                            <input type="text" class="form-control" id="type" name="type" value="<?= $feedback->type; ?>"
                                   aria-describedby="emailHelp" required>
                        </div>
                        <input type="hidden" name="feedback_type_id" value="<?= $feedback->id; ?>" />
                        <input type="submit" class="btn btn-primary btn-user" value="Update Feedback Type"/>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->