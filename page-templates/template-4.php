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

        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
        <form>
            <div>
                <h3>Business or Personal</h3>
                <div>
                    <p>Are you reporting on behalf of a business?</p>
                    <input type="radio" name="business-report" id="business-report-yes" value="true">
                    <label for="business-report-yes">Yes</label>
                    <input type="radio" name="business-report" id="business-report-no" value="false">
                    <label for="business-report-no">No</label>
                </div>
            </div>
            <hr>

            <div>
                <h3>Are you self-reporting, or reporting on behalf of someone else?</h3>
                <div>
                    <p>Are you reporting an online incident, crime, scam, or a victimization of behalf of another person such as a
                        parent, relative, or grandparent?</p>
                    <input type="radio" name="behalf-of-others-yes" value="true">
                    <label for="behalf-of-others-yes">Yes</label>
                    <input type="radio" name="behalf-of-others-no" value="false">
                    <label for="behalf-of-others-no">No</label>
                </div>
            </div>
            <hr>


            <div>
                <h3>Tell us what happened.</h3>
                <div>
                    <p>Please describe the incident in your own words.</p>
                    <textarea></textarea>
                </div>

                <div>
                    <p>When did the incident occur?</p>
                    <h4>TODO: jQuery UI datepicker</h4>
                </div>

                <div>
                    <p>Did the incident occur multiple times. If yes, please list additional dates and times.</p>
                    <h4>TODO: jQuery UI datepicker</h4>
                    <h4>Also will need to figure out how this relation will be stored in the DB</h4>
                </div>

                <div>
                    <p>How would you categorize the incident?</p>
                    <div>
                        <input type="checkbox" name="financial-fraud" value="financial fraud">
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
                <p>Are there witnesses or victims to this incident?</p>
                <input type="radio" name="witnesses" id="witnesses-yes" value="true">
                <label for="witnesses-yes">Yes</label>
                <input type="radio" name="witnesses" id="witnesses-no" value="false">
                <label for="witnesses-no">No</label>
            </div>

            <div>
                <h3>How did the incident occur?</h3>
                <div>
                    <p>How did the incident occur?</p>
                    <select required>
                        <option value="">--Please choose an option--</option>
                        <option value="home-phone">Home Phone</option>
                        <option value="mobile-phone">Mobile-phone</option>
                        <option value="email">Email</option>
                        <option value="social-network">Social network</option>
                        <option value="messaging-app">Messaging app</option>
                        <option value="online-dating">Online dating service</option>
                        <option value="cash-app">Cash app</option>
                        <option value="voice-assisstant">Voice assistant</option>
                        <option value="other">Other</option>
                    </select>
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

                <p>Did the incident involve a financial transaction such as transferring funds?</p>
                <input type="radio" name="funds-transferred" id="funds-transferred-yes" value="true">
                <label for="funds-transferred-yes">Yes</label>
                <input type="radio" name="funds-transferred" id="funds-transferred-false" value="false">
                <label for="funds-transferred-no">No</label>
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
