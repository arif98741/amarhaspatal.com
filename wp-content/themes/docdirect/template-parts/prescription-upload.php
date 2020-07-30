<?php
/*
Template Name: Prescription Upload
*/
//echo '<pre>';
//print_r($current_user); exit;

//exit;
get_header();
$errors = [];
$message = '';
global $wp;

if (isset($_POST['prescription_upload'])) {

    if (!empty($_FILES['prescription_file']['tmp_name'])) {
        $file = $_FILES['prescription_file']['name'];
        $explodes = explode('.', $file);
        $extension = end($explodes);

        $supportedFiles = ['pdf', 'docx', 'doc', 'jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($extension, $supportedFiles)) {
            array_push($errors, '<p style="color: #de0f0f; font-size: 20px; background: #66bd23; padding: 10px 25px; height: 35px;">File is not supported</p>');
        }

        if ($_FILES['prescription_file']['size'] > 4194304) { //4MB
            array_push($errors, '<p style="color: #de0f0f; font-size: 20px; background: #66bd23; padding: 10px 25px; height: 35px;">You should select file less than 4MB</p>');
        }

        if (count($errors) == 0) {

            $source = $_FILES['prescription_file']['tmp_name'];
            $fileName = time() . (time() + 1) . '.' . $extension;
            $destination = 'wp-content/uploads/prescription/' . $fileName;
            $prescription_file = '';
            if (move_uploaded_file($source, $destination)) {
                $prescription_file = $fileName;
            }

            $name = esc_html($_POST['user_name']);
            $email = esc_html($_POST['user_email']);
            $location = esc_html($_POST['user_address']);
            $mobile = esc_html($_POST['user_mobile']);
            $mobile_alternative = esc_html($_POST['user_mobile_alternative']);
            $note = esc_html($_POST['user_note']);
            global $wpdb;
            $table_name = "prescriptions";
            $message = '';

            $status = $wpdb->insert($table_name, array(
                'name' => $name,
                'email' => $email,
                'address' => $location,
                'mobile' => $mobile,
                'mobile_alternative' => $mobile_alternative,
                'prescription_file' => $prescription_file,
                'note' => $note,
            ));
            if ($status) {
                $message = '<p style="font-size: 22px; color: #008000; text-align: center">Prescription Successfully uploaded. Please wait for getting response from us
</p>';
            }
        }
    }
}
?>
<div class="container">
    <h3>Prescription Upload </h3>
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
        <?php } ?>
        <form name="form-name" method="POST" action="<?php echo site_url('prescription-upload-page'); ?>"
              enctype="multipart/form-data">
            <?php if (is_user_logged_in()) {
                $user = $current_user;
                $userdata = $user->data;
                $userMeta = get_user_meta($userdata->ID);

                ?>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Name Input</label>
                            <input type="text" name="user_name"
                                   value="<?php echo $userMeta['first_name'][0] . ' ' . $userMeta['last_name'][0] ?>"
                                   class="form-control"
                                   placeholder="Enter your full name"
                                   required>
                        </div>
                        <div class="form-group">
                            <label>Email Address</label>
                            <input type="text" name="user_email" value="<?php echo $userdata->user_email ?>"
                                   class="form-control"
                                   placeholder="Enter email address here"
                                   required>
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" value="<?php echo $userMeta['user_address'][0] ?>"
                                   name="user_address" class="form-control"
                                   placeholder="Enter address here" required>
                        </div>

                    </div>
                    <div class="col-md-6">

                        <div class="form-group">
                            <label>Mobile</label>
                            <input type="mobile" name="user_mobile" class="form-control"
                                   value="<?php echo $userMeta['phone_number'][0] ?>" placeholder="01XXXXXXXXX"
                                   required>
                        </div>
                        <div class="form-group">
                            <label>Alternative Mobile</label>
                            <input type="mobile" name="user_mobile_alternative" class="form-control"
                                   placeholder="01XXXXXXXXX">
                        </div>
                        <div class="form-group">
                            <label>Select Prescription File</label>
                            <input type="file" name="prescription_file" required>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Note </label>
                            <textarea name="user_note" cols="4" rows="4" class="form-control"
                                      placeholder="Enter note text here"></textarea>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                    <div class="col-md-3">
                        <div class="">
                            <button type="submit" name="prescription_upload" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </div>
                <?php
            } else {
                ?>
                <div class="card">
                    <div class="card-body">


                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" name="user_name" class="form-control"
                                           placeholder="Enter your name"
                                           required>
                                </div>

                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="user_email" class="form-control"
                                           placeholder="Enter email address here"
                                           required>
                                </div>
                                <div class="form-group">
                                    <label>Address</label>
                                    <input type="test" name="user_address" class="form-control"
                                           placeholder="Enter address here" required>
                                </div>

                            </div>
                            <div class="col-md-6">

                                <div class="form-group">
                                    <label>Mobile</label>
                                    <input type="mobile" name="user_mobile" class="form-control"
                                           placeholder="01XXXXXXXXX"
                                           required>
                                </div>
                                <div class="form-group">
                                    <label>Alternative Mobile</label>
                                    <input type="mobile" name="user_mobile_alternative" class="form-control"
                                           placeholder="01XXXXXXXXX">
                                </div>
                                <div class="form-group">
                                    <label>Select Prescription File</label>
                                    <input type="file" name="prescription_file" required>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Note </label>
                                    <textarea name="user_note" cols="4" rows="4" class="form-control"
                                              placeholder="Enter note text here"></textarea>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-md-3">
                                <button type="submit" name="prescription_upload" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </form>
    </div>

</div>

<?php
get_footer();
?>
