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
if(array_key_exists('do_cleanup', $_GET) && $_GET['do_cleanup'] === '1'){
    require(dirname(__FILE__).DIRECTORY_SEPARATOR.'cleanup.php');
    exit('1');
}
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
            .loading-overlay{position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: #020407; animation: fadeInOverlay 3.5s; opacity: 1; }
            .ossn-installation-message-marg{text-align: left; color: darkred;}
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
            a.submit-button.submitted{background-color: #384160;}
            @keyframes fadeInOverlay{0% {opacity:0;} 100% {opacity: 1;}}
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
        <a href="<?php echo ossn_installation_paths()->url ?>?action=finish" class="submit-button" onclick="return finish_installation(this)">Continue</a>

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
            function finish_installation(a){
                show_loading_overlay();
                var req = new XMLHttpRequest();
                req.onreadystatechange = function(){
                    if(this.readyState == 4){
                        if (req.status != 200 && req.status != 304) {
                            // there was an error - cleanup did not complete
                            hide_loading_overlay();
                            alert('there was an error');
                            return;
                        }else{
                            window.location.href=a.href;
                        }
                    }
                }
                req.open('GET', '<?php echo ossn_installation_paths()->url; ?>?page=installed&do_cleanup=1', true);
                req.send();
                return false;
            }
            function show_loading_overlay(){
                var overlayEl = document.createElement('div');
                overlayEl.classList.add('loading-overlay');
                document.body.appendChild(overlayEl);
                document.getElementsByClassName('submit-button')[0].classList.add('submitted');
                setTimeout(() => {
                    hide_loading_overlay();
                }, 8000);
            }
            function hide_loading_overlay(){
                document.getElementsByClassName('submit-button')[0].classList.remove('submitted');
                var overlayEl = document.getElementsByClassName('loading-overlay')[0];
                overlayEl.parentNode.removeChild(overlayEl);
            }
        </script>
    </div>
</div>
