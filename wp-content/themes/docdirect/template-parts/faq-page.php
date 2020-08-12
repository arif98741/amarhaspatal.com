<?php
/*
Template Name: Faq Page
*/

global $current_user, $wp_roles, $userdata, $post, $paged;
$dir_obj = new DocDirect_Scripts();

get_header();
?>
    <div class="container">
        <div class="accordion" id="accordionExample">
            <div class="card">
                <h3 class="faq-heading">FAQ/NEED HELP</h3>
                <p class="faq-intro">

                    Please check the FAQs (Frequently Asked Questions) to get familiar with the functions of our
                    platform. If you are not satisfied with the answers, then please call us on +8801734500971 or write
                    to us at <a href="">support@amarhaspatal.com</a> between 9 am – 6 pm every day to get our immediate
                    help.
                </p>
                <br>

                <div class="card-header" id="headingOne">
                    <h2 class="mb-0">
                        <p data-toggle="collapse" data-target="#collapseOne"
                           aria-expanded="true" aria-controls="collapseOne">
                            What is Amar Hospital.com?
                        </p>
                    </h2>
                </div>

                <div id="collapseOne" class="collapse " aria-labelledby="headingOne"
                     data-parent="#accordionExample">
                    <div class="card-body">
                        AMAR HOSPITAL is an online platform for integrated medical services in Bangladesh. The service
                        is free of
                        cost and accessible to all kinds of people to get all sorts of health service online.
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header" id="headingTwo">
                    <h2 class="mb-0">
                        <p class="collapsed" data-toggle="collapse"
                           data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            What services do AMAR HOSPITAL provides? </p>
                    </h2>
                </div>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                    <div class="card-body">
                        It helps people-
                        <br> booking appointment for doctor’s checkup
                        <br> knowing the details of a specific hospital for medical treatment, its facilities, cost and
                        fees
                        <br> hiring or getting ambulance in emergency and booking for advance.

                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header" id="headingThree">
                    <h2 class="mb-0">
                        <p class="collapsed" data-toggle="collapse"
                           data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            How much the service charge is? </p>
                    </h2>
                </div>
                <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                    <div class="card-body">
                        The service is free of cost for patients. We only charge hospitals or health service providers.
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header" id="headingFour">
                    <h2 class="mb-0">
                        <p class="collapsed" data-toggle="collapse"
                           data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                            What languages Amar Hospital.com supports? </p>
                    </h2>
                </div>
                <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionExample">
                    <div class="card-body">
                        Our website supports English. We will add Bangla very soon. Our blog is written in Bangla for
                        better readership.
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header" id="headingFive">
                    <h2 class="mb-0">
                        <p class="collapsed" data-toggle="collapse"
                           data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                            Does Amar Hospital.com has any legal affiliation with the health service providers? </p>
                    </h2>
                </div>
                <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordionExample">
                    <div class="card-body">
                        We make patients connected with the health service providers. The patients reserve the right
                        to choose specific service from our database according to the need. The health service providers
                        provide services according to the rules and regulation and by the law of registration.
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header" id="headingSix">
                    <h2 class="mb-0">
                        <p class="collapsed" data-toggle="collapse"
                           data-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                            Can I contact anytime during a day/ 24 hour? </p>
                    </h2>
                </div>
                <div id="collapseSix" class="collapse" aria-labelledby="headingFive" data-parent="#accordionExample">
                    <div class="card-body">
                        Feel free to contact us anytime. We are happy to help you 24 hour a day, 7 days a week and 365
                        days in a year.
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header" id="headingSeven">
                    <h2 class="mb-0">
                        <p class="collapsed" data-toggle="collapse"
                           data-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                            Is the site mobile-friendly? </p>
                    </h2>
                </div>
                <div id="collapseSeven" class="collapse" aria-labelledby="headingFive" data-parent="#accordionExample">
                    <div class="card-body">
                        Yes. Use the site from your smartphone.
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header" id="headingEight">
                    <h2 class="mb-0">
                        <p class="collapsed" data-toggle="collapse"
                           data-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
                            Can I report an issue regarding hospital/doctor/ambulance service? </p>
                    </h2>
                </div>
                <div id="collapseEight" class="collapse" aria-labelledby="headingEight" data-parent="#accordionExample">
                    <div class="card-body">
                        Yes. You can rate the doctor and service providers’ services. You can tell us that you are
                        satisfied or not.
                        Our endeavor is to bring change for your ultimate satisfaction.
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header" id="headingNine">
                    <h2 class="mb-0">
                        <p class="collapsed" data-toggle="collapse"
                           data-target="#collapseNine" aria-expanded="false" aria-controls="collapseNine">
                            The website isn't working correctly. </p>
                    </h2>
                </div>
                <div id="collapseNine" class="collapse" aria-labelledby="headingNine" data-parent="#accordionExample">
                    <div class="card-body">
                        Let us know that you are facing problems. Try to use it from other browser or device.
                        We'll get back to you soon as we can with advice.
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header" id="headingTen">
                    <h2 class="mb-0">
                        <p class="collapsed" data-toggle="collapse"
                           data-target="#collapseTen" aria-expanded="false" aria-controls="collapseTen">
                            Is it free to join Amar Hospital.com as a health service provider?</p>
                    </h2>
                </div>
                <div id="collapseTen" class="collapse" aria-labelledby="headingTen" data-parent="#accordionExample">
                    <div class="card-body">
                        Yes. Joining Amar Hospital.com is free for all.
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header" id="headingEleven">
                    <h2 class="mb-0">
                        <p class="collapsed" data-toggle="collapse"
                           data-target="#collapseEleven" aria-expanded="false" aria-controls="collapseEleven">
                            How can I register in the service?</p>
                    </h2>
                </div>
                <div id="collapseEleven" class="collapse" aria-labelledby="headingEleven"
                     data-parent="#accordionExample">
                    <div class="card-body">
                        Click our sign up/ Register button then complete the details about you and create a password
                        (this should be longer than six characters and contain at least one number and one letter). A
                        mobile verification code will be send to your handset. Place the code and be sure all
                        information is correct. Then click the submit button. We will confirm you by SMS about the
                        password. Use the user id and password for further use and/or control your profile and/or make
                        comments.
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header" id="headingTwelve">
                    <h2 class="mb-0">
                        <p class="collapsed" data-toggle="collapse"
                           data-target="#collapseTwelve" aria-expanded="false" aria-controls="collapseTwelve">
                            How can I control my personal profile (doctor/hospital) page?</p>
                    </h2>
                </div>
                <div id="collapseTwelve" class="collapse" aria-labelledby="headingTwelve"
                     data-parent="#accordionExample">
                    <div class="card-body">
                        We provide a username and password after you sign up with our system so that you can control,
                        change or edit your profile or personal page.
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header" id="headingThirteen">
                    <h2 class="mb-0">
                        <p class="collapsed" data-toggle="collapse"
                           data-target="#collapseThirteen" aria-expanded="false" aria-controls="collapseThirteen">
                            Is my information secured?</p>
                    </h2>
                </div>
                <div id="collapseThirteen" class="collapse" aria-labelledby="headingThirteen"
                     data-parent="#accordionExample">
                    <div class="card-body">
                        All the information we collect is fully secured. We do not sell or transfer any information to
                        the third party.
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header" id="headingFourteen">
                    <h2 class="mb-0">
                        <p class="collapsed" data-toggle="collapse"
                           data-target="#collapseFourteen" aria-expanded="false" aria-controls="collapseFourteen">
                            Why can’t I log in?</p>
                    </h2>
                </div>
                <div id="collapseFourteen" class="collapse" aria-labelledby="headingFourteen"
                     data-parent="#accordionExample">
                    <div class="card-body">
                        In your web browser, make sure that you allow cookies from our system. Most web browsers have
                        cookie options under the privacy settings. Add our web address to allow cookies from our site.
                        This will permit our system to set a cookie so that you do not encounter any login issues. If
                        you still have problems logging in, check your system's date and time settings. If these
                        settings are not correct please change them and try logging in again.
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header" id="headingFifteen">
                    <h2 class="mb-0">
                        <p class="collapsed" data-toggle="collapse"
                           data-target="#collapseFifteen" aria-expanded="false" aria-controls="collapseFifteen">
                            I have forgotten my user id?</p>
                    </h2>
                </div>
                <div id="collapseFifteen" class="collapse" aria-labelledby="headingFifteen"
                     data-parent="#accordionExample">
                    <div class="card-body">
                        We use your mobile number as your user id. Please see that if there is any number missing or
                        misplacement when logging in.
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header" id="headingSixteen">
                    <h2 class="mb-0">
                        <p class="collapsed" data-toggle="collapse"
                           data-target="#collapseSixteen" aria-expanded="false" aria-controls="collapseSixteen">
                            What should I do if forget my password?</p>
                    </h2>
                </div>
                <div id="collapseSixteen" class="collapse" aria-labelledby="headingSixteen"
                     data-parent="#accordionExample">
                    <div class="card-body">
                        Make sure CAPS LOCK key is not pressed by mistake, because your password is case sensitive.
                        If you still can't sign in: <br>
                        >> Click Forgot my password.<br>
                        >> Enter the mobile number you used to create the account.<br>
                        >> Check your mobile message box to get the password.

                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header" id="headingSeventeen">
                    <h2 class="mb-0">
                        <p class="collapsed" data-toggle="collapse"
                           data-target="#collapseSeventeen" aria-expanded="false" aria-controls="collapseSeventeen">
                            How can I book doctor’s appointment?</p>
                    </h2>
                </div>
                <div id="collapseSeventeen" class="collapse" aria-labelledby="headingSeventeen"
                     data-parent="#accordionExample">
                    <div class="card-body">
                        You can do it in two ways. <br>
                        >> First, find your desired doctor, go his/her individual page. Grab the schedule and book
                        online. We will let you know that your booking is confirmed. <br>
                        >> In another way, call us in our phone number (+09666 77 22 88). We will do the rest for you.


                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header" id="headingEighteen">
                    <h2 class="mb-0">
                        <p class="collapsed" data-toggle="collapse"
                           data-target="#collapseEighteen" aria-expanded="false" aria-controls="collapseEighteen">
                            Can I book doctor’s appointment a few days earlier?</p>
                    </h2>
                </div>
                <div id="collapseEighteen" class="collapse" aria-labelledby="headingEighteen"
                     data-parent="#accordionExample">
                    <div class="card-body">
                        Yes. Go to the doctor’s individual page, find the schedule and book appointment.


                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header" id="headingNineteen">
                    <h2 class="mb-0">
                        <p class="collapsed" data-toggle="collapse"
                           data-target="#collapseNineteen" aria-expanded="false" aria-controls="collapseNineteen">
                            Can I book an appointment on behalf of others?</p>
                    </h2>
                </div>
                <div id="collapseNineteen" class="collapse" aria-labelledby="headingNineteen"
                     data-parent="#accordionExample">
                    <div class="card-body">
                        You can do it for anyone.

                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header" id="headingTwenty">
                    <h2 class="mb-0">
                        <p class="collapsed" data-toggle="collapse"
                           data-target="#collapseTwenty" aria-expanded="false" aria-controls="collapseTwenty">
                            Is there a cost for me to make an appointment?</p>
                    </h2>
                </div>
                <div id="collapseTwenty" class="collapse" aria-labelledby="headingTwenty"
                     data-parent="#accordionExample">
                    <div class="card-body">
                        No, the system is totally free for any patient to make an appointment.

                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header" id="headingTwentyone">
                    <h2 class="mb-0">
                        <p class="collapsed" data-toggle="collapse"
                           data-target="#collapseTwentyone" aria-expanded="false" aria-controls="collapseTwentyone">
                            Can I make an appointment via my smart phone?</p>
                    </h2>
                </div>
                <div id="collapseTwentyone" class="collapse" aria-labelledby="headingTwentyone"
                     data-parent="#accordionExample">
                    <div class="card-body">
                        Yes, you can do this.

                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header" id="headingTwentytwo">
                    <h2 class="mb-0">
                        <p class="collapsed" data-toggle="collapse"
                           data-target="#collapseTwentytwo" aria-expanded="false" aria-controls="collapseTwentytwo">
                            Do I need register to book doctor’s appointment?</p>
                    </h2>
                </div>
                <div id="collapseTwentytwo" class="collapse" aria-labelledby="headingTwentytwo"
                     data-parent="#accordionExample">
                    <div class="card-body">
                        It is mandatory.

                    </div>
                </div>
            </div>


            <div class="card">
                <div class="card-header" id="headingTwentythree">
                    <h2 class="mb-0">
                        <p class="collapsed" data-toggle="collapse"
                           data-target="#collapseTwentythree" aria-expanded="false" aria-controls="collapseTwentythree">
                            Can I negotiate doctor’s fee?</p>
                    </h2>
                </div>
                <div id="collapseTwentythree" class="collapse" aria-labelledby="headingTwentythree"
                     data-parent="#accordionExample">
                    <div class="card-body">
                        Doctor’s fees are determined by the respective doctors. We suggest not negotiating doctor’s fee.

                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header" id="headingTwentyfour">
                    <h2 class="mb-0">
                        <p class="collapsed" data-toggle="collapse"
                           data-target="#collapseTwentyfour" aria-expanded="false" aria-controls="collapseTwentyfour">
                            Can I get all information regarding expenses before going to the hospital?</p>
                    </h2>
                </div>
                <div id="collapseTwentyfour" class="collapse" aria-labelledby="headingTwentyfour"
                     data-parent="#accordionExample">
                    <div class="card-body">
                        The website is designed to help you know the hospital better. We try to let you know all
                        information regarding the services the hospital provide, the cost and fees, the specialized
                        doctors of the hospital and their expertise. The hospital location is made clear so that you can
                        reach the nearest hospital to save time and ultimately a LIFE.
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header" id="headingTwentyfive">
                    <h2 class="mb-0">
                        <p class="collapsed" data-toggle="collapse"
                           data-target="#collapseTwentyfive" aria-expanded="false" aria-controls="collapseTwentyfive">
                            Can I calculate my expense during the stay at hospital?</p>
                    </h2>
                </div>
                <div id="collapseTwentyfive" class="collapse" aria-labelledby="headingTwentyfive"
                     data-parent="#accordionExample">
                    <div class="card-body">
                        Yes. Use the calculator in the hospital page to calculate the expense.
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header" id="headingTwentysix">
                    <h2 class="mb-0">
                        <p class="collapsed" data-toggle="collapse"
                           data-target="#collapseTwentysix" aria-expanded="false" aria-controls="collapseTwentysix">
                            Can I negotiate hospital expenses?</p>
                    </h2>
                </div>
                <div id="collapseTwentysix" class="collapse" aria-labelledby="headingTwentysix"
                     data-parent="#accordionExample">
                    <div class="card-body">
                        You can negotiate hospital cost and fee but in few extent. Some hospital authorities prefers
                        negotiation and others not.
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header" id="headingTwentyseven">
                    <h2 class="mb-0">
                        <p class="collapsed" data-toggle="collapse"
                           data-target="#collapseTwentyseven" aria-expanded="false" aria-controls="collapseTwentyseven">
                            How can I hire an ambulance?</p>
                    </h2>
                </div>
                <div id="collapseTwentyseven" class="collapse" aria-labelledby="headingTwentyseven"
                     data-parent="#accordionExample">
                    <div class="card-body">
                        Call us at our phone number. Let us know the details about your place and the destination and
                        the patient’s condition. We will provide you the nearest and convenient ambulance in a shorter
                        time.
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header" id="headingTwentyeight">
                    <h2 class="mb-0">
                        <p class="collapsed" data-toggle="collapse"
                           data-target="#collapseTwentyeight" aria-expanded="false" aria-controls="collapseTwentyeight">
                            What time does it take to get the ambulance?</p>
                    </h2>
                </div>
                <div id="collapseTwentyeight" class="collapse" aria-labelledby="headingTwentyeight"
                     data-parent="#accordionExample">
                    <div class="card-body">
                        AMAR HOSPITAL currently provides the ground ambulance only. According to the needs of our
                        patients, there are Basic life support ambulances, critical care transport ambulances. <br>
                        >> AC Ambulance<br>
                        >> Non- AC Ambulance<br>
                        >> Freezer Van<br>
                        >> ICU Ambulance<br>
                        >> Air Ambulances,
                        are available.

                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header" id="headingTwentynine">
                    <h2 class="mb-0">
                        <p class="collapsed" data-toggle="collapse"
                           data-target="#collapseTwentynine" aria-expanded="false" aria-controls="collapseTwentynine">
                            What time does it take to get the ambulance?</p>
                    </h2>
                </div>
                <div id="collapseTwentynine" class="collapse" aria-labelledby="headingTwentynine"
                     data-parent="#accordionExample">
                    <div class="card-body">
                        We have make arrangements to let you have the ambulance that is nearest you so that you can save
                        time and reach the hospital in the least possible time to save the life of you or the one you
                        love.

                    </div>
                </div>
            </div>


        </div>


    </div>


<?php
get_footer();
?>