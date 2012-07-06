<?defined('_JEXEC') or die('Restricted access');?>

<?if(get_access('admin','setting','view')):?>
<?if(!empty($message[0])):?>
     <div class="<?=$message[0]?>_box">
	<?=$message[1]?>
     </div>
<?endif;?>

<style>
.alert{display:none}
.inputbox {
	width:200px;
	color:#555;
	font:12px tahoma;
}
textarea.inputbox {
	height:70px;
}
</style>

<form method="post" action="" enctype="multipart/form-data"/>
<input type="hidden" name="event" value="setting"/>
<input type="hidden" name="update" value="1"/>

<h2>Настроки постинга</h2>
<table class="formadd">
		<tr><td class="td1">Логин Вконтакте</td>
		<td><input class="inputbox" type="text" name="vklogin" value="<?=$registry['vklogin']?>"/></td>
		</td></tr>

		<tr><td class="td1">Пароль Вконтакте</td>
		<td><input class="inputbox" type="text" name="vkpass" value="<?=$registry['vkpass']?>"/></td>
		</td></tr>

		<tr><td class="td1">Группа/Паблик Вконтакте (url)</td>
		<td><input class="inputbox" type="text" name="vkgroup" value="<?=$registry['vkgroup']?>"/><br/>
		пример: http://vk.com/club34025331</td>
		</td></tr>

		<tr><td class="td1">Периодичность постинга</td>
		<td>
		<select name="vkperiod" class="inputbox" id="alert">
			<option value="0" <?if($registry['vkperiod']==0):?>selected<?endif?>>Постинг отключен</option>
			<option value="1" <?if($registry['vkperiod']==1):?>selected<?endif?>>Раз в час</option>
			<option value="2" <?if($registry['vkperiod']==2):?>selected<?endif?>>Раз в день</option>
			<option value="3" <?if($registry['vkperiod']==3):?>selected<?endif?>>Раз в неделю</option>
			<option value="4" <?if($registry['vkperiod']==4):?>selected<?endif?>>Раз в месяц</option>
			<option value="5" <?if($registry['vkperiod']==5):?>selected<?endif?>>Указать интервал в минутах</option>
			<option value="6" <?if($registry['vkperiod']==6):?>selected<?endif?>>Случайное значение (от 20 мин. до 3 ч.)</option>
		</select>
		</td>

		<tr><td class="td1 alert">Интервал в минутах</td>
		<td class="alert"><input class="inputbox" type="text" name="vkinterval" value="<?=$registry['vkinterval']?>"/></td>
		</td></tr>

</table>

<input type="submit" value="Сохранить" />
</form>

<p align="center"><a href="index.php?component=cron" style="color:red">СТАРТ: опубликовать одну запись</a></p>

<?endif;?>

<script type="text/javascript">
$(document).ready(function(){
                $("#alert").change(function() {
                    var id = $("#alert option:selected").val();
		    if(id==5)$(".alert").show();else $(".alert").hide();
		})
		var id="<?=$registry['vkperiod']?>";
	       if(id==5)$(".alert").show();else $(".alert").hide();
            });
</script>