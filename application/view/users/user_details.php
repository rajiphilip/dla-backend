<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $student->firstname.' '.$student->lastname.' '.$student->othername ;?></h1>

    <div class="row">

        <div class="col-lg-12">

            <!-- Circle Buttons -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Profile</h6>
                </div>
                <div class="card-body">
                    <table  class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <tr>
                            <td><strong>Matric No: </strong></td>
                            <td><?= $student->matric_number;?></td>
                        </tr>
                        <tr>
                            <td><strong>Profile Type: </strong></td>
                            <td><?= $student->type;?></td>
                        </tr>
                        <tr>
                            <td><strong>Email: </strong></td>
                            <td><?= $student->email;?></td>
                        </tr>
                        <tr>
                            <td><strong>Mobile: </strong></td>
                            <td><?= $student->phone_number;?></td>
                        </tr>
                        <tr>
                            <td><strong>Gender: </strong></td>
                            <td><?= $student->gender;?></td>
                        </tr>
                        <tr>
                            <td><strong>Marital Status: </strong></td>
                            <td><?= $student->marital_status;?></td>
                        </tr>
                        <tr>
                            <td><strong>Date of Birth: </strong></td>
                            <td><?= $student->date_of_birth;?></td>
                        </tr>
                        <tr>
                            <td><strong>Address: </strong></td>
                            <td><?= $student->residence_address;?></td>
                        </tr>
                        <tr>
                            <td><strong>Country: </strong></td>
                            <td><?= $student->country;?></td>
                        </tr>
                        <tr>
                            <td><strong>Employment Status: </strong></td>
                            <td><?= $student->employment_status;?></td>
                        </tr>
                        <tr>
                            <td><strong>Company Name: </strong></td>
                            <td><?= $student->company_name;?></td>
                        </tr>

                        <tr>
                            <td><strong>Position in Company: </strong></td>
                            <td><?= $student->position_in_company;?></td>
                        </tr>
                        <tr>
                            <td><strong>Company Address: </strong></td>
                            <td><?= $student->company_address;?></td>
                        </tr>
                        <tr>
                            <td><strong>Company Phone No: </strong></td>
                            <td><?= $student->company_phone_number;?></td>
                        </tr>
                        <tr>
                            <td><strong>Company Email: </strong></td>
                            <td><?= $student->company_email;?></td>
                        </tr>
                        <tr>
                            <td><strong>Religion: </strong></td>
                            <td><?= $student->religion;?></td>
                        </tr>
                        <tr>
                            <td><strong>Name of Ministry: </strong></td>
                            <td><?= $student->name_of_ministry;?></td>
                        </tr>
                        <tr>
                            <td><strong>Facebook: </strong></td>
                            <td><?= $student->facebook;?></td>
                        </tr>
                        <tr>
                            <td><strong>Instagram: </strong></td>
                            <td><?= $student->instagram;?></td>
                        </tr>
                        <tr>
                            <td><strong>Twitter: </strong></td>
                            <td><?= $student->twitter;?></td>
                        </tr>
                        <tr>
                            <td><strong>Account Created: </strong></td>
                            <td><?= date('d-M-Y', strtotime( $student->created_at));?></td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Brand Buttons -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Sessions</h6>
                </div>
                <div class="card-body">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>Course</th>
                            <th>Theme</th>
                            <th>Start date</th>
                            <th>End Date</th>
                            <th>Fee</th>
                            <th>Session No</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if (isset($sessions)) {
                            foreach ($sessions as $session) { ?>
                                <tr>
                                    <td><?= $session->name; ?></td>
                                    <td><?= $session->theme; ?></td>
                                    <td><?= date('d-M-Y', strtotime($session->start_date)); ?></td>
                                    <td><?= date('d-M-Y', strtotime($session->end_date)); ?></td>
                                    <td><?= $session->fee; ?></td>
                                    <td><?= $session->session_number ; ?></td>
                                </tr>
                            <?php }
                        } ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <div class="col-lg-12">

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Payments</h6>
                </div>
                <div class="card-body">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>Course</th>
                            <th>Start date</th>
                            <th>Payment Type</th>
                            <th>Amount</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Paid By</th>
                            <th>Payment Date</th>
                            <th>Ref. No.</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if (isset($transactions)) {
                            foreach ($transactions as $transaction) { ?>
                                <tr>
                                    <td><?= $transaction->name; ?></td>
                                    <td><?= date('d-M-Y', strtotime($transaction->start_date)); ?></td>
                                    <td><?= $transaction->type ; ?></td>
                                    <td><?= $transaction->amount ; ?></td>
                                    <td><?= $transaction->description ; ?></td>
                                    <td><?= $transaction->status ; ?></td>
                                    <td><?= $transaction->paid_by ; ?></td>
                                    <td><?= $transaction->payment_date ; ?></td>
                                    <td><?= $transaction->reference_number  ; ?></td>
                                </tr>
                            <?php }
                        } ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>

</div>
<!-- /.container-fluid -->