<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Send Message</h1>
    <?php require_once('alert.php');?>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Send Message to Facilitator</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div class="col-lg-9">
                    <form action="<?= URL; ?>/message/saveMessage" method="post" class="user" id="add_course_form">
                        <div class="form-group">
                            <label>Facilitator:</label>
                            <select class="form-control" id="receiver_id" name="receiver_id" required>
                                <option value="">-- Select Option --</option>
                                <?php foreach ($facilitators as $facilitator){?>
                                    <option value="<?= $facilitator->user_id?>"><?= $facilitator->firstname.' '.$facilitator->lastname;?></option>
                                <?php }?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Subject:</label>
                            <input type="text" class="form-control" id="subject" name="subject"
                                   aria-describedby="emailHelp" required>
                        </div>
                        <div class="form-group">
                            <label>Message:</label>
                            <textarea class="form-control" rows="8" id="message_body" name="body" required></textarea>
                        </div>

                        <input type="submit" class="btn btn-primary btn-user" value="Send"/>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->