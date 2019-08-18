<?php
/*
Template Name: Template Page 4

This is a copy of the standard "page" template, but exists to allow some
deviations to standard pages

*/

get_header();

/**
 * get all the settings needed for the the template layout
 *
 * returns:
 * $template
 * $main_width
 * $hide_content
 * $sidebar_position
 *
 */
extract(benjamin_template_settings());

if (!$hide_content) :
    ?>

<section id="primary" class="usa-grid usa-section">

    <?php
        if ($sidebar_position == 'left') :
            benjamin_get_sidebar($template, $sidebar_position, $sidebar_size);
        endif;
        ?>
    <div class="main-content <?php echo esc_attr($main_width); ?>">
        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">

        <style>
            .required {
                color: red;
            }
        </style>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <script>
            $(function() {
                $(".datepicker").datepicker();
            });
        </script>


        <form>

            <div>
                <h3>Business or Personal</h3>
                <div>
                    <p>Are you reporting on behalf of a business?<span class="required">*</span></p>
                    <input type="radio" name="business-report" id="business-report-yes" value="true" required>
                    <label for="business-report-yes">Yes</label>
                    <input type="radio" name="business-report" id="business-report-no" value="false" required>
                    <label for="business-report-no">No</label>
                </div>
            </div>
            <hr>

            <div>
                <h3>Are you self-reporting, or reporting on behalf of someone else?</h3>
                <div>
                    <p>Are you reporting an online incident, crime, scam, or a victimization of behalf of another person such as a
                        parent, relative, or grandparent?<span class="required">*</span></p>
                    <input type="radio" name="behalf-of-others-yes" value="true" required>
                    <label for="behalf-of-others-yes">Yes</label>
                    <input type="radio" name="behalf-of-others-no" value="false" required>
                    <label for="behalf-of-others-no">No</label>
                </div>
            </div>
            <hr>


            <div>
                <h3>Tell us what happened.</h3>
                <div>
                    <p>Please describe the incident in your own words.<span class="required">*</span></p>
                    <textarea required></textarea>
                </div>

                <div>
                    <p>When did the incident occur?<span class="required">*</span></p>
                    <input type="text" class="datepicker" required>
                </div>

                <div>
                    <script>
                        $(document).ready(function() {
                            $('#ocurred-multiple-yes').change(function() {
                                if (this.checked) {
                                    $('#more-dates').append('<br><input type="text" class="datepicker" required>');
                                    $('#more-dates').append('<br><input type="text" class="datepicker" required>');
                                    $('#more-dates').append('<br><input type="text" class="datepicker" required>');
                                }
                            });
                            $('#ocurred-multiple-no').change(function() {
                                if (this.checked) {
                                    $('#more-dates').empty();
                                }
                            });
                        })
                    </script>
                    <p>Did the incident occur multiple times. If yes, please list additional dates and times.</p>
                    <label>Yes
                        <input type="radio" id="ocurred-multiple-yes" name="occurred-multiple" value="true">
                    </label>
                    <label>No
                        <input type="radio" id="ocurred-multiple-no" name="occurred-multiple" value="false" checked>
                    </label>

                    <input type="text" class="datepicker" required>

                    <div id="more-dates"></div>

                </div>

                <div>
                    <p>How would you categorize the incident?<span class="required">*</span></p>
                    <div>
                        <input type="checkbox" name="financial-fraud" value="financial fraud" required>
                        <label for="financial-fraud">Financial fraud</label>
                    </div>
                    <div>
                        <input type="checkbox" name="identity-theft">
                        <label for="identity-theft">Identity theft</label>
                    </div>
                    <div>
                        <input type="checkbox" name="romance-scam">
                        <label for="romance-scam">Romance scam</label>
                    </div>
                    <div>
                        <input type="checkbox" name="bullying">
                        <label for="bullying">Bullying</label>
                    </div>
                    <div>
                        <input type="checkbox" name="hate-speech">
                        <label for="hate-speech">Hate speech</label>
                    </div>
                    <div>
                        <input type="checkbox" name="online-threat">
                        <label for="online-threat">Online threat</label>
                    </div>
                    <div>
                        <input type="checkbox" name="blackmail">
                        <label for="blackmail">Blackmail</label>
                    </div>
                    <div>
                        <input type="checkbox" name="other">
                        <label for="other">Other</label>
                    </div>
                </div>

            </div>
            <hr>

            <div>
                <script>
                    $(document).ready(function() {
                        $('#witnesses-yes').change(function() {
                            if (this.checked) {
                                $('#witnesses-names').show();
                            }
                        });
                        $('#witnesses-no').change(function() {
                            if (this.checked) {
                                $('#witnesses-names').hide();
                            }
                        });
                    })
                </script>
                <p>Are there witnesses or victims to this incident?</p>
                <input type="radio" name="witnesses" id="witnesses-yes" value="true">
                <label for="witnesses-yes">Yes</label>
                <input type="radio" name="witnesses" id="witnesses-no" value="false" checked>
                <label for="witnesses-no">No</label>

                <div id="witnesses-names" style="display:none;">
                    <p> Please provide their names.</p>
                    <input type="text" id="witnesses-names">
                </div>
            </div>

            <div>
                <script>
                    $(document).ready(function() {
                        $('#fraud-vector').change(function() {
                            // Eagerly hide because we don't know prior seleciton
                            $('#extra-vector-info').children().hide();
                            var selection = $('#fraud-vector').val();
                            $('#picked-' + selection).show();
                        })
                    });
                </script>
                <h3>How did the incident occur?</h3>
                <div>
                    <p>How did the incident occur?<span class="required">*</span></p>
                    <select id="fraud-vector" required>
                        <option value="">--Please choose an option--</option>
                        <option value="home-phone">Home phone</option>
                        <option value="mobile-phone">Mobile phone</option>
                        <option value="email">Email</option>
                        <option value="social-network">Social network</option>
                        <option value="messaging-app">Messaging app</option>
                        <option value="online-dating">Online dating service</option>
                        <option value="cash-app">Cash app</option>
                        <option value="voice-assisstant">Voice assistant</option>
                        <option value="other">Other</option>
                    </select>

                    <div id="extra-vector-info">
                        <div id="picked-home-phone" style="display:none">
                            <p>Please enter your phone number and the alleged perpetrator's number, if available.</p>
                            <label>Your phone number:
                                <input type="tel">
                            </label>
                            <label>Their phone number:
                                <input type="tel">
                            </label>
                        </div>
                        <div id="picked-mobile-phone" style="display:none">
                            <p>Please enter your phone number and the alleged perpetrator's number, if available.</p>
                            <label>Your phone number:
                                <input type="tel">
                            </label>
                            <label>Their phone number:
                                <input type="tel">
                            </label>
                        </div>
                        <div id="picked-email" style="display:none">
                            <label>Your email:
                                <input type="email" />
                            </label>
                            <label>Your email:
                                <input type="email">
                            </label>
                        </div>
                        <div id="picked-social-network" style="display:none">
                            <label>Please select the social network:
                                <select required>
                                    <option value="">--Please choose an option--</option>
                                    <option>Facebook</option>
                                    <option>Twitter</option>
                                    <option>Instagram</option>
                                    <option>Pinterest</option>
                                    <option>Ello</option>
                                    <option value="other">Other</option>
                                </select>
                            </label>
                            <p>Please enter your username and the alleged perpetrator's username, if available.</p>
                            <label>Your user name:
                                <input type="text">
                            </label>
                            <label>Their user name:
                                <input type="text">
                            </label>
                        </div>
                    </div>
                </div>

            </div>

            <div>
                <p>Please enter (or copy+paste) the initial text that was used to contact you.</p>
                <textarea></textarea>
            </div>
            <!-- <div>
        <p>Please enter your phone number and the alleged perpetrator's phone number, if available.</p>
        <label for="your-phone">Your phone number:</label>
        <input type="tel" name="your-phone">
        <label for="their-phone">Their phone number:</label>
        <input type="tel" name="their-phone">
      </div> -->

            <div>
                <p>Did the incident involve a financial transaction such as transferring funds?<span class="required">*</span>
                </p>
                <input type="radio" name="funds-transferred" id="funds-transferred-yes" value="true" required>
                <label for="funds-transferred-yes">Yes</label>
                <input type="radio" name="funds-transferred" id="funds-transferred-false" value="false" required>
                <label for="funds-transferred-no">No</label>
            </div>


            <div>
                <p>Please enter your user name and the alleged perpetrator's user name, if available.</p>
                <label for="your-username">Your username:</label>
                <input name="your-username" type="text">
                <label for="their-username">Their username:</label>
                <input name="their-username" type="text">
            </div>


    </div>

    <div>
        <p>What is your username?</p>
        <input type="text">
    </div>
    </form>


    </div>
    <?php
        if ($sidebar_position == 'right') :
            benjamin_get_sidebar($template, $sidebar_position, $sidebar_size);
        endif;
        ?>

</section>

<?php
endif;


get_footer();
