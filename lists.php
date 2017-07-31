<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script>
        var countryList,cityList,hotelsList;
        function loadCities(id){
            hotelsList.innerHTML="";
            var xhr = new XMLHttpRequest();
            xhr.open("GET","getList.php?name=city&id="+id);
            xhr.onreadystatechange=function () {
                if(xhr.readyState!=4) return;
                var countries = JSON.parse(xhr.responseText);
                var text="";
                countries.forEach(function (elem) {
                    text+= "<option value='"+elem.id+"'>"+elem.name+"</option>";
                });
                cityList.innerHTML=text;
                loadHotels(cityList.value);
            };
            xhr.send();
        }
        function loadHotels(id){
            var xhr = new XMLHttpRequest();
            xhr.open("GET","getList.php?name=hotels&id="+id);
            xhr.onreadystatechange=function () {
                if(xhr.readyState!=4) return;
                var countries = JSON.parse(xhr.responseText);
                var text="";
                countries.forEach(function (elem) {
                    text+= "<option value='"+elem.id+"'>"+elem.name+"</option>";
                });
                hotelsList.innerHTML=text;
            }
            xhr.send();
        }


        window.onload=function () {
            countryList = document.getElementById("countries");
            cityList = document.getElementById("cities");
            hotelsList = document.getElementById("hotels");
            countryList.addEventListener("change",function (e) {
                loadCities(this.value);
            })
            cityList.addEventListener("change",function (e) {
                loadHotels(this.value);
            })
            loadCities(countryList.value);
        }
    </script>
</head>
<body>
<select  id="countries">
    <?php foreach ($countries as $country):?>
        <option value="<?=$country["id"]?>"><?=$country["name"]?></option>
    <?php endforeach; ?>
</select>
<select  id="cities">

</select>
<select  id="hotels">

</select>
</body>
</html>