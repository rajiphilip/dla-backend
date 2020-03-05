<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Edit Feedback Question</h1>
    <?php require_once('alert.php'); ?>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Feedback Question</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div class="col-lg-8">
                    <form action="<?= URL; ?>/feedback/updateFeedbackQuestion" method="post" class="user"
                          id="add_course_form">
                        <div class="form-group">
                            <label>Type:</label>
                            <select class="form-control" id="type" name="type" required>
                                <option value="">-- Select Option --</option>
                                <?php foreach ($feedback_types as $ft){?>
                                    <option value="<?= $ft->id;?>" <?= ($ft->id == $feedback->type)?'selected':'';?>><?= $ft->type;?></option>
                                <?php }?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Question:</label>
                            <textarea class="form-control" rows="5" id="question" name="question" required><?= $feedback->question; ?></textarea>
                        </div>
                        <input type="hidden" name="feedback_id" value="<?= $feedback->id; ?>"/>
                        <input type="submit" class="btn btn-primary btn-user" value="Add Question"/>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->