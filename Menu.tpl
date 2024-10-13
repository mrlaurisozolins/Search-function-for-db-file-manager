<div style="float:right; padding-right:10px; font-size:14px;">
  <form name="SearchForm" action="[:URL:]/Data/Search" method="POST" style="display:block; float:left; display:[:NoAdmin:]">
    <input type="text" name="Search" value="[:SearchStr:]" style="width:150px;"/>&nbsp;
    <select name="Period">
      <option value="99" [:SearchP99:]>[[:AllPeriod:]]</option>
      <option value="5" [:SearchP5:]>[[:Today:]]</option>
      <option value="7" [:SearchP7:]>[[:Week:]]</option>
      <option value="1" [:SearchP1:]>[[:LastMonth:]]</option>
      <option value="4" [:SearchP4:]>[[:LastYear:]]</option>
    </select>
    <select name="Sort">
        <option value="2" [:Sort2:]>[[:SortByID:]]</option>
        <option value="1" [:Sort1:]>[[:SortByDate:]]</option>
    </select>
    <input type="checkbox" name="FindDeleted" [:FindDeleted:] value="1" style="width:15px; position:relative; top:2px; "/>
    <input type="submit" value="[[:Search:]]">
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  </form>

  [:Login:]: <a class="menu Logout" href="[:URL:]/Logout">[[:Logout:]]</a>
</div>

<a class="menu" href="[:URL:]/Data" title="Ieraksti" style="color:#52ff33;">Ieraksti</a>
<a class="menu" href="[:URL:]/Users" title="Lietotāji" style="color:#fff933;">Lietotāji</a>
<a class="menu" href="[:URL:]/Types" title="Tipi" style="color:#900C3F;">Tipi</a>
<a class="menu" href="[:URL:]/Orders" title="Pasūtījumi" style="color:#08cdda;">Pasūtījumi</a>
<a class="menu" style="display:[:NoAdmin:]; color:#f3e800;" href="[:URL:]/Filters" title="Filtri">Filtri</a>
<a class="menu" href="[:URL:]/Rights" title="Tiesības" style="color:#f72201;">Tiesības</a>
<a class="menu" href="[:URL:]/Task" title="Uzdevumi" style="color:#ff8d33;">Uzdevumi</a>
<a class="menu" href="[:URL:]/Warehous" title="Noliktava" style="color:#a99f50;">Noliktava</a>
<a class="menu" href="http://192.168.111.200/search/search.php" title="Meklēt" style="color:#ce33ff;">Meklēt</a>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
