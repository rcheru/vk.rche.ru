function showtab(id){
names = new Array ("tabname_1","tabname_2"); //������ id ���������� �����
conts= new Array ("tabcontent_1","tabcontent_2"); //������ id �����
for(i=0;i<names.length;i++) {
document.getElementById(names[i]).className = 'nonactive';
}
for(i=0;i<conts.length;i++) {
document.getElementById(conts[i]).className = 'hide';
}
document.getElementById('tabname_' + id).className = 'active';
document.getElementById('tabcontent_' + id).className = 'show';
}