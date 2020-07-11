<?php
/*
Template Name: Custom User Page
*/
get_header();
?>
<div class="full-width">
    <div class="col-md-offset-3 col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="registration-page-wrap tg-haslayout">
            <div class="doc-section-heading"><h2>Sign Up</h2>
                <span>Create New User</span>
            </div>
            <form class="tg-form-modal tg-form-signup do-registration-form">
                <fieldset>
                    <div class="form-group">
                        <input type="text" name="user_type" value="professional" style="display: none" class="form-control" placeholder="Username">
                    </div>

                    <div class="form-group user-types" style="display: block;">
                        <select name="directory_type" required>
                            <option value="0">Select User Type</option>
<!--                            <option value="125">Clinic</option>-->
                            <option value="123">Ambulance</option>
                            <option value="121">Diagnostics</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" name="username" class="form-control" placeholder="Username">
                    </div>

                    <!--                                            changes from here-->
                    <div class="form-group">
                        <input type="email" name="email" class="form-control" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <input type="text" name="first_name" placeholder="First Name" class="form-control">
                    </div>
                    <div class="form-group">
                        <input type="text" name="last_name" placeholder="Last Name" class="form-control">
                    </div>
                    <div class="form-group">
                        <input type="text" name="phone_number" class="form-control" placeholder="Phone Number">
                    </div>

                    <div class="form-group">
                        <input type="password" name="password" class="form-control" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <input type="password" name="confirm_password" class="form-control"
                               placeholder="Confirm Password">

                    </div>
                    <div class="form-group">
                        <select name="division_id" id="division_id" class="form-control">
                            <option>Select Division</option>

                            <option value="1">Barisal</option>

                            <option value="2">Chittagong</option>

                            <option value="3">Dhaka</option>

                            <option value="4">Khulna</option>

                            <option value="5">Rajshahi</option>

                            <option value="6">Rangpur</option>

                            <option value="7">Sylhet</option>

                            <option value="9">Mymensingh</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <select name="district_id" id="district_id" class="form-control">
                            <option value="">Select District</option>

                        </select>
                    </div>
                    <div class="form-group">

                        <select name="upazila_id" id="upazila_id" class="form-control">
                            <option>Select Upazila</option>
                        </select>
                    </div>

                    <div style="display: none" class="form-group">
                        <select name="union_id" id="union_id" class="form-control">
                            <option value="">Select Union</option>
                            <option>Dhaka</option>
                        </select>
                    </div>

                    <button class="tg-btn tg-btn-lg  do-register-button" type="button">Add New User</button>
                </fieldset>
            </form>
        </div>
    </div>
</div>
<?php
get_footer();
?>

