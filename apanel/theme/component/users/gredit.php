<?defined('_JEXEC') or die('Restricted accessA');?>
<?if(get_access('admin','group','edit')):?>
<h2>Редактировать группу</h2>
<form method="post" action="?component=users&section=group"/>
<input type="hidden" name="event" value="users"/>
<input type="hidden" name="gredit" value="1"/>
<input type="hidden" name="idd" value="<?=$registry['groupitem'][0]['id']?>"/>
<table class="formadd">
<tr><td class="td1">Название группы</td><td><input class="inputbox" type="text" name="name" value="<?=$registry['groupitem'][0]['name']?>"/></td></tr>
</table>
<span class="title-table">Права группы. Админпанель.</span>
<table class="formadd">
<tr>
	<td class="td1 w150"></td>
	<td align="center">Просмотр</td>
	<td align="center">Редактирование</td>
	<td align="center">Удаление</td>
	<td align="center">Только свои</td>
</tr>


<tr>
	<td class="td1 w150">Недвижимость</td>
	<td align="center"><input class="" type="checkbox" name="accessA[realty][view]" value="1" <?if(intval($registry['groupitem'][0]['accessA']['realty']['view'])==1):?>checked<?endif?>></td>
	<td align="center"><input class="" type="checkbox" name="accessA[realty][edit]" value="1" <?if(intval($registry['groupitem'][0]['accessA']['realty']['edit'])==1):?>checked<?endif?>></td>
	<td align="center"><input class="" type="checkbox" name="accessA[realty][del]" value="1" <?if(intval($registry['groupitem'][0]['accessA']['realty']['del'])==1):?>checked<?endif?>></td>
	<td align="center"><input class="" type="checkbox" name="accessA[realty][onmy]" value="1" <?if(intval($registry['groupitem'][0]['accessA']['realty']['onmy'])==1):?>checked<?endif?>></td>
</tr>

<tr>
	<td class="td1 w150">Управление данными</td>
	<td align="center"><input class="" type="checkbox" name="accessA[editors][view]" value="1" <?if(intval($registry['groupitem'][0]['accessA']['editors']['view'])==1):?>checked<?endif?>></td>
	<td align="center"><input class="" type="checkbox" name="accessA[editors][edit]" value="1" <?if(intval($registry['groupitem'][0]['accessA']['editors']['edit'])==1):?>checked<?endif?>></td>
	<td align="center"><input class="" type="checkbox" name="accessA[editors][del]" value="1" <?if(intval($registry['groupitem'][0]['accessA']['editors']['del'])==1):?>checked<?endif?>></td>
	<td align="center"></td>
</tr>

<!--<tr>
	<td class="td1 w150">Жилые комплексы</td>
	<td align="center"><input class="" type="checkbox" name="accessA[complex][view]" value="1" <?if(intval($registry['groupitem'][0]['accessA']['complex']['view'])==1):?>checked<?endif?>></td>
	<td align="center"><input class="" type="checkbox" name="accessA[complex][edit]" value="1" <?if(intval($registry['groupitem'][0]['accessA']['complex']['edit'])==1):?>checked<?endif?>></td>
	<td align="center"><input class="" type="checkbox" name="accessA[complex][del]" value="1" <?if(intval($registry['groupitem'][0]['accessA']['complex']['del'])==1):?>checked<?endif?>></td>
	<td align="center"><input class="" type="checkbox" name="accessA[complex][onmy]" value="1" <?if(intval($registry['groupitem'][0]['accessA']['complex']['onmy'])==1):?>checked<?endif?>></td>
</tr>-->

<tr>
	<td class="td1 w150">Материалы</td>
	<td align="center"><input class="" type="checkbox" name="accessA[article][view]" value="1" <?if(intval($registry['groupitem'][0]['accessA']['article']['view'])==1):?>checked<?endif?>></td>
	<td align="center"><input class="" type="checkbox" name="accessA[article][edit]" value="1" <?if(intval($registry['groupitem'][0]['accessA']['article']['edit'])==1):?>checked<?endif?>></td>
	<td align="center"><input class="" type="checkbox" name="accessA[article][del]" value="1" <?if(intval($registry['groupitem'][0]['accessA']['article']['del'])==1):?>checked<?endif?>></td>
	<td align="center"><input class="" type="checkbox" name="accessA[article][onmy]" value="1" <?if(intval($registry['groupitem'][0]['accessA']['article']['onmy'])==1):?>checked<?endif?>></td>
</tr>
<tr>
	<td class="td1 w150">Ктагории материалов</td>
	<td align="center"><input class="" type="checkbox" name="accessA[category][view]" value="1" <?if(intval($registry['groupitem'][0]['accessA']['category']['view'])==1):?>checked<?endif?>></td>
	<td align="center"><input class="" type="checkbox" name="accessA[category][edit]" value="1" <?if(intval($registry['groupitem'][0]['accessA']['category']['edit'])==1):?>checked<?endif?>></td>
	<td align="center"><input class="" type="checkbox" name="accessA[category][del]" value="1" <?if(intval($registry['groupitem'][0]['accessA']['category']['del'])==1):?>checked<?endif?>></td>
	<td align="center"></td>
</tr>
<tr>
	<td class="td1 w150">Комментарии</td>
	<td align="center"><input class="" type="checkbox" name="accessA[comments][view]" value="1" <?if(intval($registry['groupitem'][0]['accessA']['comments']['view'])==1):?>checked<?endif?>></td>
	<td align="center"><input class="" type="checkbox" name="accessA[comments][edit]" value="1" <?if(intval($registry['groupitem'][0]['accessA']['comments']['edit'])==1):?>checked<?endif?>></td>
	<td align="center"><input class="" type="checkbox" name="accessA[comments][del]" value="1" <?if(intval($registry['groupitem'][0]['accessA']['comments']['del'])==1):?>checked<?endif?>></td>
	<td align="center"></td>
