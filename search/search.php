<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <title>Meklēšanas funkcija</title>
    <link rel="stylesheet" type="text/css" href="{{B}}template/main/main.css" />
    <link rel="stylesheet" type="text/css" href="{{B}}template/main/forms.css" />
    
    <link rel="stylesheet" type="text/css" href="style.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<div id="searchContainer">
    <span class="close-button" onclick="window.location.href='http://192.168.111.200/lv/Data';">&times;</span>
    
    <h3>Meklēšana pēc ID:</h3>
    <form id="searchForm" method="POST">
        <button type="submit">Meklēt</button>
        <input type="text" id="searchName" name="searchName" placeholder="Dokumenta ID" required>
    </form>

    <div id="loadingIndicator"></div>

    <div id="searchResults"></div>
</div>

<script>
$(document).ready(function(){
    $('#searchForm').on('submit', function(e) {
        e.preventDefault();
        var searchName = $('#searchName').val().trim();

        if (!/^\d{6,8}$/.test(searchName)) {
            $('#searchResults').html('<p>Nederīgs formāts, lūdzu 6, 7 vai 8 ciparu ID.</p>');
            console.log('Invalid input: ' + searchName); 
            return;
        }

        $('#loadingIndicator').show();
        $('#searchResults').html('');

        console.log('Submitting search with ID: ' + searchName); 

        $.ajax({
            url: 'http://192.168.111.200/search/searchProcess.php', 
            type: 'POST',
            data: { searchName: searchName },
            success: function (data) {
                $('#loadingIndicator').hide();
                try {
                    console.log('Raw response:', data); 
                    var result = JSON.parse(data);
                    if (result.success) {
                        var html = '';
                        result.entries.forEach(function(entry) {
                            html += '<div class="result-item">';
                            html += '<div class="path"><strong>Ceļš:</strong> ' + entry.path + '</div>';
                            html += '<button onclick="window.open(\'' + entry.url + '\', \'_blank\')">Atvērt failu menedžerī</button>';
                            html += '</div>';
                        });
                        $('#searchResults').html(html);
                    } else {
                        $('#searchResults').html('<p>' + result.message + '</p>'); 
                    }
                } catch (e) {
                    $('#searchResults').html('<p>Nesaprotams atbildes formāts.</p>');
                    console.error('JSON parse error:', e); 
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('#loadingIndicator').hide();
                console.error('AJAX error: ', textStatus, errorThrown);  
                $('#searchResults').html('<p>Radās kļūda, pieslēdzoties failu sistēmai: ' + textStatus + ' - ' + errorThrown + '. Lūdzu, mēģiniet vēlreiz.</p>');
            }
        });
    });
});
</script>

</body>
</html>
