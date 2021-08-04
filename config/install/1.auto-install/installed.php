<?php
/**
 * Open Source Social Network - AntzCode DevDocker Automated Installer
 *
 * @package   AntzCode
 * @author    AntzCode Ltd
 * @copyright (C) AntzCode Ltd
 * @license   GPLv3 https://raw.githubusercontent.com/AntzCode/opensource-socialnetwork-devdocker/main/LICENSE
 * @link      https://github.com/AntzCode/opensource-socialnetwork-devdocker
 */
?>
<?php
define('OSSN_ALLOW_SYSTEM_START', TRUE);
require_once(dirname(dirname(dirname(__FILE__))) . '/system/start.php');
?>
<div>
    <div class="layout-installation">
        <style type="text/css">
            html{height: 100%; }
            body{
                height: 100%; padding: 0;
                color: #FFFFFF; text-align: center;
                background: #01042e url(<?php echo ossn_installation_paths()->url; ?>styles/antzcode-background.svg);
                background-repeat: no-repeat; background-size: contain; background-position: center;
            }
            .ossn-installation-message{text-align: left;}
            .layout-installation{border: none; background: none; font-size: 1.2em;}
            #antzcode-logo{text-align: center;}
            .credentials{
                background: #000000; color: #FFFFFF; padding: 1em; width: 20em; border: solid 2px #FFFFFF;
                margin: 4em auto; animation: fadeIn 0.67s
            }
            .submit-button{
                margin: 4em auto; display: inline-block; border: solid 1px #FFFFFF; color: #FFFFFF; background: #004fa6; font-size: 1em; font-weight: bold;
                width: 8%; text-align: center; text-decoration: none; padding: 1em; opacity: 0;
            }
            a.submit-button:hover {
                background-color: #1177e8;
                position: relative;
                left: -1px;
                top: -1px;
                box-shadow: 1px 1px 25px 0px rgba(13, 130, 255, 0.42);
            }
            @keyframes fadeIn{0% {opacity: 0;} 100% {opacity: 1;}}
            @keyframes fadeOut{0% {opacity: 1;} 100% {opacity: 0;}}
            .fade-out{animation: fadeOut 1.2s; }
            .fade-in{animation: fadeIn 1.2s; }
        </style>
        <div id="antzcode-logo">
            <img src="<?php echo ossn_installation_paths()->url; ?>styles/antzcode-logo.svg" width="600" height="105" alt="AntzCode Ltd" />
        </div>
        <h1>Automatically installed by AntzCode!</h1>
        <p>The Administrator account was created from the settings in the .env file.</p>
<pre class="credentials">
Username: :|ADMIN_USERNAME|:
Password: :|ADMIN_PASSWORD|:
</pre>
        <p>You should change your password if you think other people might be able to log in with it.</p>
        <p>You will now be redirected to the login form. Have fun!</p>
        <a href="<?php echo ossn_installation_paths()->url ?>?action=finish" class="submit-button">Continue</a>

        <script type="text/javascript">
            var installNotice = document.getElementsByClassName('ossn-installation-message')[0];
            var credentials = document.getElementsByClassName('credentials')[0];
            setTimeout(() => {
                var goButton = document.getElementsByClassName('submit-button')[0];
                credentials.classList.add('fade-in');
                goButton.innerText = 'Continue';
                setTimeout(() => {
                    goButton.classList.add('fade-in');
                    goButton.style.opacity = '1';
                }, 1190);
            }, 0);
            setTimeout(() => {
                var installNotice = document.getElementsByClassName('ossn-installation-message')[0];
                installNotice.classList.add('fade-out');
                setTimeout(() => {
                    installNotice.style.opacity = '0';
                }, 1190);
            }, 2200);
        </script>
    </div>
</div>
