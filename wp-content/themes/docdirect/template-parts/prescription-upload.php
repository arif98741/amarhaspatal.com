<?php
/*
Template Name: Prescription Upload
*/

global $current_user, $wp_roles, $userdata, $post, $paged;
$dir_obj = new DocDirect_Scripts();
$user_identity = $current_user->ID;
$url_identity = $user_identity;


get_header();
$errors = [];
$message = '';
if (isset($_POST['prescription_upload'])) {

    if (!empty($_FILES['prescription_file']['tmp_name'])) {
        $name = $_FILES['prescription_file']['name'];
        $explodes = explode('.', $name);
        $extension = end($explodes);

        $supportedFiles = ['pdf', 'docx', 'doc', 'jpg', 'jpeg', 'gif'];
        if (!in_array($extension, $supportedFiles)) {

            array_push($errors, '<p style="color: #de0f0f; font-size: 20px; background: #66BD23; padding: 10px 25px; height: 35px;">File is not supported</p>');

        } else {

            $source = $_FILES['prescription_file']['tmp_name'];
            $fileName = time() . (time() + 1) . '.' . $extension;
            $destination = 'wp-content/uploads/prescription/' . $fileName;
            $prescription_file = '';
            if (move_uploaded_file($source, $destination)) {
                $prescription_file = $fileName;
            }

            $first_name = esc_html($_POST['first_name']);
            $last_name = esc_html($_POST['last_name']);
            $email = esc_html($_POST['email']);
            $location = esc_html($_POST['location']);
            $mobile = esc_html($_POST['mobile']);
            $mobile_alternative = esc_html($_POST['mobile_alternative']);
            $note = esc_html($_POST['note']);
            global $wpdb;
            $table_name = "prescriptions";
            $message = '';


            $status = $wpdb->insert($table_name, array(
                'first_name' => $first_name,
                'last_name' => $last_name,
                'email' => $email,
                'location' => $location,
                'mobile' => $mobile,
                'mobile_alternative' => $mobile_alternative,
                'prescription_file' => $prescription_file,
                'note' => $note,
            ));
            if ($status) {
                $message = '<p style="font-size: 22px; color: #008000; text-align: center">Prescription Successfully uploaded. Please wait for response from us
</p>';
            }
        }
    }


}
?>
    <div class="container">
        <div class="">

            <?php
            if (!empty($message))
                echo $message;
            ?>

            <?php
            //            echo '<pre>';
            //            print_r($errors); exit;
            foreach ($errors as $error) {
                echo $error; ?>

            <?php }

            ?>
            <form action="<?= site_url('prescription-upload') ?>" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" name="first_name" class="form-control" placeholder="Enter your full name"
                                   required>
                        </div>
                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" name="last_name" class="form-control" placeholder="Enter your full name">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Enter email address here"
                                   required>
                        </div>
                        <div class="form-group">
                            <label>Location</label>
                            <input type="location" name="location" class="form-control"
                                   placeholder="Enter location here" required>
                        </div>

                    </div>
                    <div class="col-md-6">

                        <div class="form-group">
                            <label>Mobile</label>
                            <input type="mobile" name="mobile" class="form-control" placeholder="01XXXXXXXXX" required>
                        </div>
                        <div class="form-group">
                            <label>Alternative Mobile</label>
                            <input type="mobile" name="mobile_alternative" class="form-control"
                                   placeholder="01XXXXXXXXX">
                        </div>
                        <div class="form-group">
                            <label>Select Prescription File</label>
                            <input type="file" name="prescription_file" required>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Note </label>
                            <textarea name="note" cols="4" rows="4" class="form-control"
                                      placeholder="Enter note text here"></textarea>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" name="prescription_upload" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>

    </div>

<?php
get_footer();
?>