<?php
/*
Template Name: Prescription Upload
*/

global $current_user, $wp_roles, $userdata, $post, $paged;
$dir_obj = new DocDirect_Scripts();
$user_identity = $current_user->ID;
$url_identity = $user_identity;


get_header();
?>
    <div class="container">
        <div class="">
            <!--            <h1 class="text-red"> We are currenty working on this page-->
            <!--            </h1>-->
            <br>
            <form action="<?= site_url('prescription-upload') ?>" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" class="form-control" placeholder="Enter your full name" required>
                        </div>
                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" class="form-control" placeholder="Enter your full name">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" placeholder="Enter email address here" required>
                        </div>
                        <div class="form-group">
                            <label>Location</label>
                            <input type="location" class="form-control" placeholder="Enter location here" required>
                        </div>

                    </div>
                    <div class="col-md-6">

                        <div class="form-group">
                            <label>Mobile</label>
                            <input type="mobile" class="form-control" placeholder="01XXXXXXXXX" required>
                        </div>
                        <div class="form-group">
                            <label>Alternative Mobile</label>
                            <input type="mobile" class="form-control" placeholder="01XXXXXXXXX">
                        </div>
                        <div class="form-group">
                            <label>Select Prescription File</label>
                            <input type="file" required>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Note </label>
                            <textarea cols="4" rows="4" class="form-control"
                                      placeholder="Enter note text here" required></textarea>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>

    </div>

<?php
get_footer();
?>