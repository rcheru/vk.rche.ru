            <div class="sidebar_box">
                <div class="sidebar_box_top"></div>
                <div class="sidebar_box_content">
                <h3>Информация</h3>
                <img src="<?=$theme_admin?>images/info.png" alt="" title="" class="sidebar_icon_right" />
                <p>
		<table>
		<tr><td width="120">PHP >= 5.0</td><td><?if(floatval(phpversion())>='5.0'):?><span style="color:green"><b>Да</b></span><?else:?><span style="color:red"><b>Нет</b></span><?endif?></td></tr>
		<tr><td width="120">Поддержка Zlib</td><td><?if(extension_loaded('zlib')):?><span style="color:green"><b>Да</b></span><?else:?><span style="color:red"><b>Нет</b></span><?endif?></td></tr>
		<tr><td width="120">Поддержка XML</td><td><?if(extension_loaded('xml')):?><span style="color:green"><b>Да</b></span><?else:?><span style="color:red"><b>Нет</b></span><?endif?></td></tr>
		<tr><td width="120">Поддержка DOM</td><td><?if(extension_loaded('dom')):?><span style="color:green"><b>Да</b></span><?else:?><span style="color:red"><b>Нет</b></span><?endif?></td></tr>
		<tr><td width="120">Поддержка GD</td><td><?if(extension_loaded('gd')):?><span style="color:green"><b>Да</b></span><?else:?><span style="color:red"><b>Нет</b></span><?endif?></td></tr>
		<tr><td width="120">Поддержка MySQL</td><td><?if((function_exists('mysql_connect') || function_exists('mysqli_connect'))):?><span style="color:green"><b>Да</b></span><?else:?><span style="color:red"><b>Нет</b></span><?endif?></td></tr>
		</table>
		</p>
                </div>
                <div class="sidebar_box_bottom"></div>
            </div>
