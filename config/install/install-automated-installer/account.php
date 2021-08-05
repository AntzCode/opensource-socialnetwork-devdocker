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
    #progress{position: absolute; top: 18%; width: 100%;  }
    #progress.fadeIn{animation: fadeIn 1.2s;}
    #stage{display: none;}#stage.fadeIn{display: block;}
    #antzcode-logo{text-align: center; padding: 2em; }
    .fadeOut{animation: fadeOut 1.2s;}
    @keyframes fadeIn{0% {opacity: 0;} 100% {opacity: 1;}}
    @keyframes fadeOut{0% {opacity: 1;} 100% {opacity: 0;}}
</style>
<div class="wrapper">
    <div id="antzcode-logo">
        <img src="<?php echo ossn_installation_paths()->url; ?>styles/antzcode-logo.svg" width="600" height="105" alt="AntzCode Ltd" />
    </div>
    <div id="progress">
        <h1>Automated Installation</h1>
        <p id="stage">Creating Administrator account...</p>
    </div>
    <form name="account" method="post" action="<?php echo ossn_installation_paths()->url; ?>?action=account">
        <input type="hidden" name="firstname" value=":|ADMIN_FIRSTNAME|:" />
        <input type="hidden" name="lastname" value=":|ADMIN_LASTNAME|:" />
        <input type="hidden" name="email" value=":|ADMIN_EMAIL|:" />
        <input type="hidden" name="email_re" value=":|ADMIN_EMAIL|:" />
        <input type="hidden" name="username" value=":|ADMIN_USERNAME|:" />
        <input type="hidden" name="password" value=":|ADMIN_PASSWORD|:" />
        <input type="hidden" name="birthday" value=":|ADMIN_BIRTH_DAY|:" />
        <input type="hidden" name="birthm" value=":|ADMIN_BIRTH_MONTH|:" />
        <input type="hidden" name="birthy" value=":|ADMIN_BIRTH_YEAR|:" />
        <input type="hidden" name="gender" value=":|ADMIN_GENDER|:" />
        <input type="submit" class="submit-btn" />
    </form>
    <script type="text/javascript">
        document.getElementsByClassName('ossn-default')[0].parentNode.classList.add('outer-wrapper');
        setTimeout(() => {
            document.getElementById('stage').classList.add('fadeIn');
        }, 900);
        setTimeout(() => {
            document.getElementById('progress').classList.add('fadeOut');
        }, 2800);
        setTimeout(() => {
            document.getElementById('progress').style.display="none";
            document.forms['account'].submit();
        }, 3800);
    </script>
</div>
