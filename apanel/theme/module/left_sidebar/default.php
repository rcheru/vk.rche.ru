<?if ($user->get_property('gid')>=22):?>
            <div class="sidebarmenu">
                <a class="menuitem_green submenuheader" href="">Записи</a>
                <div class="submenu">
                    <ul>
                    <li><a href="?component=status">Каталог записей</a></li>
                    <li><a href="?component=category">Категории записей</a></li>
                    </ul>
                </div>
            
                <a class="menuitem" href="index.php?component=users&section=edit&edit=2" >Профиль</a>
             
                <a class="menuitem_red" href="?component=settings">Настройки</a>
            </div>
<?endif;?>