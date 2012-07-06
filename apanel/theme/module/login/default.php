<?defined('_JEXEC') or die('Restricted access');?>
<?if ( @!$user->is_loaded() ):?>
    <div class="header_login">
    <div class="logo"><img src="<?=$theme_admin?>images/logo.png" width="175" height="60" alt="" title="" border="0" /></div>
    </div>
         <div class="login_form">
         <h3>Администрирование</h3>
         <!--<a href="#" class="forgot_pass">Забыли пароль?</a> -->
         <form action="" method="post" class="niceform">
                <fieldset>
                    <dl>
                        <dt><label for="uname">Логин:</label></dt>
                        <dd><input type="text" name="uname" size="54" /></dd>
                    </dl>
                    <dl>
                        <dt><label for="pwd">Пароль:</label></dt>
                        <dd><input alt="password" type="password" name="pwd" size="54" /></dd>
                    </dl>
                    
                    <dl>
                        <dt><label></label></dt>
                        <dd>
                    <input type="checkbox" name="remember" id="" value="" /><label class="check_label">Запомнить меня</label>
                        </dd>
                    </dl>
                    
                     <dl class="submit">
                    <input type="submit" name="submit" id="submit" value="Войти" />
                     </dl>
                    
                </fieldset>
                
         </form>
         </div>  
    <div class="footer_login">
    	<div class="left_footer_login">Powered by <a href="http://rche.ru">rcheCMS</a></div>
    </div>

<?else:?>
	<?if ($user->is_active()):?>
	<div class="header">
	    <div class="logo"><a href="#"><img src="<?=$theme_admin?>images/logo.png" alt="" title="" border="0" /></a></div>
	    <div class="right_header">Привет <b><?=$user->get_property('username');?></b>, <a href="?logout=1" class="logout">Выход</a></div>
	</div>
	<?endif;?>
<?endif;?>
