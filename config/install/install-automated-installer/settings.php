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
<style type="text/css">
    html{height: 100%}
    body{
        height: 100%; padding: 0; color: #FFFFFF; font-family: arial;
        background: #01042e; text-align: center;
    }
    .outer-wrapper{height: 100%; width: 1280px !important; }
    .wrapper{
        max-width: 1180px; height: 900px; margin: 0em auto;
        background: url(<?php echo ossn_installation_paths()->url; ?>styles/antzcode-background.svg);
        background-repeat: no-repeat; background-size: contain; background-position: center; position: relative;
    }
    .submit-btn{display: none; }
    .ossn-installation-message-marg{text-align: left; color: darkred;}
    #progress{position: absolute; top: 18%; width: 100%;}
    #progress.fadeIn{animation: fadeIn 1.2s;}
    #stage{display: none;}#stage.fadeIn{display: block;}
    #antzcode-logo{text-align: center; padding: 2em; animation: fadeIn 1.2s;}
    .fadeOut{animation: fadeOut 1.2s;}
    @keyframes fadeIn{0% {opacity: 0;} 100% {opacity: 1;}}
    @keyframes fadeOut{0% {opacity: 1;} 100% {opacity: 0;}}
</style>
<div class="wrapper">
    <div id="antzcode-logo">
        <img src="<?php echo ossn_installation_paths()->url; ?>styles/antzcode-logo.svg" width="600" height="105" alt="AntzCode Ltd" />
    </div>
    <div id="progress" class="fadeIn">
        <h1>Automated Installation</h1>
        <p id="stage">Creating database...</p>
    </div>
    <form name="database" method="post" action="<?php echo ossn_installation_paths()->url; ?>?action=install">
        <input type="hidden" name="dbuser" value=":|MARIADB_USER|:" />
        <input type="hidden" name="dbpwd" value=":|MARIADB_PASSWORD|:" />
        <input type="hidden" name="dbname" value=":|MARIADB_DATABASE|:" />
        <input type="hidden" name="dbhost" value=":|MARIADB_HOST|:" />
        <input type="hidden" name="sitename" value=":|WEBSITE_NAME|:" />
        <input type="hidden" name="owner_email" value=":|CONTACT_EMAIL|:" />
        <input type="hidden" name="notification_email" value=":|CONTACT_EMAIL|:" />
        <input type="hidden" name="url" value="<?php echo OssnInstallation::url(); ?>" />
        <input type="hidden" name="datadir" value=":|OSSN_DATA_DIRECTORY|:" />
        <input type="submit" class="submit-btn" />
    </form>
    <script type="text/javascript">
        document.getElementsByClassName('ossn-default')[0].parentNode.classList.add('outer-wrapper');
        setTimeout(() => {
            document.getElementById('stage').classList.add('fadeIn');
        }, 900);
        setTimeout(() => {
            document.getElementById('progress').classList.remove('fadeIn');
            document.getElementById('stage').classList.add('fadeOut');
        }, 2800);
        setTimeout(() => {
            document.forms['database'].submit();
        }, 3200);
        setTimeout(() => {
            document.getElementById('stage').style.display="none";
        }, 3800);
    </script>
</div>