</tr>
<tr>
	<td class="td1 w150">Пользователи</td>
	<td align="center"><input class="" type="checkbox" name="accessA[user][view]" value="1" <?if(intval($registry['groupitem'][0]['accessA']['user']['view'])==1):?>checked<?endif?>></td>
	<td align="center"><input class="" type="checkbox" name="accessA[user][edit]" value="1" <?if(intval($registry['groupitem'][0]['accessA']['user']['edit'])==1):?>checked<?endif?>></td>
	<td align="center"><input class="" type="checkbox" name="accessA[user][del]" value="1" <?if(intval($registry['groupitem'][0]['accessA']['user']['del'])==1):?>checked<?endif?>></td>
	<td align="center"><input class="" type="checkbox" name="accessA[user][onmy]" value="1" <?if(intval($registry['groupitem'][0]['accessA']['user']['onmy'])==1):?>checked<?endif?>></td>
</tr>
<tr>
	<td class="td1 w150">Группы пользователей</td>
	<td align="center"><input class="" type="checkbox" name="accessA[group][view]" value="1" <?if(intval($registry['groupitem'][0]['accessA']['group']['view'])==1):?>checked<?endif?>></td>
	<td align="center"><input class="" type="checkbox" name="accessA[group][edit]" value="1" <?if(intval($registry['groupitem'][0]['accessA']['group']['edit'])==1):?>checked<?endif?>></td>
	<td align="center"><input class="" type="checkbox" name="accessA[group][del]" value="1" <?if(intval($registry['groupitem'][0]['accessA']['group']['del'])==1):?>checked<?endif?>></td>
	<td align="center"></td>
</tr>

<tr>
	<td class="td1 w150">Опросы</td>
	<td align="center"><input class="" type="checkbox" name="accessA[vote][view]" value="1" <?if(intval($registry['groupitem'][0]['accessA']['vote']['view'])==1):?>checked<?endif?>></td>
	<td align="center"><input class="" type="checkbox" name="accessA[vote][edit]" value="1" <?if(intval($registry['groupitem'][0]['accessA']['vote']['edit'])==1):?>checked<?endif?>></td>
	<td align="center"><input class="" type="checkbox" name="accessA[vote][del]" value="1" <?if(intval($registry['groupitem'][0]['accessA']['vote']['del'])==1):?>checked<?endif?>></td>
	<td align="center"><input class="" type="checkbox" name="accessA[vote][onmy]" value="1" <?if(intval($registry['groupitem'][0]['accessA']['vote']['onmy'])==1):?>checked<?endif?>></td>
</tr>

<tr>
	<td class="td1 w150">Инструменты</td>
	<td align="center"><input class="" type="checkbox" name="accessA[tools][view]" value="1" <?if(intval($registry['groupitem'][0]['accessA']['tools']['view'])==1):?>checked<?endif?>></td>
	<td align="center"><input class="" type="checkbox" name="accessA[tools][edit]" value="1" <?if(intval($registry['groupitem'][0]['accessA']['tools']['edit'])==1):?>checked<?endif?>></td>
	<td align="center"><input class="" type="checkbox" name="accessA[tools][del]" value="1" <?if(intval($registry['groupitem'][0]['accessA']['tools']['del'])==1):?>checked<?endif?>></td>
	<td align="center"></td>
</tr>

<tr>
	<td class="td1 w150">Напоминания</td>
	<td align="center"><input class="" type="checkbox" name="accessA[alert][view]" value="1" <?if(intval($registry['groupitem'][0]['accessA']['alert']['view'])==1):?>checked<?endif?>></td>
	<td align="center"><input class="" type="checkbox" name="accessA[alert][edit]" value="1" <?if(intval($registry['groupitem'][0]['accessA']['alert']['edit'])==1):?>checked<?endif?>></td>
	<td align="center"><input class="" type="checkbox" name="accessA[alert][del]" value="1" <?if(intval($registry['groupitem'][0]['accessA']['alert']['del'])==1):?>checked<?endif?>></td>
	<td align="center"><input class="" type="checkbox" name="accessA[alert][onmy]" value="1" <?if(intval($registry['groupitem'][0]['accessA']['alert']['onmy'])==1):?>checked<?endif?>></td>
	<td align="center"></td>
</tr>

<tr>
	<td class="td1 w150">Настройки</td>
	<td align="center"><input class="" type="checkbox" name="accessA[setting][view]" value="1" <?if(intval($registry['groupitem'][0]['accessA']['setting']['view'])==1):?>checked<?endif?>></td>
	<td align="center"><input class="" type="checkbox" name="accessA[setting][edit]" value="1" <?if(intval($registry['groupitem'][0]['accessA']['setting']['edit'])==1):?>checked<?endif?>></td>
	<td align="center"><input class="" type="checkbox" name="accessA[setting][del]" value="1" <?if(intval($registry['groupitem'][0]['accessA']['setting']['del'])==1):?>checked<?endif?>></td>
	<td align="center"></td>
</tr>

<tr>
	<td class="td1 w150">Статистика</td>
	<td align="center"><input class="" type="checkbox" name="accessA[stat][view]" value="1" <?if(intval($registry['groupitem'][0]['accessA']['stat']['view'])==1):?>checked<?endif?>></td>
	<td align="center"></td>
	<td align="center"></td>
	<td align="center"></td>
</tr>
</table>


<a href="index.php?component=users&section=group"><< Назад</a> <input type="submit" value="Изменить" />
</form>
<?endif;?>