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
   
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script>
        $(function () {
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
            $(document).ready(function () {
                $('#ocurred-multiple-yes').change(function () {
                if (this.checked) {
                    $('#more-dates').append('<br><input type="text" class="datepicker" required>');
                    $('#more-dates').append('<br><input type="text" class="datepicker" required>');
                    $('#more-dates').append('<br><input type="text" class="datepicker" required>');
                }
                });
                $('#ocurred-multiple-no').change(function () {
                if (this.checked) {
                    $('#more-dates').empty();
                }
                });
            }
            )
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
            $(document).ready(function () {
            $('#witnesses-yes').change(function () {
                if (this.checked) {
                $('#witnesses-names').show();
                }
            });
            $('#witnesses-no').change(function () {
                if (this.checked) {
                $('#witnesses-names').hide();
                }
            });
            }
            )
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
            $(document).ready(function () {
            $('#fraud-vector').change(function () {
                // Eagerly hide because we don't know prior seleciton
                $('#extra-vector-info').children().hide();
                var selection = $('#fraud-vector').val();
                $('#picked-' + selection).show();
            })
            });

        </script>
        <h3>How did the incident occur?</h3>
        <div>
            <div>
            <p>Please enter (or copy+paste) the initial text that was used to contact you.</p>
            <textarea></textarea>
            </div>
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
            <div id="picked-messaging-app" style="display:none;">
                <label>Please select the messaging app:
                <select>
                    <option value="">--Please choose an option--</option>
                    <option>WhatsApp</option>
                    <option>Telegram</option>
                    <option>Signal</option>
                    <option>WeChat</option>
                    <option>iMessage</option>
                    <option>SnapChat</option>
                    <option>Skype</option>
                    <option>Facetime</option>
                    <option>Hangouts</option>
                    <option>Other</option>
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
            <div id="picked-online-dating" style="display:none;">
                <label>Please select the dating app:
                <select>
                    <option value="">--Please choose an option--</option>
                    <option>Tinder</option>
                    <option>Match</option>
                    <option>OKCupid</option>
                    <option>Bumble</option>
                    <option>MeetMe</option>
                    <option>Other</option>
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
            <div id="picked-cash-app" style="display:none;"></div>
            <div id="picked-voice-assisstant" style="display:none;">
                <label>Please select the assisstant :
                <select>
                    <option value="">--Please choose an option--</option>
                    <option>Alexa</option>
                    <option>Google</option>
                    <option>Siri</option>
                    <option>Cortana</option>
                    <option>Bixby</option>
                    <option>Other</option>
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
        <script>
            $(document).ready(function () {
            $('#funds-transferred-yes').change(function () {
                if (this.checked) {
                $('#funds-transferred-info').show();
                }
            });
            $('#funds-transferred-no').change(function () {
                if (this.checked) {
                $('#funds-transferred-info').hide();
                }
            });
            }
            )
        </script>
        <p>Did the incident involve a financial transaction such as transferring funds?<span class="required">*</span>
        </p>
        <label for="funds-transferred-yes">Yes</label>
        <input type="radio" name="funds-transferred" id="funds-transferred-yes" value="true" required>
        <label for="funds-transferred-no">No</label>
        <input type="radio" name="funds-transferred" id="funds-transferred-false" value="false" required checked>

        <div id="funds-transferred-info" style="display:none;">
            <label>What was the total amount of the transaction?
            <input type="text">
            </label>
            <p>Did you use a cash payment service?</p>
            <script>
            $(document).ready(function () {
                $('#cash-payment-service-yes').change(function () {
                if (this.checked) {
                    $('#cash-payment-service-info').show();
                }
                });
                $('#cash-payment-service-no').change(function () {
                if (this.checked) {
                    $('#cash-payment-service-info').hide();
                }
                });
            }
            )
            </script>
            <label>Yes
            <input type="radio" name="cash-payment-service" id="cash-payment-service-yes" value="true">
            </label>
            <label>No
            <input type="radio" name="cash-payment-service" id="cash-payment-service-no" value="false" checked>
            </label>

            <div id="cash-payment-service-info" style="display:none;">
            <select>
                <option value="">--Please choose an option--</option>
                <option>Venmo</option>
                <option>CashApp</option>
                <option>ApplePay</option>
                <option>GooglePay</option>
                <option>Square</option>
                <option>Paypal</option>
                <option>Other</option>
            </select>

            <label>Your user name, if available:
                <input type="text">
            </label>
            <label>Their user name, if available:
                <input type="text">
            </label>
            </div>

            <div id="bank-info">
            <p>If the transaction involved a bank, please provide YOUR account information:</p>
            <label>Your name:
                <input type="text" placeholder="Your name">
            </label>
            <label>Your account number:
                <input type="text" placeholder="Your account number">
            </label>
            <p>Bank name and address:</p>
            <input type="text" placeholder="Bank name">
            <input type="text" placeholder="Street name and number">
            <input type="text" placeholder="City">
            <input type="text" placeholder="State">
            <input type="text" placeholder="ZIP">
            <input type="text" placeholder="Country">

            <p>And now, the information of the recepient's bank, if available:</p>
            <label>Their name:
                <input type="text" placeholder="Their name">
            </label>
            <label>Their account number:
                <input type="text" placeholder="Their account number">
            </label>
            <p>Bank name and address:</p>
            <input type="text" placeholder="Bank name">
            <input type="text" placeholder="Street name and number">
            <input type="text" placeholder="City">
            <input type="text" placeholder="State">
            <input type="text" placeholder="ZIP">
            <input type="text" placeholder="Country">
            </div>

            <script>
            $(document).ready(function () {
                $('#offline-payment-service-yes').change(function () {
                if (this.checked) {
                    $('#offline-payment-service-info').show();
                }
                });
                $('#offline-payment-service-no').change(function () {
                if (this.checked) {
                    $('#offline-payment-service-info').hide();
                }
                });
            }
            )
            </script>
            <p>Were the funds transferred via an offline service?</p>
            <label>Yes
            <input type="radio" name="offline-payment-service" id="offline-payment-service-yes" value="true">
            </label>
            <label>No
            <input type="radio" name="offline-payment-service" id="offline-payment-service-no" value="false" checked>
            </label>

            <div id="offline-payment-service-info" style="display:none;">
            <select>
                <option value="">--Please choose an option--</option>
                <option>Western Union</option>
                <option>Wire transfer</option>
                <option>Direct transfer</option>
                <option>Other</option>
            </select>

            <p>Please provide the recipient's information:</p>
            <label>Recipient name:
                <input type="text">
            </label>
            <label>SWIFT code (if available)
                <input type="text">
            </label>
            <p>Bank name and address:</p>
            <input type="text" placeholder="Bank name">
            <input type="text" placeholder="Street name and number">
            <input type="text" placeholder="City">
            <input type="text" placeholder="State">
            <input type="text" placeholder="ZIP">
            <input type="text" placeholder="Country">
            </div>

        </div>


        <hr>
        <div>

            <h3>Alleged perpetrator information, if available:</h3>
            <div>
            <label>Relation to victim:
                <select>
                <option>Son</option>
                <option>Daughter</option>
                <option>Grandson</option>
                <option>Granddaughter</option>
                <option>Sibling</option>
                <option>Other relative</option>
                <option>Other</option>
                </select>
            </label>
            <label>First name
                <input type="text">
            </label>
            <label>Middle name
                <input type="text">
            </label>
            <label>Last name
                <input type="text">
            </label>
            <label>Business name
                <input type="text">
            </label>
            <label>Street address
                <input type="text">
            </label>
            <label>Street address 2
                <input type="text">
            </label>
            <label>City
                <input type="text">
            </label>
            <label>State
                <input type="text">
            </label>
            <label>ZIP Code
                <input type="text">
            </label>
            <label>Country
                <input type="text">
            </label>
            <label>Phone Number
                <input type="tel">
            </label>
            <label>Email address
                <input type="email">
            </label>
            <label>Website
                <input type="text">
            </label>
            <label>IP Address
                <input type="text">
            </label>
            <label>Photo of prerpetrator
                <input type="file">
            </label>
            <label>Anything we missed that might be helpful?
                <textarea></textarea>
            </label>
            </div>
        </div>


        <hr>
        <div>

            <h3>Victim contact information</h3>
            <div>
            <label>First name
                <input type="text">
            </label>
            <label>Middle name
                <input type="text">
            </label>
            <label>Last name
                <input type="text">
            </label>
            <label>Business name
                <input type="text">
            </label>
            <label>Street address
                <input type="text">
            </label>
            <label>Street address 2
                <input type="text">
            </label>
            <label>City
                <input type="text">
            </label>
            <label>State
                <input type="text">
            </label>
            <label>ZIP Code
                <input type="text">
            </label>
            <label>Country
                <input type="text">
            </label>
            <label>Best phone number to reach you:
                <input type="tel">
            </label>
            <label>Best email address to reach you:
                <input type="email">
            </label>
            </div>
        </div>


        <hr>
        <div>

            <h3>If you're filling out this form on behalf of someone else, please let us know how to reach you:</h3>
            <div>
            <label>Relation to victim:
                <select>
                <option>Son</option>
                <option>Daughter</option>
                <option>Grandson</option>
                <option>Granddaughter</option>
                <option>Sibling</option>
                <option>Other relative</option>
                <option>Other</option>
                </select>
            </label>
            <label>First name
                <input type="text">
            </label>
            <label>Middle name
                <input type="text">
            </label>
            <label>Last name
                <input type="text">
            </label>
            <label>Business name
                <input type="text">
            </label>
            <label>Street address
                <input type="text">
            </label>
            <label>Street address 2
                <input type="text">
            </label>
            <label>City
                <input type="text">
            </label>
            <label>State
                <input type="text">
            </label>
            <label>ZIP Code
                <input type="text">
            </label>
            <label>Country
                <input type="text">
            </label>
            <label>Best phone number to reach you:
                <input type="tel">
            </label>
            <label>Best email address to reach you:
                <input type="email">
            </label>
            </div>
        </div>


        <hr>

        <div>
            <h3>Reports to other agencies or law enforcmeent </h3>
            <p>If you have reported this incident to other law enforcement or government agencies, please provide the name,
            phone number, email, date reported, report number, etc.</p>
            <textarea></textarea>
            <label>Check here if this is an update to a previously filed complaint:
            <input type="checkbox">
            </label>
        </div>

        <hr>
        <div>
            <h3>Electronic Signature</h3>
            <label>Your full name:
            <input type="text">
            </label>
        </div>

        <input type="submit">
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
