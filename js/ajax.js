function startParse()
{
    $.ajax(
    {
        type: "POST",
        url: "ajax.php",
        data:
        {
            command: "startParse"
        }
    }).done(function( data )
    {
        $('#id_success').hide();
        $('#id_danger').hide();
        
        if (data == "SUCCESS")
        {
            $('#id_success').html("Les tables ont bien été générées et remplies.");
            $('#id_success').show();
        }
        else
        {
            $('#id_danger').html(data);
            $('#id_danger').show();
        }
    });
}

function deleteTablesAction()
{
    $.ajax(
    {
        type: "POST",
        url: "ajax.php",
        data:
        {
            command: "deleteTables"
        }
    }).done(function( data )
    {
        $('#id_success').hide();
        $('#id_danger').hide();
        
        if (data == "SUCCESS")
        {
            $('#id_success').html("La suppression a bien été effectuée");
            $('#id_success').show();
        }
        else
        {
            $('#id_danger').html(data);
            $('#id_danger').show();
        }
    });
}
